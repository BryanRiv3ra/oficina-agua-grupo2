<?php

namespace Config;

use App\Filters\AuthFilter;
use App\Filters\RolFilter;
use CodeIgniter\Config\Filters as BaseFilters;
use CodeIgniter\Filters\Cors;
use CodeIgniter\Filters\CSRF;
use CodeIgniter\Filters\DebugToolbar;
use CodeIgniter\Filters\ForceHTTPS;
use CodeIgniter\Filters\Honeypot;
use CodeIgniter\Filters\InvalidChars;
use CodeIgniter\Filters\PageCache;
use CodeIgniter\Filters\PerformanceMetrics;
use CodeIgniter\Filters\SecureHeaders;

class Filters extends BaseFilters
{
    public array $aliases = [
        'csrf'          => CSRF::class,
        'toolbar'       => DebugToolbar::class,
        'honeypot'      => Honeypot::class,
        'invalidchars'  => InvalidChars::class,
        'secureheaders' => SecureHeaders::class,
        'cors'          => Cors::class,
        'forcehttps'    => ForceHTTPS::class,
        'pagecache'     => PageCache::class,
        'performance'   => PerformanceMetrics::class,

        // Filtros propios del sistema (control de acceso)
        'auth'          => AuthFilter::class,
        'rol'           => RolFilter::class,
    ];

    public array $required = [
        'before' => [
            'forcehttps', // Force Global Secure Requests
            'pagecache',  // Web Page Caching
        ],
        'after' => [
            'pagecache',   // Web Page Caching
            'performance', // Performance Metrics
            'toolbar',     // Debug Toolbar
        ],
    ];

    public array $globals = [
        'before' => [
            // 'honeypot',
            // 'csrf',
            // 'invalidchars',
        ],
        'after' => [
            // 'honeypot',
            // 'secureheaders',
        ],
    ];

    public array $methods = [];

    public array $filters = [
        // 1) Sesión iniciada: todo lo de adentro del sistema.
        'auth' => [
            'before' => [
                'dashboard',
                'clientes', 'clientes/*',
                'contadores', 'contadores/*',
                'tarifas', 'tarifas/*',
                'lecturas', 'lecturas/*',
                'pagos', 'pagos/*',
            ],
        ],

        // 2) Rol permitido por sección. Los nombres deben coincidir con la tabla `roles`.
        'rol:Administrador' => [
            'before' => ['tarifas', 'tarifas/*'],
        ],
        'rol:Administrador,Secretaria' => [
            'before' => [
                'clientes', 'clientes/*',
                'contadores', 'contadores/*',
                'pagos', 'pagos/*',
            ],
        ],
        'rol:Administrador,Lector' => [
            'before' => ['lecturas', 'lecturas/*'],
        ],
    ];
}