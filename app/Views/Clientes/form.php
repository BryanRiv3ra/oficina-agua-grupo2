<?= $this->extend('layouts/main') ?>

<?= $this->section('contenido') ?>

<?php $editando = isset($cliente) && $cliente !== null; ?>

<h2 class="h6 fw-bold text-primary mb-3"><?= $editando ? 'Editar cliente' : 'Nuevo cliente' ?></h2>

<?php if (session('errors')): ?>
  <div class="alert alert-danger">
    <ul class="mb-0">
      <?php foreach (session('errors') as $err): ?>
        <li><?= esc($err) ?></li>
      <?php endforeach; ?>
    </ul>
  </div>
<?php endif; ?>

<div class="card border-0 shadow-sm">
  <div class="card-body">
    <form method="post" action="<?= $editando ? site_url('clientes/actualizar/' . $cliente['id']) : site_url('clientes/guardar') ?>">
      <?= csrf_field() ?>

      <?php if (!$editando): ?>
        <input type="hidden" name="token" value="<?= esc($token ?? '') ?>">
        <script>
          document.querySelector('form').addEventListener('submit', function () {
            this.querySelector('button[type="submit"]').disabled = true;
          });
        </script>
      <?php endif; ?>

      <div class="mb-3">
        <label class="form-label fw-semibold">Nombre</label>
        <input type="text" name="nombre" class="form-control" required
               value="<?= esc(old('nombre', $cliente['nombre'] ?? '')) ?>">
      </div>

      <div class="mb-3">
        <label class="form-label fw-semibold">Teléfono</label>
        <input type="text" name="telefono" class="form-control"
               value="<?= esc(old('telefono', $cliente['telefono'] ?? '')) ?>">
      </div>

      <div class="mb-4">
        <label class="form-label fw-semibold">Dirección principal</label>
        <input type="text" name="direccion_principal" class="form-control" required
               value="<?= esc(old('direccion_principal', $cliente['direccion_principal'] ?? '')) ?>">
      </div>

      <button type="submit" class="btn btn-primary">Guardar</button>
      <a href="<?= site_url('clientes') ?>" class="btn btn-outline-secondary">Cancelar</a>
    </form>
  </div>
</div>

<?= $this->endSection() ?>