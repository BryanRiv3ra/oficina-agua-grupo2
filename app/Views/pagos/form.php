<?= $this->extend('layouts/main') ?>

<?= $this->section('contenido') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
  <h2 class="h4 fw-bold mb-0">Registrar pago</h2>
  <a href="<?= site_url('pagos') ?>" class="btn btn-outline-secondary btn-sm">Volver</a>
</div>

<?php if (session('errores')): ?>
  <div class="alert alert-danger">
    <ul class="mb-0">
      <?php foreach (session('errores') as $error): ?>
        <li><?= esc($error) ?></li>
      <?php endforeach; ?>
    </ul>
  </div>
<?php endif; ?>

<div class="row">
  <div class="col-lg-8">
    <div class="card border-0 shadow-sm">
      <div class="card-body p-4">

        <div class="mb-4 pb-3 border-bottom">
          <div class="row small text-muted">
            <div class="col-sm-4">Período: <span class="fw-semibold text-dark"><?= esc($lectura['periodo']) ?></span></div>
            <div class="col-sm-4">Consumo: <span class="fw-semibold text-dark"><?= esc($lectura['consumo']) ?></span></div>
            <div class="col-sm-4">Monto calculado: <span class="fw-semibold text-dark">Q <?= number_format((float) $lectura['monto'], 2) ?></span></div>
          </div>
        </div>

        <form action="<?= site_url('pagos/guardar') ?>" method="post" id="formPago">
          <?= csrf_field() ?>

          <!-- Token de idempotencia: identifica de forma única este envío del
               formulario. Si llega dos veces, solo se registra un pago. -->
          <input type="hidden" name="token" value="<?= esc($token) ?>">
          <input type="hidden" name="lectura_id" value="<?= esc($lectura['id']) ?>">

          <div class="row g-3">
            <div class="col-md-6">
              <label for="monto" class="form-label small fw-semibold">Monto a pagar (Q)</label>
              <input type="number" step="0.01" min="0.01" class="form-control" id="monto" name="monto"
                     value="<?= esc(old('monto', $lectura['monto'])) ?>" required>
            </div>

            <div class="col-md-6">
              <label for="fecha_pago" class="form-label small fw-semibold">Fecha del pago</label>
              <input type="date" class="form-control" id="fecha_pago" name="fecha_pago"
                     value="<?= esc(old('fecha_pago', date('Y-m-d'))) ?>" required>
            </div>

            <div class="col-md-6">
              <label for="metodo" class="form-label small fw-semibold">Método</label>
              <select class="form-select" id="metodo" name="metodo" required>
                <option value="efectivo">Efectivo</option>
                <option value="deposito">Depósito</option>
                <option value="transferencia">Transferencia</option>
              </select>
            </div>

            <div class="col-md-6">
              <label for="numero_boleta" class="form-label small fw-semibold">No. de boleta (opcional)</label>
              <input type="text" class="form-control" id="numero_boleta" name="numero_boleta"
                     value="<?= esc(old('numero_boleta')) ?>" maxlength="50">
            </div>

            <div class="col-12">
              <label for="observaciones" class="form-label small fw-semibold">Observaciones (opcional)</label>
              <input type="text" class="form-control" id="observaciones" name="observaciones"
                     value="<?= esc(old('observaciones')) ?>" maxlength="255">
            </div>
          </div>

          <div class="mt-4">
            <button type="submit" class="btn btn-primary" id="btnGuardar">Registrar pago</button>
          </div>
        </form>

      </div>
    </div>
  </div>
</div>

<?= $this->endSection() ?>