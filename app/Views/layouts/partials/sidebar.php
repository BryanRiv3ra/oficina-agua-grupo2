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
      <a href="<?= site_url('dashboard') ?>" class="nav-link enlace-menu <?= ($vistaActiva ?? '') === 'panel' ? 'activo' : '' ?>">
        <span class="icono">🏠</span> Panel principal
      </a>
      <a href="<?= site_url('clientes') ?>" class="nav-link enlace-menu <?= ($vistaActiva ?? '') === 'clientes' ? 'activo' : '' ?>">
        <span class="icono">👥</span> Clientes
      </a>
      <a href="<?= site_url('contadores') ?>" class="nav-link enlace-menu <?= ($vistaActiva ?? '') === 'contadores' ? 'activo' : '' ?>">
        <span class="icono">🔢</span> Contadores
      </a>
      <a href="<?= site_url('lecturas') ?>" class="nav-link enlace-menu <?= ($vistaActiva ?? '') === 'lectura' ? 'activo' : '' ?>">
        <span class="icono">📋</span> Registrar lectura
      </a>
      <a href="<?= site_url('pagos') ?>" class="nav-link enlace-menu <?= ($vistaActiva ?? '') === 'pago' ? 'activo' : '' ?>">
        <span class="icono">💵</span> Registrar pago
      </a>
      <a href="<?= site_url('tarifas') ?>" class="nav-link enlace-menu <?= ($vistaActiva ?? '') === 'tarifas' ? 'activo' : '' ?>">
        <span class="icono">🧾</span> Tarifas
      </a>
    </nav>
    <div class="px-3 py-3 border-top border-light border-opacity-10">
      <form action="<?= site_url('logout') ?>" method="post">
        <?= csrf_field() ?>
        <button class="btn btn-outline-light btn-sm w-100" type="submit">Cerrar sesión</button>
      </form>
    </div>
  </div>
</div>