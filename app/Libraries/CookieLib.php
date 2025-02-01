<?php

namespace App\Libraries;

use CodeIgniter\HTTP\Cookie;

class CookieLib
{
    public function setCookie($name, $value, $expire = 7200, $path = '/', $domain = '', $secure = false, $httponly = true, $samesite = 'Lax')
    {
        $cookie = [
            'name'   => $name,
            'value'  => $value,
            'expire' => $expire,
            'domain' => $domain,
            'path'   => $path,
            'prefix' => '',
            'secure' => $secure,
            'httponly' => $httponly,
            'samesite' => $samesite
        ];
        return $cookie;
    }

    public function getCookie($name)
    {
        return get_cookie($name);
    }

    public function deleteCookie($name)
    {
        delete_cookie($name);
    }
}
