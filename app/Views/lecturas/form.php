<?= $this->extend('layouts/main') ?>

<?= $this->section('contenido') ?>

<div class="container-fluid py-4">

    <div class="mb-4">
        <h1 class="h3 mb-1">Registrar lectura</h1>
        <p class="text-muted mb-0">
            Ingrese la lectura actual del contador.
        </p>
    </div>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger">
            <?= esc(session()->getFlashdata('error')) ?>
        </div>
    <?php endif; ?>

    <div class="card border-0 shadow-sm">
        <div class="card-body">

            <div class="mb-4">
                <h2 class="h5 mb-3">Información del contador</h2>

                <p class="mb-1">
                    <strong>Registro:</strong>
                    <?= esc($contador['numero_registro']) ?>
                </p>

                <p class="mb-1">
                    <strong>Cliente:</strong>
                    <?= esc($contador['cliente_nombre']) ?>
                </p>

                <p class="mb-0">
                    <strong>Dirección:</strong>
                    <?= esc($contador['direccion_servicio']) ?>
                </p>
            </div>

            <form
                action="<?= site_url('lecturas/guardar') ?>"
                method="post"
            >

                <?= csrf_field() ?>

                <input
                    type="hidden"
                    name="contador_id"
                    value="<?= esc($contador['id']) ?>"
                >

                <div class="mb-3">
                    <label for="fecha_lectura" class="form-label">
                        Fecha de lectura
                    </label>

                    <input
                        type="date"
                        class="form-control"
                        id="fecha_lectura"
                        name="fecha_lectura"
                        value="<?= old('fecha_lectura', date('Y-m-d')) ?>"
                        required
                    >

                    <div class="form-text">
                        La tarifa se seleccionará según la fecha indicada.
                    </div>
                </div>

                <div class="mb-3">
                    <label for="periodo" class="form-label">
                        Período
                    </label>

                    <input
                        type="text"
                        class="form-control"
                        id="periodo"
                        value="<?= esc($periodo) ?>"
                        readonly
                    >
                </div>

                <div class="mb-3">
                    <label for="lectura_anterior" class="form-label">
                        Lectura anterior
                    </label>

                    <input
                        type="number"
                        class="form-control"
                        id="lectura_anterior"
                        value="<?= esc($lecturaAnterior) ?>"
                        readonly
                    >
                </div>

                <div class="mb-4">
                    <label for="lectura_actual" class="form-label">
                        Lectura actual
                    </label>

                    <input
                        type="number"
                        class="form-control"
                        id="lectura_actual"
                        name="lectura_actual"
                        min="<?= esc($lecturaAnterior) ?>"
                        step="0.01"
                        value="<?= old('lectura_actual') ?>"
                        required
                    >

                    <div class="form-text">
                        La lectura actual debe ser igual o mayor que la
                        lectura anterior.
                    </div>
                </div>

                <div class="d-flex flex-column flex-sm-row gap-2">

                    <a
                        href="<?= site_url('lecturas') ?>"
                        class="btn btn-outline-secondary"
                    >
                        Cancelar
                    </a>

                    <button
                        type="submit"
                        class="btn btn-primary"
                    >
                        Guardar lectura
                    </button>

                </div>

            </form>

        </div>
    </div>

</div>

<?= $this->endSection() ?>