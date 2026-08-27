<?= $this->extend('layouts/main') ?>

<?= $this->section('contenido') ?>

<?php if (session('mensaje')): ?>
  <div class="alert alert-success"><?= session('mensaje') ?></div>
<?php endif; ?>

<div class="d-flex justify-content-between align-items-center mb-3">
  <h2 class="h6 fw-bold text-primary mb-0">Clientes</h2>
  <div>
    <a href="<?= site_url('clientes/desactivados') ?>" class="btn btn-outline-secondary btn-sm">Ver desactivados</a>
    <a href="<?= site_url('clientes/nuevo') ?>" class="btn btn-primary btn-sm">+ Nuevo cliente</a>
  </div>
</div>

<form method="get" class="mb-3">
  <input type="text" name="q" class="form-control" placeholder="Buscar por nombre..." value="<?= esc($buscar ?? '') ?>">
</form>

<div class="card border-0 shadow-sm">
  <div class="table-responsive">
    <table class="table table-hover align-middle mb-0">
      <thead class="table-light">
        <tr>
          <th>Nombre</th>
          <th>Teléfono</th>
          <th>Dirección principal</th>
          <th class="text-end">Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($clientes as $c): ?>
          <tr>
            <td><?= esc($c['nombre']) ?></td>
            <td><?= esc($c['telefono']) ?></td>
            <td><?= esc($c['direccion_principal']) ?></td>
    
            <td class="text-end">
              <a href="<?= site_url('clientes/editar/' . $c['id']) ?>" class="btn btn-sm btn-outline-primary">Editar</a>
              <form action="<?= site_url('clientes/eliminar/' . $c['id']) ?>" method="post" class="d-inline" onsubmit="return confirm('¿Seguro que quieres desactivar a este cliente?');"> <?= csrf_field() ?>
              <button type="submit" class="btn btn-sm btn-outline-danger">Desactivar</button></form>
            </td>




          </tr>
        <?php endforeach; ?>
        <?php if (empty($clientes)): ?>
          <tr><td colspan="4" class="text-center text-muted py-4">No hay clientes registrados.</td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<?= $this->endSection() ?>