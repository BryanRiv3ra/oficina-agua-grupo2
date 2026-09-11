<?= $this->extend('layouts/main') ?>

<?= $this->section('contenido') ?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css">

<style>
  .tarjeta-dato { border-radius: 14px; transition: transform .15s ease, box-shadow .15s ease; }
  .tarjeta-dato:hover { transform: translateY(-2px); box-shadow: 0 .5rem 1.2rem rgba(0,0,0,.10) !important; }

  .icono-dato {
    width: 44px; height: 44px;
    display: flex; align-items: center; justify-content: center;
    border-radius: 12px;
    font-size: 1.35rem;
  }

  .icono-clientes   { background: rgba(13,110,253,.10); color: #0d6efd; }
  .icono-contadores { background: rgba(13,202,240,.12); color: #0aa2c0; }
  .icono-sectores   { background: rgba(25,135,84,.10);  color: #198754; }
  .icono-pendiente  { background: rgba(220,53,69,.10);  color: #dc3545; }
  .icono-ok         { background: rgba(25,135,84,.10);  color: #198754; }

  .rotulo-dato {
    font-size: .72rem;
    letter-spacing: .04em;
    color: #6c757d;
  }

  .valor-dato { font-size: 2rem; font-weight: 700; line-height: 1.1; }

  /* Franja de bienvenida: la imagen se ajusta al ancho completo y se ve entera,
     sin recortes. El degradado mantiene legible el texto de la izquierda. */
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
</style>

<div class="row g-3 mb-4">

  <div class="col-6 col-md-3">
    <div class="card border-0 shadow-sm h-100 tarjeta-dato">
      <div class="card-body">
        <div class="d-flex align-items-center gap-2 mb-3">
          <span class="icono-dato icono-clientes"><i class="bi bi-people-fill"></i></span>
          <div class="text-uppercase fw-semibold rotulo-dato">Clientes activos</div>
        </div>
        <div class="valor-dato text-primary"><?= $totalClientes ?></div>
      </div>
    </div>
  </div>

  <div class="col-6 col-md-3">
    <div class="card border-0 shadow-sm h-100 tarjeta-dato">
      <div class="card-body">
        <div class="d-flex align-items-center gap-2 mb-3">
          <span class="icono-dato icono-contadores"><i class="bi bi-speedometer2"></i></span>
          <div class="text-uppercase fw-semibold rotulo-dato">Contadores activos</div>
        </div>
        <div class="valor-dato text-primary"><?= $totalContadores ?></div>
      </div>
    </div>
  </div>

  <div class="col-6 col-md-3">
    <div class="card border-0 shadow-sm h-100 tarjeta-dato">
      <div class="card-body">
        <div class="d-flex align-items-center gap-2 mb-3">
          <span class="icono-dato icono-sectores"><i class="bi bi-geo-alt-fill"></i></span>
          <div class="text-uppercase fw-semibold rotulo-dato">Sectores cubiertos</div>
        </div>
        <div class="valor-dato text-primary"><?= $totalSectores ?></div>
      </div>
    </div>
  </div>

  <div class="col-6 col-md-3">
    <div class="card border-0 shadow-sm h-100 tarjeta-dato">
      <div class="card-body">
        <div class="d-flex align-items-center gap-2 mb-3">
          <span class="icono-dato <?= $lecturasPendientes > 0 ? 'icono-pendiente' : 'icono-ok' ?>">
            <i class="bi <?= $lecturasPendientes > 0 ? 'bi-exclamation-triangle-fill' : 'bi-check-circle-fill' ?>"></i>
          </span>
          <div class="text-uppercase fw-semibold rotulo-dato">Lecturas sin pagar</div>
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
    <h2 class="h6 fw-bold text-primary mb-2">
      <i class="bi bi-droplet-fill me-1"></i> Bienvenido a AQUORA
    </h2>
    <p class="text-muted small mb-0" style="max-width: 60ch;">
      Sistema Integrado de Gestión de Agua - desde aquí administras clientes,
      contadores, tarifas, el registro de lecturas casa por casa, el cobro en
      oficina y el estado de cuenta de cada usuario.
    </p>
  </div>
</div>

<?= $this->endSection() ?>