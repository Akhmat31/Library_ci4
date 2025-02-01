<?php
namespace App\Controllers;
use App\Models\Query;
use App\Controllers\BaseController;

class Member_backup extends BaseController {
    public function index() {
        $sqq = new Query();
        $data['data'] = $sqq->orderBy('id', 'ASC')->findAll();
        $inf = (session('masuk')) ? true : false;
        if ($inf == true) {
            return view('member', $data);
        } else {
            return view('index');
        }
    }
    public function logout() {
        session()->destroy();
        return redirect()->to('/');
    }
    public function detail($id) {
        $sqq = new Query();
        $data['data'] = $sqq->find($id);
        return view('detail', $data);
    }
}