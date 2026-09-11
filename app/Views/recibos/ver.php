<?= $this->extend('layouts/main') ?>

<?= $this->section('contenido') ?>

<style>
  .recibo-ticket {
    max-width: 340px;
    margin: 0 auto;
    font-family: 'JetBrains Mono', monospace;
    background: #fff;
    border: 1px dashed #adb5bd;
    padding: 1.5rem 1.25rem;
  }
  .recibo-encabezado {
    text-align: center;
    margin-bottom: 0.5rem;
  }
  .recibo-encabezado .nombre {
    font-weight: 700;
    font-size: 1.15rem;
    letter-spacing: 0.15em;
  }
  .recibo-linea-punteada {
    border-top: 1px dashed #6c757d;
    margin: 0.75rem 0;
  }
  .recibo-fila {
    display: flex;
    justify-content: space-between;
    gap: 0.5rem;
    font-size: 0.8rem;
    margin-bottom: 0.35rem;
  }
  .recibo-fila .etiqueta {
    color: #6c757d;
  }
  .recibo-fila .valor {
    text-align: right;
    word-break: break-word;
  }
  .recibo-concepto {
    font-size: 0.8rem;
    margin-bottom: 0.35rem;
  }
  .recibo-total-caja {
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 1.25rem;
    font-weight: 700;
    margin-top: 0.5rem;
    padding: 0.5rem 0.75rem;
    background: #f1f3f5;
  }
  .recibo-footer {
    text-align: center;
    font-size: 0.7rem;
    color: #6c757d;
    margin-top: 1rem;
  }
  @media print {
    .no-imprimir { display: none !important; }
    .recibo-ticket { border: none; max-width: 100%; }
  }
</style>

<div class="d-flex justify-content-between align-items-center mb-3 no-imprimir">
  <h2 class="h6 fw-bold text-primary mb-0">Recibo de pago</h2>
  <div>
    <button onclick="window.print()" class="btn btn-primary btn-sm">🖨️ Imprimir</button>
    <a href="<?= site_url('lecturas') ?>" class="btn btn-outline-secondary btn-sm">← Volver</a>
  </div>
</div>

<<<<<<< Updated upstream
<div class="recibo-ticket">
=======
<div class="card border-0 shadow-sm mx-auto" style="max-width: 500px;">
  <div class="card-body p-4">

    <div class="text-center mb-3">
      <span class="fs-2">💧</span>
      <h1 class="h5 fw-bold text-primary mb-0">AQUORA</h1>
      <p class="text-muted small mb-0">Sistema Integrado de Gestión de Agua</p>
      <p class="fw-mono small text-muted mb-0">Recibo No. <?= esc($recibo['numero_recibo']) ?></p>
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
>>>>>>> Stashed changes

  <div class="recibo-encabezado">
    <div class="nombre">AQUORA</div>
    <div class="small text-muted">Sistema Integrado de Gestión de Agua</div>
    <div class="small text-muted">Recibo No. <?= str_pad($recibo['id'], 6, '0', STR_PAD_LEFT) ?></div>
  </div>

  <div class="recibo-linea-punteada"></div>

  <div class="recibo-fila">
    <span class="etiqueta">Cliente</span>
    <span class="valor"><?= esc($recibo['cliente_nombre']) ?></span>
  </div>
  <div class="recibo-fila">
    <span class="etiqueta">Dirección</span>
    <span class="valor"><?= esc($recibo['direccion_servicio']) ?></span>
  </div>
  <div class="recibo-fila">
    <span class="etiqueta">Sector</span>
    <span class="valor"><?= esc($recibo['sector']) ?></span>
  </div>
  <div class="recibo-fila">
    <span class="etiqueta">Contador</span>
    <span class="valor"><?= esc($recibo['numero_registro']) ?></span>
  </div>

  <div class="recibo-linea-punteada"></div>

  <div class="recibo-fila">
    <span class="etiqueta">Periodo</span>
    <span class="valor fw-semibold"><?= esc($recibo['periodo']) ?></span>
  </div>
  <div class="recibo-fila">
    <span class="etiqueta">Fecha de lectura</span>
    <span class="valor"><?= esc($recibo['fecha_lectura']) ?></span>
  </div>
  <div class="recibo-fila">
    <span class="etiqueta">Registrado por</span>
    <span class="valor"><?= esc($recibo['lector_nombre']) ?></span>
  </div>

  <div class="recibo-linea-punteada"></div>

  <div class="recibo-concepto d-flex justify-content-between">
    <span>Lectura anterior</span>
    <span><?= number_format($recibo['lectura_anterior'], 2) ?> m³</span>
  </div>
  <div class="recibo-concepto d-flex justify-content-between">
    <span>Lectura actual</span>
    <span><?= number_format($recibo['lectura_actual'], 2) ?> m³</span>
  </div>
  <div class="recibo-concepto d-flex justify-content-between fw-semibold">
    <span>Consumo</span>
    <span><?= number_format($recibo['consumo'], 2) ?> m³</span>
  </div>
  <div class="recibo-concepto d-flex justify-content-between">
    <span>Tarifa por m³</span>
    <span>Q<?= number_format($recibo['monto_por_unidad'], 2) ?></span>
  </div>

  <div class="recibo-linea-punteada"></div>

  <div class="recibo-total-caja">
    <span>TOTAL</span>
    <span>Q<?= number_format($recibo['monto'], 2) ?></span>
  </div>

  <div class="recibo-linea-punteada"></div>

  <div class="recibo-footer">
    Generado por sistema AQUORA<br>
    <?= date('d/m/Y H:i') ?>
  </div>

</div>

<?= $this->endSection() ?>