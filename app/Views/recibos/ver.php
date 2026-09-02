<?= $this->extend('layouts/main') ?>

<?= $this->section('contenido') ?>

<div class="d-flex justify-content-between align-items-center mb-3 no-imprimir">
  <h2 class="h6 fw-bold text-primary mb-0">Recibo de pago</h2>
  <div>
    <button onclick="window.print()" class="btn btn-primary btn-sm">🖨️ Imprimir</button>
    <a href="<?= site_url('lecturas') ?>" class="btn btn-outline-secondary btn-sm">← Volver</a>
  </div>
</div>

<div class="card border-0 shadow-sm mx-auto" style="max-width: 500px;">
  <div class="card-body p-4">

    <div class="text-center mb-3">
      <span class="fs-2">💧</span>
      <h1 class="h5 fw-bold text-primary mb-0">AQUORA</h1>
      <p class="text-muted small mb-0">Sistema Integrado de Gestión de Agua</p>
      <p class="fw-mono small text-muted mb-0">Recibo No. <?= str_pad($recibo['id'], 6, '0', STR_PAD_LEFT) ?></p>
    </div>

    <div class="recibo-divider my-3"></div>

    <div class="mb-3">
      <div class="d-flex justify-content-between">
        <span class="text-muted small">Cliente</span>
        <span class="fw-semibold"><?= esc($recibo['cliente_nombre']) ?></span>
      </div>
      <div class="d-flex justify-content-between">
        <span class="text-muted small">Contador</span>
        <span class="fw-mono"><?= esc($recibo['numero_registro']) ?></span>
      </div>
      <div class="d-flex justify-content-between">
        <span class="text-muted small">Dirección de servicio</span>
        <span><?= esc($recibo['direccion_servicio']) ?></span>
      </div>
      <div class="d-flex justify-content-between">
        <span class="text-muted small">Período</span>
        <span class="fw-semibold"><?= esc($recibo['periodo']) ?></span>
      </div>
      <div class="d-flex justify-content-between">
        <span class="text-muted small">Fecha de lectura</span>
        <span><?= esc($recibo['fecha_lectura']) ?></span>
      </div>
      <div class="d-flex justify-content-between">
        <span class="text-muted small">Registrado por</span>
        <span><?= esc($recibo['lector_nombre']) ?></span>
      </div>
    </div>

    <div class="recibo-divider my-3"></div>

    <table class="table table-borderless table-sm mb-0">
      <tbody>
        <tr>
          <td class="text-muted small">Lectura anterior</td>
          <td class="text-end fw-mono"><?= number_format($recibo['lectura_anterior'], 2) ?> m³</td>
        </tr>
        <tr>
          <td class="text-muted small">Lectura actual</td>
          <td class="text-end fw-mono"><?= number_format($recibo['lectura_actual'], 2) ?> m³</td>
        </tr>
        <tr>
          <td class="text-muted small">Consumo</td>
          <td class="text-end fw-mono fw-semibold"><?= number_format($recibo['consumo'], 2) ?> m³</td>
        </tr>
        <tr>
          <td class="text-muted small">Tarifa por m³</td>
          <td class="text-end fw-mono">Q<?= number_format($recibo['monto_por_unidad'], 2) ?></td>
        </tr>
      </tbody>
    </table>

    <div class="recibo-divider my-3"></div>

    <div class="d-flex justify-content-between align-items-center">
      <span class="fw-bold">Total a pagar</span>
      <span class="recibo-total">Q<?= number_format($recibo['monto'], 2) ?></span>
    </div>

  </div>
</div>

<?= $this->endSection() ?>