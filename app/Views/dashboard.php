<?= $this->extend('layouts/main') ?>

<?= $this->section('contenido') ?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css">

<!-- ===== CAMBIOS YENCI - MODO OSCURO: lee el tema guardado antes de pintar ===== -->
<script>
  if (localStorage.getItem('aquora-tema') === 'oscuro') {
    document.documentElement.setAttribute('data-bs-theme', 'dark');
  }
</script>

<style>
  .icono-dato {
    width: 44px; height: 44px;
    display: flex; align-items: center; justify-content: center;
    border-radius: 12px;
    font-size: 1.35rem;
  }
  .icono-clientes   { background: rgba(13,110,253,.12); color: #0d6efd; }
  .icono-contadores { background: rgba(13,202,240,.14); color: #0aa2c0; }
  .icono-sectores   { background: rgba(25,135,84,.12);  color: #198754; }
  .icono-pendiente  { background: rgba(220,53,69,.12);  color: #dc3545; }
  .icono-ok         { background: rgba(25,135,84,.12);  color: #198754; }

  .valor-dato { font-size: 2rem; font-weight: 700; line-height: 1.1; }
  .rotulo-dato { font-size: .72rem; letter-spacing: .04em; }

  .franja-bienvenida {
    position: relative;
    border-radius: 14px;
    overflow: hidden;
    background: url('<?= base_url('assets/img/lagoAtitlan.png') ?>') center center / 100% auto no-repeat; 
  }
  .franja-bienvenida::before {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(90deg, rgba(255,255,255,.88) 0%, rgba(255,255,255,.70) 40%, rgba(255,255,255,.20) 100%);
  }
  .franja-bienvenida .card-body { position: relative; }

  /* ===== CAMBIOS YENCI - MODO OSCURO: foto nocturna y velo oscuro ===== */
  [data-bs-theme="dark"] .franja-bienvenida {
    background-image: url('<?= base_url('assets/img/Lago-de-noche.png') ?>');
  }
  [data-bs-theme="dark"] .franja-bienvenida::before {
    background: linear-gradient(90deg, rgba(20,25,30,.92) 0%, rgba(20,25,30,.75) 40%, rgba(20,25,30,.25) 100%);
  }

  /* ===== CAMBIOS YENCI - MODO OSCURO: alcanza el layout (sidebar, navbar, fondo) ===== */
  [data-bs-theme="dark"] body { background-color: #0f1418; }

  [data-bs-theme="dark"] .barra-lateral { background-color: #0b1216 !important; }

  [data-bs-theme="dark"] .columna-principal { background-color: #0f1418; }

  [data-bs-theme="dark"] .navbar,
  [data-bs-theme="dark"] .barra-superior {
    background: #0b1216 !important;
    background-image: none !important;
  }
</style>

<!-- ===== CAMBIOS YENCI - MODO OSCURO: botón para alternar el tema ===== -->
<div class="d-flex justify-content-end mb-3">
  <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill" id="btnTema">
    <i class="bi bi-moon-stars-fill"></i> Modo oscuro
  </button>
</div>

<!-- Clima actual de Jutiapa (API Open-Meteo) -->
<div class="card border-0 shadow-sm mb-3">
  <div class="card-body d-flex align-items-center gap-3">
    <span class="icono-dato icono-contadores"><i class="bi bi-thermometer-half"></i></span>
    <div>
      <div class="text-uppercase fw-semibold rotulo-dato text-secondary">Clima en Jutiapa</div>
      <?php if ($clima !== null): ?>
        <div class="valor-dato"><?= $clima ?>&deg;C</div>
      <?php else: ?>
        <div class="small text-secondary">No se pudo obtener el clima en este momento.</div>
      <?php endif; ?>
    </div>
  </div>
</div>

<div class="row g-3 mb-4">

  <div class="col-6 col-md-3">
    <div class="card border-0 shadow-sm h-100">
      <div class="card-body">
        <div class="d-flex align-items-center gap-2 mb-3">
          <span class="icono-dato icono-clientes"><i class="bi bi-people-fill"></i></span>
          <div class="text-uppercase fw-semibold rotulo-dato text-secondary">Clientes activos</div>
        </div>
        <div class="valor-dato"><?= $totalClientes ?></div>
      </div>
    </div>
  </div>

  <div class="col-6 col-md-3">
    <div class="card border-0 shadow-sm h-100">
      <div class="card-body">
        <div class="d-flex align-items-center gap-2 mb-3">
          <span class="icono-dato icono-contadores"><i class="bi bi-speedometer2"></i></span>
          <div class="text-uppercase fw-semibold rotulo-dato text-secondary">Contadores activos</div>
        </div>
        <div class="valor-dato"><?= $totalContadores ?></div>
      </div>
    </div>
  </div>

  <div class="col-6 col-md-3">
    <div class="card border-0 shadow-sm h-100">
      <div class="card-body">
        <div class="d-flex align-items-center gap-2 mb-3">
          <span class="icono-dato icono-sectores"><i class="bi bi-geo-alt-fill"></i></span>
          <div class="text-uppercase fw-semibold rotulo-dato text-secondary">Sectores cubiertos</div>
        </div>
        <div class="valor-dato"><?= $totalSectores ?></div>
      </div>
    </div>
  </div>

  <div class="col-6 col-md-3">
    <div class="card border-0 shadow-sm h-100">
      <div class="card-body">
        <div class="d-flex align-items-center gap-2 mb-3">
          <span class="icono-dato <?= $lecturasPendientes > 0 ? 'icono-pendiente' : 'icono-ok' ?>">
            <i class="bi <?= $lecturasPendientes > 0 ? 'bi-exclamation-triangle-fill' : 'bi-check-circle-fill' ?>"></i>
          </span>
          <div class="text-uppercase fw-semibold rotulo-dato text-secondary">Lecturas sin pagar</div>
        </div>
        <div class="valor-dato <?= $lecturasPendientes > 0 ? 'text-danger' : 'text-success' ?>">
          <?= $lecturasPendientes ?>
        </div>
        <?php if ($lecturasPendientes > 0): ?>
          <a href="<?= site_url('estado-cuenta?estado=pendiente') ?>" class="small text-decoration-none">
            Ver detalle <i class="bi bi-arrow-right"></i>
          </a>
        <?php else: ?>
          <span class="small text-success">Todo al día</span>
        <?php endif; ?>
      </div>
    </div>
  </div>

</div>

<div class="card border-0 shadow-sm franja-bienvenida">
  <div class="card-body" style="min-height: 320px;">
    <h2 class="h6 fw-bold mb-2">
      <i class="bi bi-droplet-fill me-1"></i> Bienvenido a AQUORA
    </h2>
    <p class="small mb-0 text-secondary" style="max-width: 60ch;">
      Sistema Integrado de Gestión de Agua - desde aquí administras clientes,
      contadores, tarifas, el registro de lecturas casa por casa, el cobro en
      oficina y el estado de cuenta de cada usuario.
    </p>
  </div>
</div>

<!-- ===== CAMBIOS YENCI - MODO OSCURO: guarda la preferencia en localStorage ===== -->
<script>
  document.getElementById('btnTema').addEventListener('click', function () {
    const oscuro = document.documentElement.getAttribute('data-bs-theme') === 'dark';

    document.documentElement.setAttribute('data-bs-theme', oscuro ? 'light' : 'dark');
    localStorage.setItem('aquora-tema', oscuro ? 'claro' : 'oscuro');

    this.innerHTML = oscuro
      ? '<i class="bi bi-moon-stars-fill"></i> Modo oscuro'
      : '<i class="bi bi-sun-fill"></i> Modo claro';
  });
</script>

<?= $this->endSection() ?>