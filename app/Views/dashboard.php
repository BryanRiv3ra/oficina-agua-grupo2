<?= $this->extend('layouts/main') ?>

<?= $this->section('contenido') ?>

<div class="row g-3 mb-4">
  <div class="col-6 col-md-3">
    <div class="card border-0 shadow-sm h-100">
      <div class="card-body">
        <div class="d-flex align-items-center gap-2 mb-2">
          <span class="fs-4">👥</span>
          <div class="text-muted small text-uppercase fw-semibold">Clientes activos</div>
        </div>
        <div class="fs-3 fw-bold text-primary"><?= $totalClientes ?></div>
      </div>
    </div>
  </div>

  <div class="col-6 col-md-3">
    <div class="card border-0 shadow-sm h-100">
      <div class="card-body">
        <div class="d-flex align-items-center gap-2 mb-2">
          <span class="fs-4">🔢</span>
          <div class="text-muted small text-uppercase fw-semibold">Contadores activos</div>
        </div>
        <div class="fs-3 fw-bold text-primary"><?= $totalContadores ?></div>
      </div>
    </div>
  </div>

  <div class="col-6 col-md-3">
    <div class="card border-0 shadow-sm h-100">
      <div class="card-body">
        <div class="d-flex align-items-center gap-2 mb-2">
          <span class="fs-4">📍</span>
          <div class="text-muted small text-uppercase fw-semibold">Sectores cubiertos</div>
        </div>
        <div class="fs-3 fw-bold text-primary"><?= $totalSectores ?></div>
      </div>
    </div>
  </div>

  <div class="col-6 col-md-3">
  <div class="card border-0 shadow-sm h-100">
    <div class="card-body">
      <div class="d-flex align-items-center gap-2 mb-2">
        <span class="fs-4">📋</span>
        <div class="text-muted small text-uppercase fw-semibold">Lecturas sin pagar</div>
      </div>
      <div class="fs-3 fw-bold text-primary"><?= $lecturasPendientes ?></div>
      <?php if ($lecturasPendientes > 0): ?>
        <a href="<?= site_url('estado-cuenta?estado=pendiente') ?>" class="small text-decoration-none">Ver detalle →</a>
      <?php endif; ?>
    </div>
  </div>
</div>

<div class="card border-0 shadow-sm">
  <div class="card-body">
    <h2 class="h6 fw-bold text-primary mb-2">Bienvenido a AQUORA</h2>
    <p class="text-muted small mb-0">
      Sistema Integrado de Gestión de Agua — desde aquí administras clientes,
      contadores y tarifas. El registro de lecturas, pagos y el estado de
      cuenta estarán disponibles en la siguiente fase del proyecto.
    </p>
  </div>
</div>

<?= $this->endSection() ?>