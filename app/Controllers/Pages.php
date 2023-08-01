<?php

namespace App\Controllers;

class Pages extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Home | Desta Programming WEB'
        ];
        return view('pages/home', $data);
    }
    public function about()
    {
        $data = [
            'title' => 'About | Desta Programming WEB'
        ];
        return view('pages/about', $data);
    }
    public function contact()
    {
        $data = [
            'title' => 'Contact us | Desta Programming WEB',
            'alamat' => [
                [
                    'tipe' => 'Rumah',
                    'alamat' => 'Jl. abc no. 123',
                    'kota' => 'Magelang'
                ],
                [
                    'tipe' => 'Kantor',
                    'alamat' => 'Jl. def no. 321',
                    'kota' => 'Magelang'
                ]
            ]
        ];
        return view('/pages/contact', $data);
    }
}
