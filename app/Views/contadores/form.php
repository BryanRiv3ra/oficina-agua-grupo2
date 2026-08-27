<?= $this->extend('layouts/main') ?>

<?= $this->section('contenido') ?>

<?php $editando = isset($contador) && $contador !== null; ?>

<h2 class="h6 fw-bold text-primary mb-3"><?= $editando ? 'Editar contador' : 'Nuevo contador' ?></h2>

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
    <form method="post" action="<?= $editando ? site_url('contadores/actualizar/' . $contador['id']) : site_url('contadores/guardar') ?>">
      <?= csrf_field() ?>

      <div class="mb-3">
        <label class="form-label fw-semibold">Cliente</label>
        <select name="cliente_id" class="form-select" required>
          <option value="">-- Selecciona un cliente --</option>
          <?php foreach ($clientes as $cl): ?>
            <option value="<?= $cl['id'] ?>" <?= (old('cliente_id', $contador['cliente_id'] ?? '') == $cl['id']) ? 'selected' : '' ?>>
              <?= esc($cl['nombre']) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="mb-3">
        <label class="form-label fw-semibold">Número de registro</label>
        <input type="text" name="numero_registro" class="form-control fw-mono" required
               value="<?= esc(old('numero_registro', $contador['numero_registro'] ?? '')) ?>">
        <div class="form-text">Debe ser único — es lo que el Lector usa para ubicar el contador en campo.</div>
      </div>

      <div class="mb-3">
        <label class="form-label fw-semibold">Dirección de servicio</label>
        <input type="text" name="direccion_servicio" class="form-control" required
               value="<?= esc(old('direccion_servicio', $contador['direccion_servicio'] ?? '')) ?>">
      </div>

      <div class="mb-4">
        <label class="form-label fw-semibold">Sector</label>
        <input type="text" name="sector" class="form-control"
               value="<?= esc(old('sector', $contador['sector'] ?? '')) ?>"
               placeholder="Ej. Barrio Las Viudas, El Bordo, Matambre...">
      </div>

      <button type="submit" class="btn btn-primary">Guardar</button>
      <a href="<?= site_url('contadores') ?>" class="btn btn-outline-secondary">Cancelar</a>
    </form>
  </div>
</div>

<?= $this->endSection() ?>