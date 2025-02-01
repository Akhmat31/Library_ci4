<?php
namespace Config;
use CodeIgniter\Config\BaseConfig;

class ForeignCharacters extends BaseConfig {
    public $aliases = [
        'csrf'     => \CodeIgniter\Filters\CSRF::class,
        'toolbar'  => \CodeIgniter\Filters\DebugToolbar::class,
        'honeypot' => \CodeIgniter\Filters\Honeypot::class,
        'auth'     => \App\Filters\AuthMiddleware::class,
    ];
    public $globals = [
        'before' => [
        ],
        'after'  => [
            'toolbar',
        ],
    ];
    public $methods = [];
    public $filters = [];
}