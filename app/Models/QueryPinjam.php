<?php
namespace App\Models;

use CodeIgniter\Model;

class QueryPinjam extends Model {
    protected $table            = 'pinjam';
    protected $primaryKey       = 'id_user';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['nama', 'tanggal_pinjam', 'tanggal_kembali', 'judul'];

    public function insertData(array $data) {
        if ($this->validateData($data)) {
            return $this->insert($data);
        }
        return false;
    }
    public function validateData($row) {
        return isset($row['nama']) && isset($row['tanggal_pinjam']) && isset($row['tanggal_kembali']) && isset($row['judul']);
    }
}
