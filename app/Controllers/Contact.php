<?php

namespace App\Controllers;

class Contact extends BaseController
{
    public function index()
    {
         return view('pages/contact');
    }

    public function send()
    {
        $name    = $this->request->getPost('name');
        $email   = $this->request->getPost('email');
        $message = $this->request->getPost('message');

        return redirect()->back()->with('success', 'Pesan berhasil dikirim!');
    }
}


