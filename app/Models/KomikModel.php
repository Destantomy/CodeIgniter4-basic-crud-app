<?php

namespace App\Models;

use CodeIgniter\Model;

class KomikModel extends Model
{
    protected $table = 'komik';
    protected $useTimestamps = true;
    //berikut adalah perintah yg memberi tahu isi database mana saja yg kita boleh isi manual
    protected $allowedFields = ['judul', 'slug', 'penulis', 'penerbit', 'sampul'];

    public function getKomik($slug = false) /*default parameter false, jika  ada parameter cari pakai-
    yang where jika tidak ambil semua data komik*/
    {
        if ($slug == false) {
            return $this->findAll();
        }/*jika slug false, maka findall*/ else
            return $this->where(['slug' => $slug])->first();
    }/*jika ada slug tampilkan*/
}
