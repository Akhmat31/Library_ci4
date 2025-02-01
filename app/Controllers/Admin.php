<?php
namespace App\Controllers;

use App\Models\Query;
use App\Models\QueryPinjam;
use CodeIgniter\HTTP\ResponseInterface;


class Admin extends BaseController {
    private $dummyModel;
    private $dummyData;

    public function __construct() {
        $this->dummyData = new QueryPinjam();
        $this->dummyModel = new Query();
    }
    public function index_main() {
        $inf = (session('masuk_admin')) ? true : false;

        if ($inf == true) {
            $session = session();
            $nama = $session->get('username');
            $data['data'] = $this->dummyData->countAll();
            return view('admin', $data);
        } else {
            return view('index');
        }
        if ($session->get('banned')) {
            return redirect()->to('/banned');
        }
    }
    public function index() {
        $inf = (session('masuk_admin')) ? true : false;
        if ($inf == true) {
            $session = session();
            $session->set('masuk_admin_manage_data');
            $data['dummy_data'] = $this->dummyModel->orderBy('id', 'ASC')->findAll();
            return view('manage-data', $data);
        } else {
            return view('index');

        }
    }
    public function add() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $nama = $this->request->getPost('tambah-nama');
            $deskripsi = $this->request->getPost('tambah-deskripsi');
            $status = 'ada';

            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $image = $_FILES['image']['tmp_name'];
                $image_name = $_FILES['image']['name'];
                $image_type = $_FILES['image']['type'];
                $image_size = $_FILES['image']['size'];

                if ($image_size > 2 * 1024 * 1024) {
                    return $this->response->setJSON(['status' => 'error', 'message' => 'Ukuran gambar terlalu besar. Maksimum 2MB.']);
                }
                switch ($image_type) {
                    case 'image/jpeg':
                        $image_extension = 'jpeg';
                        break;
                    case 'image/png':
                        $image_extension = 'png';
                        break;
                    case 'image/webp':
                        $image_extension = 'webp';
                        break;
                    case 'image/jpg':
                        $image_extension = 'jpg';
                        break;
                    default:
                        return $this->response->setJSON(['status' => 'error', 'message' => 'Tipe gambar tidak valid.']);
                }
                $upload_dir = 'uploads/';
                if (!is_dir($upload_dir)) {
                    mkdir($upload_dir, 0755, true);
                }
                $image_path = $upload_dir . uniqid() . '.' . $image_extension;
                if (!move_uploaded_file($image, $image_path)) {
                    return $this->response->setJSON(['status' => 'error', 'message' => 'Gagal meng-upload gambar.']);
                }
                $data = [
                    'nama' => $nama,
                    'deskripsi' => $deskripsi,
                    'image' => $image_path,
                    'status_data' => $status
                ];
                if ($this->dummyModel->insertData($data)) {
                    return $this->response->setJSON(['status' => 'success']);
                } else {
                    return $this->response->setJSON(['status' => 'error', 'message' => 'Gagal memasukkan data ke database.']);
                }
            } else {
                return $this->response->setJSON(['status' => 'error', 'message' => 'Gambar tidak di-upload atau terjadi kesalahan.']);
            }
        } else {
            return view('add');
        }
    }
    public function edit($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'nama' => $this->request->getPost('nama'),
                'deskripsi' => $this->request->getPost('deskripsi'),
                'status_data' => $this->request->getPost('status_data') 
            ];
            if ($this->dummyModel->update($id, $data)) {
                return $this->response->setJSON(['status' => 'success']);
            } else {
                return $this->response->setJSON(['status' => 'error', 'message' => 'Failed to update data.']);
            }
        } else {
            $data = $this->dummyModel->find($id);
            if ($data) {
                return $this->response->setJSON($data);
            } else {
                return $this->response->setJSON(['status' => 'error', 'message' => 'Data not found.']);
            }
        }
    }
    public function delete($id) {
        if ($this->dummyModel->find($id)) {
            if ($this->dummyModel->delete($id)) {
                return $this->response->setJSON(['status' => 'success']);
            } else {
                return $this->response->setJSON(['status' => 'error', 'message' => 'Failed to delete data.']);
            }
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Data not found for deletion.']);
        }
    }
    // Rest API
    public function api() {
        $method = $this->request->getMethod();
        if ($method === 'GET') {
            $id = $this->request->getGet('id');
            if ($id) {
                $data = $this->dummyModel->find($id);
                if ($data) {
                    return $this->response->setJSON($data);
                } else {
                    return $this->response->setJSON(['status' => 'error', 'message' => 'Data not found.']);
                }
            } else {
                $data = $this->dummyModel->orderBy('id', 'ASC')->findAll();
                return $this->response->setJSON($data);
            }
        }
    }
    public function search() {
        $search = $this->request->getPost('search');

        $data = $this->dummyModel->like('nama', $search)
                      ->orLike('deskripsi', $search)
                      ->findAll();
        return $this->response->setJSON($data);
    }
    public function banned() {
        if (!session()->has('banned')) {
            return redirect()->to('/');
        }
        $data['data'] = $this->dummyModel->findAll();
        return view('banned', $data);
    }
    public function notif () {
        $inf = (session('masuk_admin')) ? true : false;
        if ($inf == false) {
            return redirect()->to('/');
        } else {
            $data['data'] = $this->dummyData->findAll();
            return view ('notif', $data);
        }
    }
    public function hapus_notif($id) {
        if ($this->dummyData->find($id)) {
            if ($this->dummyData->delete($id)) {
                return $this->response->setJSON(['status' => 'success']);
            } else {
                return $this->response->setJSON(['status' => 'error', 'message' => 'Failed to delete data.']);
            }
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Data not found for deletion.']);
        }
    }
    public function about () {
        return view ('about');
    }
}