<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\QueryUser;

class ManageUser extends BaseController
{
    private $dataUser;

    public function __construct()
    {
        $this->dataUser = new QueryUser();
    }
    public function index() {
        if (session('masuk_admin')) {
            $data['data'] = $this->dataUser->orderBy('id', 'ASC')->findAll();
            $data['data'] = array_map(function ($item) {
                $item['password'] = $this->dataUser->manualdecryption($item['password'], 'KominfoKangBlokir#1234');
                return $item;
            }, $data['data']);
            return view('manage-user', $data);
        } else {
            return redirect()->to('/');
        }
    }
    public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $this->request->getPost('username');
            $password = $this->request->getPost('password');
            $role = $this->request->getPost('role');
            $ban = "ok";

            if (empty($username) || empty($password) || empty($role) || empty($ban)) {
                return redirect()->back()->with('error', 'Semua field harus diisi!');
            }
            if ($this->dataUser->where('username', $username)->first()) {
                return $this->response->setJSON(['status' => 'error', 'message' => 'User sudah terdaftar']);
            }
            $enkripsi = $this->dataUser->manualencryption($password);
            $data = [
                'username' => $username,
                'password' => $enkripsi,
                'role' => $role,
                'banned' => $ban
            ];
            if ($this->dataUser->insert($data)) {
                return $this->response->setJSON(['status' => 'success', 'message' => 'User berhasil ditambahkan']);
            } else {
                return $this->response->setJSON(['status' => 'error', 'message' => 'Gagal Memasukkan data']);
            }
        }
        return redirect()->to('/admin/manage-user');
    }
    public function edit()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $this->request->getPost('id');
            $username = $this->request->getPost('username');
            $password = $this->request->getPost('password');
            $ban = $this->request->getPost('banned');
            $reason = $this->request->getPost('reason');

            if (empty($username) || empty($password)) {
                return $this->response->setJSON(['status' => 'error', 'message' => 'Form harus diisi']);
            }

            $existingUser = $this->dataUser->where('username', $username)->first();
            if ($existingUser && $existingUser['id'] != $id) { // Pastikan user yang ditemukan bukan user yang sedang diedit
                return $this->response->setJSON(['status' => 'error', 'message' => 'Username sudah terdaftar']);
            }

            $enkripsi = $this->dataUser->manualencryption($password);
            $data = [
                'username' => $username,
                'password' => $enkripsi,
                'role' => $ban,
                'reason' => $reason
            ];
            if ($this->dataUser->update($id, $data)) {
                return $this->response->setJSON(['status' => 'success', 'message' => 'Data berhasil diubah']);
            } else {
                return $this->response->setJSON(['status' => 'error', 'message' => 'Gagal Memperbarui data']);
            }
        }
        return redirect()->to('/admin/manage-user');
    }
    public function delete($id)
    {
        if ($this->dataUser->find($id)) {
            if ($this->dataUser->delete($id)) {
                return $this->response->setJSON(['status' => 'success']);
            } else {
                return $this->response->setJSON(['status' => 'error', 'message' => 'Gagal Menghapus data']);
            }
        }
        return redirect()->to('/admin/manage-user');
    }
    public function search() {
        $search = $this->request->getPost('search');

        $data = $this->dataUser->like('username', $search)
                      ->orLike('role', $search)
                      ->findAll();
        return $this->response->setJSON($data);
    }
}