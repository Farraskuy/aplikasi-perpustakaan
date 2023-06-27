<?php

namespace App\Controllers;

use App\Models\PetugasModel;
use CodeIgniter\Config\Services;
use Config\App;

class Petugas extends BaseController
{
    protected $petugasModel;

    public function __construct()
    {
        $this->petugasModel = new PetugasModel();
    }

    public function index()
    {
        return $this->petugasModel->findAll();
    }

    public function detail($id)
    {
        $petugas = $this->petugasModel->where('id', $id)->first();
        if (empty($petugas)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Petugas dengan id "' . $id . '" tidak ditemukan');
        }
        $data = [
            "title" => "Petugas | " .  $petugas['nama'],
            "data" => $petugas
        ];

        return view('admin/detailPetugas', $data);
    }

    public function simpan()
    {
        if (!$this->validate([
            'nama' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Kolom {field} tidak boleh kosong',
                    'is_unique' => '{field} {value} sudah digunakan'
                ]
            ],
            'jenis_kelamin' => [
                'rules' => 'required|in_list[Laki-laki,Perempuan]',
                'errors' => [
                    'required' => 'Harap pilih jenis kelamin yang sesuai',
                    'in_list' => 'Harap pilih jenis kelamin yang sesuai',
                ]
            ],
            'agama' => [
                'rules' => 'required|in_list[Islam,Kristen,Protestan,Hindu,Buddha,Konghucu,Lainnya]',
                'errors' => [
                    'required' => 'Harap pilih agama tidak boleh kosong',
                    'in_list' => 'Harap pilih agama yang sesuai',
                ]
            ],
            'jabatan' => [
                'rules' => 'required|in_list[Pustakawan,Juru Arsip,Petugas Kebersihan,Petugas Keamanan]',
                'errors' => [
                    'required' => 'Harap pilih jabatan yang sesuai',
                    'in_list' => 'Harap pilih jabatan yang sesuai',
                ]
            ],
            'foto' => [
                'rules' => 'is_image[foto]|mime_in[foto,image/png,image/jpg,image/jpeg]|max_size[foto,1024]',
                'errors' => [
                    'mime_in' => 'Format file tidak didukung, Harap Masukan file berformat .png, .jpg, .jpeg',
                    'is_image' => 'Format file tidak didukung, Harap Masukan file berformat .png, .jpg, .jpeg',
                    'max_size' => 'Ukuran foto terlalu besar, Maksimal 5MB',
                ]
            ],
            'alamat' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Kolom {field} tidak boleh kosong'
                ]
            ],
        ])) {
            return redirect()->back()->withInput();
        }

        $fileFoto = $this->request->getFile('foto');

        if ($fileFoto->getError() == 4) {
            $namaFoto = 'default.png';
        } else {
            $namaFoto = $fileFoto->getRandomName();
            $fileFoto->move('/upload/petugas/', $namaFoto);
        }

        $this->petugasModel->save([
            'nama' => $this->request->getVar('nama'),
            'foto' => $namaFoto,
            'jenis_kelamin' => $this->request->getVar('jenis_kelamin'),
            'agama' => $this->request->getVar('agama'),
            'jabatan' => $this->request->getVar('jabatan'),
            'alamat' => $this->request->getVar('alamat'),
        ]);

        session()->setFlashdata('pesan', "Data berhasil ditambahkan");

        return redirect()->to("/admin/petugas");
    }

    public function hapus($id)
    {
        $petugas = $this->petugasModel->where('id', $id)->first();
        if ($petugas['foto'] != "default.png") {
            unlink('upload/petugas/' . $petugas['foto']);
        }
        $this->petugasModel->delete($id);
        return redirect()->to('/admin/petugas');
    }

    public function edit($id)
    {

        if (!$this->validate([
            'nama' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Kolom {field} tidak boleh kosong',
                    'is_unique' => '{field} {value} sudah digunakan'
                ]
            ],
            'jenis_kelamin' => [
                'rules' => 'required|in_list[Laki-laki,Perempuan]',
                'errors' => [
                    'required' => 'Harap pilih jenis kelamin yang sesuai',
                    'in_list' => 'Harap pilih jenis kelamin yang sesuai',
                ]
            ],
            'agama' => [
                'rules' => 'required|in_list[Islam,Kristen,Protestan,Hindu,Buddha,Konghucu,Lainnya]',
                'errors' => [
                    'required' => 'Harap pilih agama tidak boleh kosong',
                    'in_list' => 'Harap pilih agama yang sesuai',
                ]
            ],
            'jabatan' => [
                'rules' => 'required|in_list[Pustakawan,Juru Arsip,Petugas Kebersihan,Petugas Keamanan]',
                'errors' => [
                    'required' => 'Harap pilih jabatan yang sesuai',
                    'in_list' => 'Harap pilih jabatan yang sesuai',
                ]
            ],
            'foto' => [
                'rules' => 'is_image[foto]|mime_in[foto,image/png,image/jpg,image/jpeg]|max_size[foto,1024]',
                'errors' => [
                    'mime_in' => 'Format file tidak didukung, Harap Masukan file berformat .png, .jpg, .jpeg',
                    'is_image' => 'Format file tidak didukung, Harap Masukan file berformat .png, .jpg, .jpeg',
                    'max_size' => 'Ukuran foto terlalu besar, Maksimal 5MB',
                ]
            ],
            'alamat' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Kolom {field} tidak boleh kosong'
                ]
            ],
        ])) {
            return redirect()->back()->withInput();
        }

        $fileFoto = $this->request->getFile('foto');
        $fotolama =  $this->request->getVar('fotolama');
        if ($fileFoto->getError() == 4) {
            $namaFoto = $fotolama;
        } else {
            if ($fotolama != 'default.png') {
                unlink('upload/petugas/' . $fotolama);
            }

            $namaFoto = $fileFoto->getRandomName();
            $fileFoto->move('upload/petugas/', $namaFoto);
        }

        $this->petugasModel->save([
            'id' => $id,
            'nama' => $this->request->getVar('nama'),
            'foto' => $namaFoto,
            'jenis_kelamin' => $this->request->getVar('jenis_kelamin'),
            'agama' => $this->request->getVar('agama'),
            'jabatan' => $this->request->getVar('jabatan'),
            'alamat' => $this->request->getVar('alamat'),
        ]);

        session()->setFlashdata('pesan', "Data berhasil Edit");

        return redirect()->to("admin/petugas/" . $id);
    }
}