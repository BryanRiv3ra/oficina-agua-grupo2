<?php
// Menú lateral dinámico: cada opción declara qué roles pueden verla.
// Los nombres de rol deben escribirse igual que en la tabla `roles`.
$rolActual = (string) (session('rol') ?? '');

$opcionesMenu = [
    ['url' => 'dashboard',  'texto' => 'Panel principal',   'icono' => '🏠', 'clave' => 'panel',      'roles' => ['Administrador', 'Secretaria', 'Lector']],
    ['url' => 'clientes',   'texto' => 'Clientes',          'icono' => '👥', 'clave' => 'clientes',   'roles' => ['Administrador', 'Secretaria']],
    ['url' => 'contadores', 'texto' => 'Contadores',        'icono' => '🔢', 'clave' => 'contadores', 'roles' => ['Administrador', 'Secretaria']],
    ['url' => 'lecturas',   'texto' => 'Registrar lectura', 'icono' => '📋', 'clave' => 'lectura',    'roles' => ['Administrador', 'Lector']],
    ['url' => 'pagos',      'texto' => 'Registrar pago',    'icono' => '💵', 'clave' => 'pago',       'roles' => ['Administrador', 'Secretaria']],
    ['url' => 'tarifas',    'texto' => 'Tarifas',           'icono' => '🧾', 'clave' => 'tarifas',    'roles' => ['Administrador']],
];
?>
<div class="offcanvas-lg offcanvas-start barra-lateral" tabindex="-1" id="sidebar">
  <div class="offcanvas-header d-lg-none">
    <span class="navbar-brand fw-bold text-white">💧 Oficina del Agua</span>
    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" data-bs-target="#sidebar"></button>
  </div>
  <div class="offcanvas-body d-flex flex-column p-0">
    <div class="px-3 pt-3 pb-3 d-none d-lg-block">
      <span class="navbar-brand fw-bold text-white">💧 Oficina del Agua</span>
    </div>

    <nav class="nav flex-column flex-grow-1 px-2">
      <?php foreach ($opcionesMenu as $opcion): ?>
        <?php if (! in_array($rolActual, $opcion['roles'], true)) {
            continue;
        } ?>
        <a href="<?= site_url($opcion['url']) ?>"
           class="nav-link enlace-menu <?= ($vistaActiva ?? '') === $opcion['clave'] ? 'activo' : '' ?>">
          <span class="icono"><?= $opcion['icono'] ?></span> <?= esc($opcion['texto']) ?>
        </a>
      <?php endforeach; ?>
    </nav>

    <div class="px-3 py-3 border-top border-light border-opacity-10">
      <?php if (session('logueado')): ?>
        <div class="text-white small mb-2">
          <div class="fw-semibold"><?= esc(session('nombre')) ?></div>
          <div class="opacity-75"><?= esc($rolActual) ?></div>
        </div>
      <?php endif; ?>
      <form action="<?= site_url('logout') ?>" method="post">
        <?= csrf_field() ?>
        <button class="btn btn-outline-light btn-sm w-100" type="submit">Cerrar sesión</button>
      </form>
    </div>
  </div>
</div>