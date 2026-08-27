<?= $this->extend('layouts/main') ?>

<?= $this->section('contenido') ?>

<?php if (session('mensaje')): ?>
  <div class="alert alert-success"><?= session('mensaje') ?></div>
<?php endif; ?>

<div class="d-flex justify-content-between align-items-center mb-3">
  <h2 class="h6 fw-bold text-primary mb-0">Contadores desactivados</h2>
  <a href="<?= site_url('contadores') ?>" class="btn btn-outline-secondary btn-sm">← Volver a contadores activos</a>
</div>

<div class="card border-0 shadow-sm">
  <div class="table-responsive">
    <table class="table table-hover align-middle mb-0">
      <thead class="table-light">
        <tr>
          <th>Nº Registro</th>
          <th>Cliente</th>
          <th>Dirección de servicio</th>
          <th class="text-end">Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($contadores as $c): ?>
          <tr>
            <td class="fw-mono"><?= esc($c['numero_registro']) ?></td>
            <td><?= esc($c['cliente_nombre']) ?></td>
            <td><?= esc($c['direccion_servicio']) ?></td>
            <td class="text-end">
              <form action="<?= site_url('contadores/reactivar/' . $c['id']) ?>" method="post" class="d-inline">
                <?= csrf_field() ?>
                <button type="submit" class="btn btn-sm btn-outline-success">Reactivar</button>
              </form>
            </td>
          </tr>
        <?php endforeach; ?>
        <?php if (empty($contadores)): ?>
          <tr><td colspan="4" class="text-center text-muted py-4">No hay contadores desactivados.</td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<?= $this->endSection() ?>