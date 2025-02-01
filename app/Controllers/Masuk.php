<?php
namespace App\Controllers;
use App\Models\QueryUser;
use App\Libraries\CookieLib;

class Masuk extends BaseController {

    private $dataMem;
    private $cookie;

    public function __construct() {
        $this->dataMem = new QueryUser();
        $this->cookie = new CookieLib();
    }

    public static function member() {
        return session('masuk') ? true : false;
    }

    public static function admin() {
        return session('masuk_admin') ? true : false;
    }

    public static function banned() {
        return session('banned') ? true : false;
    }
    public function index() {
        if (Masuk::banned()) {
            return redirect()->to('/banned');
        }
        if (Masuk::member()) {
            return redirect()->to('/member');
        }
        if (Masuk::admin()) {
            return redirect()->to('/admin');
        }
        return view('index');
    }
    public function proses() {
        $username = $this->request->getVar('username');
        $password = $this->request->getVar('password');
        $data = $this->dataMem->where('username', $username)->first();

        if ($data) {
            $decrypt = new QueryUser();
            $decPassword = $decrypt->manualdecryption($data['password'], 'KominfoKangBlokir#1234');

            if ($decPassword === $password) {
                if ($data['role'] == 'ban') {
                    session()->set('banned', true);
                    return redirect()->to('/banned');
                }
                if ($data['role'] === 'admin') {
                    session()->set('masuk_admin', $username);
                    $this->cookie->setCookie('jhabs7652g', 'masuk_admin', 7200);
                    return redirect()->to('/admin'); 
                }
                if ($data['role'] === 'member') {
                    session()->set('masuk', $username);
                    $this->cookie->setCookie('jhabs7652g', 'masuk', 7200);
                    return redirect()->to('/member');
                }
            } else {
                session()->setFlashdata('error', 'Password salah!');
                return redirect()->to('/');
            }
        } else {
            session()->setFlashdata('error', 'Username tidak ditemukan!');
            return redirect()->to('/');
        }
    }
}