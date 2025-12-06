<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\UserModel;

class Auth extends BaseController
{
    public function index()
    {
        return view('auth/login');
    }
    public function admin()
    {
        // Models
        $produkModel = new \App\Models\ProdukModel();
        $userModel   = new \App\Models\UserModel();

        // DB connection (untuk orders jika tabel ada)
        $db = \Config\Database::connect();

        // Products & Users
        $products = $produkModel->orderBy('produk_id', 'DESC')->findAll();
        $users    = $userModel->orderBy('user_id', 'DESC')->findAll();

        // Orders and sales (may be empty if table doesn't exist)
        $orders = [];
        $sales  = []; // will be array of numbers (last N days)

        if ($db->tableExists('orders')) {
            // recent orders for the "Recent Orders" panel (limit 6)
            $orders = $db->table('orders')
                ->orderBy('created_at', 'DESC')
                ->limit(6)
                ->get()
                ->getResultArray();

            // prepare sales for last 7 days (0..6)
            $days = 7;
            $startDate = date('Y-m-d', strtotime("-" . ($days - 1) . " days"));

            // sum totals per day (assumes column 'total' or 'grand_total' exists)
            $builder = $db->table('orders');
            // Prefer 'total' column; adjust if your schema uses a different column name.
            $rows = $builder
                ->select("DATE(created_at) AS day, SUM(total) AS total_sum")
                ->where('created_at >=', $startDate)
                ->groupBy('day')
                ->orderBy('day', 'ASC')
                ->get()
                ->getResultArray();

            // map results by day (YYYY-MM-DD) => total
            $map = [];
            foreach ($rows as $r) {
                $map[$r['day']] = (float) ($r['total_sum'] ?? 0);
            }

            // build sales array for each day in range (older -> newer)
            for ($i = $days - 1; $i >= 0; $i--) {
                $d = date('Y-m-d', strtotime("-$i days"));
                $sales[] = $map[$d] ?? 0;
            }

            // Note: dashboard view expects $orders array and $sales numeric array
        }

        return view('admin/dashboard', [
            'products' => $products,
            'users'    => $users,
            'orders'   => $orders,
            'sales'    => $sales,
        ]);
    }

    public function loginAuth()
    {
        $session = session();
        $userModel = new UserModel();

        $full_name = $this->request->getPost('full_name');
        $password_hash = $this->request->getPost('password_hash');

        $user = $userModel->where('full_name', $full_name)
            ->orWhere('email', $full_name)
            ->first();

        if ($user) {

            if (password_verify($password_hash, $user['password_hash'])) {

                $session->set([
                    'user_id' => $user['user_id'],
                    'full_name' => $user['full_name'],
                    'email' => $user['email'],
                    'role' => $user['role'],
                    'isLoggedIn' => true
                ]);

                if ($user['role'] === 'admin') {
                    return redirect()->to('admin/index');
                } else {
                    return redirect()->to('home');
                }
            } else {
                return redirect()->back()->with('error', 'Password Salah!');
            }
        } else {
            return redirect()->back()->with('error', 'Akun Tidak Ditemukan!');
        }
    }
    public function register()
    {
        return view('auth/register');
    }

    public function registerAuth()
    {
        $userModel = new UserModel();

        $full_name = $this->request->getPost('full_name');
        $email    = $this->request->getPost('email');
        $password_hash = $this->request->getPost('password_hash');
        $confirm  = $this->request->getPost('confirm');

        if ($password_hash !== $confirm) {
            return redirect()->back()->with('error', 'Password tidak sama!');
        }

        if ($userModel->where('email', $email)->orWhere('full_name', $full_name)->first()) {
            return redirect()->back()->with('error', 'Email atau full_name sudah digunakan!');
        }

        $userModel->insert([
            'full_name' => $full_name,
            'email'    => $email,
            'password_hash' => password_hash($password_hash, PASSWORD_DEFAULT),
            'role' => 'customer',
        ]);

        return redirect()->to('/login')->with('success', 'Register berhasil! Silahkan login.');
    }

    public function logout()
    {
        $session = session();

        $session->remove(['user_id', 'full_name', 'email', 'isLoggedIn']);

        return redirect()->to(base_url('/home'))->with('success', 'Anda berhasil logout.');
    }
}
