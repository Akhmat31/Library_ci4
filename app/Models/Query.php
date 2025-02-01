<?php

namespace App\Models;

use CodeIgniter\Model;

class Query extends Model {
    protected $table = 'dummy_data';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nama', 'deskripsi', 'image', 'status_data'];

    public function insertData(array $data) {
        if ($this->validateData($data)) {
            return $this->insert($data);
        }
        return false;
    }
    private function validateData(array $data) {
        return !empty($data['nama']) && !empty($data['deskripsi']) && !empty($data['image'] && !empty('status_data'));
    }
}