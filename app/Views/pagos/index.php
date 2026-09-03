<?= $this->extend('layouts/main') ?>

<?= $this->section('contenido') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
  <h2 class="h4 fw-bold mb-0">Lecturas pendientes de pago</h2>
</div>

<form method="get" action="<?= site_url('pagos') ?>" class="row g-2 mb-4">
  <div class="col-md-6">
    <input type="text" name="q" class="form-control"
           placeholder="Buscar por cliente o código de contador"
           value="<?= esc($busqueda ?? '') ?>">
  </div>
  <div class="col-auto">
    <button type="submit" class="btn btn-primary">Buscar</button>
  </div>
  <?php if (! empty($busqueda)): ?>
    <div class="col-auto">
      <a href="<?= site_url('pagos') ?>" class="btn btn-outline-secondary">Limpiar</a>
    </div>
  <?php endif; ?>
</form>

<?php if (empty($pendientes)): ?>
  <div class="alert alert-info">
    <?= empty($busqueda)
        ? 'No hay lecturas pendientes de pago.'
        : 'No se encontraron lecturas pendientes para esa búsqueda.' ?>
  </div>
<?php else: ?>
  <div class="card border-0 shadow-sm">
    <div class="table-responsive">
      <table class="table table-hover align-middle mb-0">
        <thead class="table-light">
          <tr>
            <th>Cliente</th>
            <th>Contador</th>
            <th>Período</th>
            <th>Fecha lectura</th>
            <th class="text-end">Consumo</th>
            <th class="text-end">Monto</th>
            <th class="text-end">Acción</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($pendientes as $fila): ?>
            <tr>
              <td><?= esc($fila['cliente']) ?></td>
              <td><?= esc($fila['contador']) ?></td>
              <td><?= esc($fila['periodo']) ?></td>
              <td><?= esc($fila['fecha_lectura']) ?></td>
              <td class="text-end"><?= esc($fila['consumo']) ?></td>
              <td class="text-end fw-semibold">Q <?= number_format((float) $fila['monto'], 2) ?></td>
              <td class="text-end">
                <a href="<?= site_url('pagos/registrar/' . $fila['id']) ?>"
                   class="btn btn-sm btn-primary">Registrar pago</a>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
<?php endif; ?>

<?= $this->endSection() ?>