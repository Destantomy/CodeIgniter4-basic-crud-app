<?php

namespace App\Controllers;

use App\Models\KomikModel;

class Komik extends BaseController
{
    protected $komikModel;
    public function __construct() /*__constructor ini dipakai agar fungsi ini dpt dipakai dmn saja*/
    {
        $this->komikModel = new KomikModel();
    }

    public function index()
    {
        //$komik = $this->komikModel->findAll();/*digunakan untuk memanggil semua fungsi pengganti SELECT * FROM */
        $data = [
            'title' => 'Daftar Komik ',
            'komik' => $this->komikModel->getkomik() /*Panggil komikModel lalu panggil-
            method getKomik yang terdapat di dlmnya. getKomik tidak memakai parameter karena akan difindall*/
        ];
        return view('komik/index', $data);
    }

    public function detail($slug)
    {
        $data = [
            'title' => 'Detail Komik',
            'komik' => $this->komikModel->getKomik($slug)/*ini juga sama seperti index di atas-
             namun getKomik pakai parameter karena hanya akan menampilkan slug*/
        ];
        //Jika komik(slug) tidak ada di tabel
        if (empty($data['komik'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Judul komik ' . $slug . ' tidak ditemukan');
        }
        return view('komik/detail', $data);
    }

    public function create()
    {
        //session();
        $data = [
            'title' => 'Form Tambah Data Komik',
            'validation' => \Config\Services::validation()
        ];
        return view('komik/create', $data);
    }

    public function save()
    {
        //Validasi inputan
        //berikut adl syntax rule u/ pengkondisian apabila terdpt data yg sama diinputkan
        if (!$this->validate([
            //--> validasi sederhana 'judul' => 'required|is_unique[komik.judul]' /*berarti judul wajib diisi */
            //validasi lebih kompleks
            'judul' => [
                'rules' => 'required|is_unique[komik.judul]',
                'errors' => [
                    'required' => '{field} komik harus diisi',
                    'is_unique' => '{field} komik sudah terdaftar'
                ]
            ],
            'sampul' => [
                'rules' => 'uploaded[sampul]|max_size[sampul,1024]|is_image[sampul]|mime_in[sampul,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'uploaded' => 'Pilih gambar sampul terlebih dahulu',
                    'max_size' => 'Ukuran gambar terlalu besar',
                    'is_image' => 'Yang anda pilih bukan gambar',
                    'mime_in' => 'Yang anda pilih bukan gambar'
                ]
            ]
        ])) {
            //menampilkan hasil rule
            // $validation = \Config\Services::validation();
            // return redirect()->to('komik/create')->withInput()->with('validation', $validation);
            return redirect()->to('/komik/create')->withInput();
        }

        //syntax kelola gambar
        $fileSampul = $this->request->getFile('sampul');
        //pindahkan file ke folder img
        $fileSampul->move('img');
        //ambil nama sampul
        $namaSampul = $fileSampul->getName();

        /*//dd($this->request->getVar()); /*method baru ci4 yg akan mengambil
        data apapun yang akan diambil dari form */

        //perintah berikut digunakan untuk mengolah slug (One Piece = one-piece)
        $slug = url_title($this->request->getVar('judul'), '-', true);

        //berikut adalah cara insert ke db dengan konfigruasi model
        $this->komikModel->save([
            'judul' => $this->request->getVar('judul'),
            'slug' => $slug,
            'penulis' => $this->request->getVar('penulis'),
            'penerbit' => $this->request->getVar('penerbit'),
            'sampul' => $namaSampul
        ]);

        /*Flashdata = pesan yg sekali muncul setelah tambah data */
        session()->setFlashdata('pesan', 'Data berhasil ditambahkan');
        return redirect()->to('/komik'); //perintah untuk redirect halaman
    }

    public function delete($id)
    {
        $this->komikModel->delete($id);
        session()->setFlashdata('pesan', 'Data berhasil dihapus');
        return redirect()->to('/komik');
    }
    public function edit($slug)
    {
        $data = [
            'title' => 'Form Ubah Data Komik',
            'validation' => \Config\Services::validation(),
            'komik' => $this->komikModel->getKomik($slug)
        ];
        return view('komik/edit', $data);
    }
    public function update($id)
    {
        $komikLama = $this->komikModel->getKomik($this->request->getVar('slug'));
        if ($komikLama['judul'] == $this->request->getVar('judul')) {
            $rule_judul = 'required';
        } else {
            $rule_judul = 'required|is_unique[komik.judul]';
        }
        if (!$this->validate([
            //--> validasi sederhana 'judul' => 'required|is_unique[komik.judul]' /*berarti judul wajib diisi */
            //validasi lebih kompleks
            'judul' => [
                'rules' => $rule_judul,
                'errors' => [
                    'required' => '{field} komik harus diisi',
                    'is_unique' => '{field} komik sudah terdaftar'
                ]
            ]
        ])) {
            //menampilkan hasil rule
            $validation = \Config\Services::validation();
            return redirect()->to('komik/edit/' . $this->request->getVar('slug'))->withInput()->with('validation', $validation);
        }


        $slug = url_title($this->request->getVar('judul'), '-', true);
        $this->komikModel->save([
            'id' => $id,
            'judul' => $this->request->getVar('judul'),
            'slug' => $slug,
            'penulis' => $this->request->getVar('penulis'),
            'penerbit' => $this->request->getVar('penerbit'),
            'sampul' => $this->request->getVar('sampul')
        ]);
        session()->setFlashdata('pesan', 'Data berhasil diubah');
        return redirect()->to('/komik');
    }
}
