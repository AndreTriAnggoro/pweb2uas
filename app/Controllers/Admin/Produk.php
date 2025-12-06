<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ProdukModel;

class Produk extends BaseController
{
    public function index()
    {
        $model = new ProdukModel();
        $data['products'] = $model->findAll();

        return view('admin/produk/index', $data);
    }

    public function tambah()
    {
        return view('admin/produk/tambah', [
            'validation' => \Config\Services::validation()
        ]);
    }

    public function simpan()
    {
        // dd(123);
        if (!$this->validate([
            'nama' => [
                'rules' => 'required',
                'errors' => ['required' => 'Nama produk wajib diisi']
            ],
            'kategori' => [
                'rules' => 'required',
                'errors' => ['required' => 'Kategori wajib diisi']
            ],
            'harga' => [
                'rules' => 'required|numeric',
                'errors' => [
                    'required' => 'Harga wajib diisi',
                    'numeric' => 'Harga harus berupa angka'
                ]
            ],
            'stok' => [
                'rules' => 'required|integer',
                'errors' => [
                    'required' => 'Stok wajib diisi',
                    'integer' => 'Stok harus berupa angka'
                ]
            ],
            'image' => [
                'rules' => 'uploaded[image]|is_image[image]|mime_in[image,image/jpg,image/jpeg,image/png]|max_size[image,2048]',
                'errors' => [
                    'uploaded' => 'Gambar wajib diupload',
                    'is_image' => 'File harus berupa gambar',
                    'mime_in' => 'Format gambar harus JPG/JPEG/PNG',
                    'max_size' => 'Ukuran gambar maksimal 2MB'
                ]
            ],
            'deskripsi' => [
                'rules' => 'required',
                'errors' => ['required' => 'Deskripsi wajib diisi'],
            ],
        ])) {
            return redirect()->back()->withInput();
        }
        // dd(123);

        $file = $this->request->getFile('image');
        $namaFile = null;

        if ($file->isValid() && !$file->hasMoved()) {
            $namaFile = $file->getRandomName();
            $file->move('uploads/produk', $namaFile);
        }

        $slug = url_title($this->request->getPost('nama'), '-', true);

        $model = new ProdukModel();
        $model->save([
            'nama' => $this->request->getPost('nama'),
            'slug' => $slug,
            'kategori' => $this->request->getPost('kategori'),
            'harga' => $this->request->getPost('harga'),
            'stok' => $this->request->getPost('stok'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'image' => $namaFile,
            'rating' => $this->request->getPost('rating') ?: null
        ]);

        return redirect()->to('/admin/produk')
            ->with('success', 'Produk berhasil ditambahkan!');
    }


    public function ubah($id)
    {
        $model = new ProdukModel();
        $produk = $model->find($id);

        if (!$produk) {
            return redirect()->to('/admin/produk')->with('error', 'Produk tidak ditemukan');
        }

        return view('admin/produk/ubah', [
            'produk' => $produk,
            'validation' => \Config\Services::validation()
        ]);
    }

    public function update($id)
    {
        $model = new ProdukModel();
        $produk = $model->find($id);

        if (!$produk) {
            return redirect()->to('/admin/produk')->with('error', 'Produk tidak ditemukan');
        }

        if (!$this->validate([
            'nama' => [
                'rules' => 'required',
                'errors' => ['required' => 'Nama produk wajib diisi']
            ],
            'kategori' => [
                'rules' => 'required',
                'errors' => ['required' => 'Kategori wajib diisi']
            ],
            'harga' => [
                'rules' => 'required|numeric',
                'errors' => [
                    'required' => 'Harga wajib diisi',
                    'numeric' => 'Harga harus berupa angka'
                ]
            ],
            'stok' => [
                'rules' => 'required|integer',
                'errors' => [
                    'required' => 'Stok wajib diisi',
                    'integer' => 'Stok harus berupa angka'
                ]
            ],
            'image' => [
                'rules' => 'permit_empty|is_image[image]|mime_in[image,image/jpg,image/jpeg,image/png]|max_size[image,2048]',
                'errors' => [
                    'is_image' => 'File harus berupa gambar',
                    'mime_in' => 'Format gambar harus JPG/JPEG/PNG',
                    'max_size' => 'Ukuran gambar maksimal 2MB'
                ]
            ]
        ])) {
            return redirect()->back()->withInput();
        }

        $namaFile = $produk['image']; // Gunakan gambar lama sebagai default

        // Jika ada file baru
        $file = $this->request->getFile('image');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            // Hapus gambar lama jika ada
            if ($produk['image'] && file_exists('uploads/produk/' . $produk['image'])) {
                unlink('uploads/produk/' . $produk['image']);
            }

            $namaFile = $file->getRandomName();
            $file->move('uploads/produk', $namaFile);
        }

        // Generate slug dari nama
        $slug = url_title($this->request->getPost('nama'), '-', true);

        $model->update($id, [
            'nama' => $this->request->getPost('nama'),
            'slug' => $slug,
            'kategori' => $this->request->getPost('kategori'),
            'harga' => $this->request->getPost('harga'),
            'stok' => $this->request->getPost('stok'),
            'deskripsi' => $this->request->getPost('deskripsi') ?: null,
            'image' => $namaFile,
            'rating' => $this->request->getPost('rating') ?: null
        ]);

        return redirect()->to('/admin/produk')
            ->with('success', 'Produk berhasil diupdate!');
    }


    public function delete($id)
    {
        $model = new ProdukModel();
        $model->delete($id);

        return redirect()->to('/admin/produk')->with('success', 'Produk telah dihapus.');
    }
}
