<?= $this->extend('layouts/main') ?>

<?= $this->section('contenido') ?>
<div class="row g-3 mb-4">
  <div class="col-6 col-md-3">
    <div class="card border-0 shadow-sm h-100">
      <div class="card-body">
        <div class="text-muted small text-uppercase fw-semibold">Clientes activos</div>
        <div class="fs-3 fw-bold text-primary">128</div>
      </div>
    </div>
  </div>
</div>
<?= $this->endSection() ?>