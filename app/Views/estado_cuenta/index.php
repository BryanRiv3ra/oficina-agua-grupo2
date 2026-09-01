<?= $this->extend('layouts/main') ?>

<?= $this->section('contenido') ?>

<h2 class="h6 fw-bold text-primary mb-3">Estado de Cuenta</h2>

<div class="btn-group mb-3" role="group">
  <a href="<?= site_url('estado-cuenta') ?>" class="btn btn-sm <?= empty($filtro) ? 'btn-primary' : 'btn-outline-primary' ?>">Todos</a>
  <a href="<?= site_url('estado-cuenta?estado=pendiente') ?>" class="btn btn-sm <?= $filtro === 'pendiente' ? 'btn-primary' : 'btn-outline-primary' ?>">Pendientes</a>
  <a href="<?= site_url('estado-cuenta?estado=al_dia') ?>" class="btn btn-sm <?= $filtro === 'al_dia' ? 'btn-primary' : 'btn-outline-primary' ?>">Al día</a>
</div>

<div class="card border-0 shadow-sm">
  <div class="table-responsive">
    <table class="table table-hover align-middle mb-0">
      <thead class="table-light">
        <tr>
          <th>Cliente</th>
          <th class="text-center">Lecturas registradas</th>
          <th class="text-center">Lecturas sin pagar</th>
          <th class="text-end">Estado</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($clientes as $c): ?>
          <tr>
            <td><?= esc($c['nombre']) ?></td>
            <td class="text-center"><?= $c['total_lecturas'] ?></td>
            <td class="text-center"><?= $c['lecturas_sin_pago'] ?></td>
            <td class="text-end">
              <?php if ($c['estado'] === 'Pendiente'): ?>
                <span class="badge badge-pendiente">Pendiente</span>
              <?php else: ?>
                <span class="badge badge-al-dia">Al día</span>
              <?php endif; ?>
            </td>
          </tr>
        <?php endforeach; ?>
        <?php if (empty($clientes)): ?>
          <tr><td colspan="4" class="text-center text-muted py-4">No hay clientes en este filtro.</td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<?= $this->endSection() ?>