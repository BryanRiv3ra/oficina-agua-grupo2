<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= $titulo ?? 'Iniciar sesión' ?> — Oficina del Agua</title>
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css" rel="stylesheet">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
</head>
<body>

<div id="acceso" class="d-flex align-items-center justify-content-center">
  <div class="card border-0 shadow tarjeta-acceso">
    <div class="card-body p-4">

      <div class="text-center mb-4">
        <div class="fs-1">💧</div>
        <h1 class="h5 fw-bold text-primary mb-1">Oficina del Agua</h1>
        <p class="text-muted small mb-0">Ingresa con tu usuario del sistema</p>
      </div>

      <?php if (session('error')): ?>
        <div class="alert alert-danger py-2 small"><?= esc(session('error')) ?></div>
      <?php endif; ?>

      <?php if (session('mensaje')): ?>
        <div class="alert alert-success py-2 small"><?= esc(session('mensaje')) ?></div>
      <?php endif; ?>

      <form action="<?= site_url('login') ?>" method="post" autocomplete="off">
        <?= csrf_field() ?>

        <div class="mb-3">
          <label for="email" class="form-label small fw-semibold">Correo electrónico</label>
          <input type="email" class="form-control" id="email" name="email"
                 value="<?= esc(old('email')) ?>" placeholder="usuario@oficina-agua.local" required autofocus>
        </div>

        <div class="mb-4">
          <label for="password" class="form-label small fw-semibold">Contraseña</label>
          <input type="password" class="form-control" id="password" name="password" required>
        </div>

        <button type="submit" class="btn btn-primary w-100">Entrar</button>
      </form>

    </div>
  </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
</body>
</html>