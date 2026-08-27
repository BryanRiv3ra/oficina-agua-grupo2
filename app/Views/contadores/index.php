<?= $this->extend('layouts/main') ?>

<?= $this->section('contenido') ?>

<?php if (session('mensaje')): ?>
  <div class="alert alert-success"><?= session('mensaje') ?></div>
<?php endif; ?>

<div class="d-flex justify-content-between align-items-center mb-3">
  <h2 class="h6 fw-bold text-primary mb-0">Contadores</h2>
  <div>
    <a href="<?= site_url('contadores/desactivados') ?>" class="btn btn-outline-secondary btn-sm">Ver desactivados</a>
    <a href="<?= site_url('contadores/nuevo') ?>" class="btn btn-primary btn-sm">+ Nuevo contador</a>
  </div>
</div>

<form method="get" class="mb-3">
  <input type="text" name="q" class="form-control" placeholder="Buscar por número de registro o cliente..." value="<?= esc($buscar ?? '') ?>">
</form>

<div class="card border-0 shadow-sm">
  <div class="table-responsive">
    <table class="table table-hover align-middle mb-0">
      <thead class="table-light">
        <tr>
          <th>Nº Registro</th>
          <th>Cliente</th>
          <th>Dirección de servicio</th>
          <th>Sector</th>
          <th class="text-end">Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($contadores as $c): ?>
          <tr>
            <td class="fw-mono"><?= esc($c['numero_registro']) ?></td>
            <td><?= esc($c['cliente_nombre']) ?></td>
            <td><?= esc($c['direccion_servicio']) ?></td>
            <td><?= esc($c['sector']) ?></td>
            <td class="text-end">
              <a href="<?= site_url('contadores/editar/' . $c['id']) ?>" class="btn btn-sm btn-outline-primary">Editar</a>
              <form action="<?= site_url('contadores/eliminar/' . $c['id']) ?>" method="post"
                    class="d-inline" onsubmit="return confirm('¿Desactivar este contador?');">
                <?= csrf_field() ?>
                <button type="submit" class="btn btn-sm btn-outline-danger">Desactivar</button>
              </form>
            </td>
          </tr>
        <?php endforeach; ?>
        <?php if (empty($contadores)): ?>
          <tr><td colspan="5" class="text-center text-muted py-4">No hay contadores registrados.</td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<?= $this->endSection() ?>