<?php
namespace App\Controllers;
use App\Models\Query;
use App\Models\QueryPinjam;

interface MemberInterface {
    public function index();
    public function logout();
    public function detail($id);
    public function pinjam();
}
namespace App\Controllers;

trait SessionTrait {
    protected function isLoggedIn()
    {
        return session('masuk') ? true : false;
    }
}
abstract class MemberController extends BaseController implements MemberInterface {
    use SessionTrait;

    abstract public function index();
    abstract public function logout();
    abstract public function detail($id);
}
namespace App\Controllers;
use App\Models\Query;
use App\Models\QueryPinjam;

class Member extends MemberController {
    
    private $sqq;
    public function __construct() {
        $this->sqq = new QueryPinjam();
    }
    public function index() {
        $sqq = new Query();
        $data['data'] = $sqq->orderBy('id', 'ASC')->findAll();

        if ($this->isLoggedIn()) {
            return view('member', $data);
        } else {
            return view('index');
        }
    }
    public function logout() {
        session()->destroy();
        return redirect()->to('/');
    }
    public static function sesi() {
        return session('masuk') ? true : false;
    }
    public function detail($id) {
        $sqq = new Query();
        $data['data'] = $sqq->find($id);
        if (Member::sesi() == false) {
            echo "Alahhh";
        } else if (Member::sesi() == true) {
            return view('detail', $data);
        }
    }
    public function pinjam() {
        $sql = new QueryPinjam();

        if ($this->request->getMethod() == 'POST') {
            $data = [
                'judul' => $this->request->getPost('judul'),
                'nama' => $this->request->getPost('nama'),
                'tanggal_pinjam' => $this->request->getPost('tanggal_pinjam'),
                'tanggal_kembali' => $this->request->getPost('tanggal_kembali'),
            ];
            if ($sql->insertData($data)) {
                return $this->response->setJSON(['status' => 'success']);
            } else {
                return $this->response->setJSON(['status' => 'error', 'message' => 'Gagal / Buku sudah dipinjam']);
            }
        } else {
            return view('/member');
        }
    }
    public function search() {
        $search = $this->request->getPost('search');
        $data = $this->sqq->like('nama', match: $search)
                          ->orLike('deskripsi', $search)
                          ->findAll();
        $result = [];
        foreach ($data as $row) {
            $result[] = [
                'id' => $row['id'],
                'nama' => $row['nama'],
                'deskripsi' => $row['deskripsi'],
                'status_data' => $row['status_data'],
                'image' => base_url($row['image']),
            ];
        }
        return $this->response->setJSON($result);
    }    
}