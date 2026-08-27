<?= $this->extend('layouts/main') ?>

<?= $this->section('contenido') ?>

<?php if (session('mensaje')): ?>
    <div class="alert alert-success">
        <?= esc(session('mensaje')) ?>
    </div>
<?php endif; ?>

<?php if (session('error')): ?>
    <div class="alert alert-danger">
        <?= esc(session('error')) ?>
    </div>
<?php endif; ?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h2 class="h6 fw-bold text-primary mb-0">Tarifas</h2>

    <a href="<?= site_url('tarifas/nuevo') ?>" class="btn btn-primary btn-sm">
        + Nueva tarifa
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Monto por unidad</th>
                    <th>Vigente desde</th>
                    <th>Vigente hasta</th>
                    <th>Estado</th>
                    <th class="text-end">Acciones</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($tarifas as $tarifa): ?>

                    <?php
                    $hoy = date('Y-m-d');

                    $activa = (int) $tarifa['activo'] === 1;

                    $futura =
                     $activa
                     && $tarifa['vigente_desde'] > $hoy;

                    $vigente =
                       $activa
                     && $tarifa['vigente_desde'] <= $hoy
                     && (
                           empty($tarifa['vigente_hasta'])
                          || $tarifa['vigente_hasta'] >= $hoy
                     );
                    ?>

                    <tr>
                        <td>
                            Q <?= number_format((float) $tarifa['monto_por_unidad'], 2) ?>
                        </td>

                        <td>
                            <?= esc($tarifa['vigente_desde']) ?>
                        </td>

                        <td>
                            <?= !empty($tarifa['vigente_hasta'])
                                ? esc($tarifa['vigente_hasta'])
                                : 'Sin fecha de fin' ?>
                        </td>

                        <td>
                          <?php if ($futura): ?>

                              <span class="badge text-bg-info">
                                  Programada
                             </span>

                            <?php elseif ($vigente): ?>

                                <span class="badge text-bg-success">
                                    Vigente
                               </span>

                         <?php else: ?>

                               <span class="badge text-bg-secondary">
                                   Vencida
                                </span>

                            <?php endif; ?>
                        </td>

                        <td class="text-end">
    <a
        href="<?= site_url('tarifas/editar/' . $tarifa['id']) ?>"
        class="btn btn-sm btn-outline-primary"
    >
        Editar
    </a>

    <?php if ((int) $tarifa['activo'] === 1): ?>
        <form
            action="<?= site_url('tarifas/desactivar/' . $tarifa['id']) ?>"
            method="post"
            class="d-inline"
            onsubmit="return confirm('¿Está seguro de desactivar esta tarifa?');"
        >
            <?= csrf_field() ?>

            <button
                type="submit"
                class="btn btn-sm btn-outline-danger"
            >
                Desactivar
            </button>
        </form>
    <?php endif; ?>
</td>
                    </tr>

                <?php endforeach; ?>

                <?php if (empty($tarifas)): ?>
                    <tr>
                        <td colspan="5" class="text-center text-muted py-4">
                            No hay tarifas registradas.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>