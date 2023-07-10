<?php

namespace App\Models;

use CodeIgniter\Model;

class PinjamModel extends Model
{
    protected $table      = 'pinjam';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = false;

    protected $returnType     = 'array';
    // protected $useSoftDeletes = true;

    protected $allowedFields = ['id', 'id_anggota', 'id_petugas', 'status', 'jumlah_pinjam', 'batas_ambil', 'tanggal_ambil', 'batas_kembali'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    public function keteranganPinjam($id)
    {
        $bataspinjam = $this->db->table('anggota')->select('batas_pinjam as batas_pinjam')->where('id', $id)->get()->getRowArray();
        $jumlahmenunggu = $this->select('count(*) as jumlah_menunggu')->join('detail_pinjam', 'detail_pinjam.id_pinjam = pinjam.id', 'inner')->where('detail_pinjam.status', 'menunggu')->where('pinjam.id_anggota', $id)->first();
        $jumlahpinjam = $this->select('count(*) as jumlah_pinjam')->join('detail_pinjam', 'detail_pinjam.id_pinjam = pinjam.id', 'inner')->where('detail_pinjam.status', 'terpinjam')->where('pinjam.id_anggota', $id)->first();
        $jumlahkembali = $this->select('count(*) as jumlah_kembali')->join('detail_pinjam', 'detail_pinjam.id_pinjam = pinjam.id', 'inner')->where("detail_pinjam.status = 'terpinjam' AND DATE(NOW()) > pinjam.batas_kembali")->where('pinjam.id_anggota', $id)->first();

        return array_merge($bataspinjam, $jumlahmenunggu, $jumlahpinjam, $jumlahkembali);
    }

    public function dataPinjam($id, $id_pinjam = null)
    {
        $pinjamBuilder = $this->db->table('pinjam')->select("pinjam.* ,
            CASE
                WHEN pinjam.status = 'menunggu' THEN 'warning'
                WHEN pinjam.status = 'melawati' THEN 'danger'
                ELSE 'success'
            END AS status_type,
            CASE
                WHEN pinjam.status = 'menunggu' THEN 'Menunggu diambil'
                WHEN pinjam.status = 'melawati' THEN 'Harus dikembalikan'
                ELSE 'Terpinjam'
            END AS status_message
        ")->where('id_anggota', $id);


        if ($id_pinjam) {
            $dataPinjam = $pinjamBuilder->where('id', $id_pinjam)->get()->getRowArray();
            $dataBuku = $this->db->table('detail_pinjam')->join('buku', 'buku.id = detail_pinjam.id_buku', 'inner')->where('id_pinjam', $dataPinjam['id'])->get()->getResultArray();
        } else {
            $dataPinjam = $pinjamBuilder->get()->getResultArray();
            $dataBuku = [];
            foreach ($dataPinjam as $data) {
                $dataBuku[$data['id']] = $this->db->table('detail_pinjam')->join('buku', 'buku.id = detail_pinjam.id_buku', 'inner')->where('id_pinjam', $data['id'])->get()->getResultArray();
            }
        }

        return ['buku' => $dataBuku, 'pinjam' => $dataPinjam];
    }
}
