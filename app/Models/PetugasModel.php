<?php

namespace App\Models;

use CodeIgniter\Model;

class PetugasModel extends Model
{
    protected $table      = 'petugas';
    protected $primaryKey = 'id_petugas';

    protected $useAutoIncrement = false;

    protected $returnType     = 'array';
    // protected $useSoftDeletes = true;

    protected $allowedFields = ['id_petugas', 'id_login', 'akses_login', 'nama', 'jenis_kelamin', 'agama', 'alamat', 'jabatan', 'nomor_telepon', 'foto'];

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


    public function getDataPetugas($idPetugas = null)
    {
        $petugas = $this->db->table('petugas')->select('*, petugas.created_at, petugas.updated_at')->where('akses_login !=', 'admin');

        if ($idPetugas) {
            return $petugas->join('users', 'users.id = petugas.id_login', 'left')->where('id_petugas', $idPetugas)->get()->getRowArray();
        }

        return $petugas->get()->getResultArray();
    }
}
