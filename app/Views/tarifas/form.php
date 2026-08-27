<?= $this->extend('layouts/main') ?>

<?= $this->section('contenido') ?>

<?php
    $esEdicion = !empty($tarifa);
?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h2 class="h6 fw-bold text-primary mb-0">
        <?= $esEdicion ? 'Editar tarifa' : 'Nueva tarifa' ?>
    </h2>

    <a href="<?= site_url('tarifas') ?>" class="btn btn-outline-secondary btn-sm">
        Volver
    </a>
</div>

<?php if (session('errors')): ?>
    <div class="alert alert-danger">
        <ul class="mb-0">
            <?php foreach (session('errors') as $error): ?>
                <li><?= esc($error) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<form
    action="<?= $esEdicion
        ? site_url('tarifas/actualizar/' . $tarifa['id'])
        : site_url('tarifas/guardar') ?>"
    method="post"
>
    <?= csrf_field() ?>

    <div class="card border-0 shadow-sm">
        <div class="card-body">

            <div class="mb-3">
                <label for="monto_por_unidad" class="form-label">
                    Monto por unidad
                </label>

                <input
                    type="number"
                    name="monto_por_unidad"
                    id="monto_por_unidad"
                    class="form-control"
                    step="0.01"
                    min="0"
                    required
                    value="<?= old(
                        'monto_por_unidad',
                        $tarifa['monto_por_unidad'] ?? ''
                    ) ?>"
                >

                <div class="form-text">
                    Precio por m³ de consumo.
                </div>
            </div>

            <div class="mb-3">
                <label for="vigente_desde" class="form-label">
                    Vigente desde
                </label>

                <input
                    type="date"
                    name="vigente_desde"
                    id="vigente_desde"
                    class="form-control"
                    required
                    value="<?= old(
                        'vigente_desde',
                        $tarifa['vigente_desde'] ?? ''
                    ) ?>"
                >
            </div>

            <div class="mb-3">
                <label for="vigente_hasta" class="form-label">
                    Vigente hasta
                </label>

                <input
                    type="date"
                    name="vigente_hasta"
                    id="vigente_hasta"
                    class="form-control"
                    value="<?= old(
                        'vigente_hasta',
                        $tarifa['vigente_hasta'] ?? ''
                    ) ?>"
                >

                <div class="form-text">
                    Déjalo vacío si la tarifa seguirá vigente.
                </div>
            </div>

        </div>

        <div class="card-footer bg-white border-0 text-end">
            <a
                href="<?= site_url('tarifas') ?>"
                class="btn btn-outline-secondary"
            >
                Cancelar
            </a>

            <button type="submit" class="btn btn-primary">
                <?= $esEdicion ? 'Actualizar tarifa' : 'Guardar tarifa' ?>
            </button>
        </div>
    </div>
</form>

<?= $this->endSection() ?>