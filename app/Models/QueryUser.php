<?php

namespace App\Models;

use CodeIgniter\Model;

class QueryUser extends Model {
    protected $table = 'akun';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $allowedFields = ['username', 'password', 'role', 'reason'];

    private function validateData(array $data) {
        return !empty($data['username']) && !empty($data['password']) && !empty($data['role']);
    }
    public function insertData(array $data) {
        if ($this->validateData($data)) {
            return $this->insert($data);
        }
        return false;
    }
    public function manualencryption($a) {
        $textplain = $a;
        $key = 'KominfoKangBlokir#1234';
        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
        $encrypted = openssl_encrypt($textplain, 'aes-256-cbc', $key, 0, $iv);
        return base64_encode($encrypted . '::' . $iv);
    }
    public function manualdecryption($nama, $kunci) {
        list($encryptedData, $iv) = explode('::', base64_decode($nama), 2);

        if ($iv === false) {
            return null;
        }
        $plainText = openssl_decrypt($encryptedData, 'aes-256-cbc', $kunci, 0, $iv);
        return $plainText;
    }
}