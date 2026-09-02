<?= $this->extend('layouts/main') ?>

<?= $this->section('contenido') ?>

<div class="container-fluid py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1">Registro de lecturas</h1>
            <p class="text-muted mb-0">
                Contadores pendientes del período <?= esc($periodo) ?>
            </p>
        </div>
    </div>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger">
            <?= esc(session()->getFlashdata('error')) ?>
        </div>
    <?php endif; ?>

    <div class="card border-0 shadow-sm">
        <div class="card-body">

            <?php if (empty($contadores)): ?>

                <div class="text-center py-4">
                    <p class="text-muted mb-0">
                        No hay contadores pendientes de lectura para este período.
                    </p>
                </div>

            <?php else: ?>

                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead>
                            <tr>
                                <th>Registro</th>
                                <th>Cliente</th>
                                <th>Dirección</th>
                                <th>Sector</th>
                                <th class="text-end">Acción</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php foreach ($contadores as $contador): ?>
                                <tr>
                                    <td>
                                        <?= esc($contador['numero_registro']) ?>
                                    </td>

                                    <td>
                                        <?= esc($contador['cliente_nombre']) ?>
                                    </td>

                                    <td>
                                        <?= esc($contador['direccion_servicio']) ?>
                                    </td>

                                    <td>
                                        <?= esc($contador['sector'] ?? '-') ?>
                                    </td>

                                    <td class="text-end">
                                        <a
                                            href="<?= site_url('lecturas/registrar/' . $contador['id']) ?>"
                                            class="btn btn-sm btn-primary"
                                        >
                                            Registrar lectura
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>

                    </table>
                </div>

            <?php endif; ?>

        </div>
    </div>

</div>

<?= $this->endSection() ?>