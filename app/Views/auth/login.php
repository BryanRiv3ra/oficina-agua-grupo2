<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= $titulo ?? 'Iniciar sesión' ?> — AQUORA</title>
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css" rel="stylesheet">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<style>
  body {
    margin: 0;
    min-height: 100vh;
    font-family: 'Inter', system-ui, sans-serif;
    background: url('<?= base_url('assets/img/login-bg.jpg') ?>') center center / cover no-repeat fixed;
  }

  /* Capa oscura: sin esto el texto blanco se pierde sobre las zonas claras del agua */
  body::before {
    content: '';
    position: fixed;
    inset: 0;
    background: linear-gradient(135deg, rgba(8, 47, 62, .70), rgba(4, 28, 38, .55));
  }

  .pantalla-acceso {
    position: relative;
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 1.5rem;
  }

  .tarjeta-vidrio {
    width: 100%;
    max-width: 400px;
    padding: 2.5rem 2rem;
    border-radius: 20px;
    background: rgba(255, 255, 255, .12);
    border: 1px solid rgba(255, 255, 255, .25);
    backdrop-filter: blur(14px);
    -webkit-backdrop-filter: blur(14px);
    box-shadow: 0 20px 50px rgba(0, 0, 0, .35);
    color: #fff;
  }

  .logo-acceso {
    width: 200px;
    max-width: 80%;
    height: auto;
    display: block;
    margin: 0 auto;
  }

  .marca-sub {
    color: rgba(255, 255, 255, .75);
    font-size: .85rem;
  }

  .tarjeta-vidrio .form-label {
    color: rgba(255, 255, 255, .85);
    font-size: .8rem;
    font-weight: 600;
  }

  .tarjeta-vidrio .form-control {
    background: rgba(255, 255, 255, .10);
    border: 1px solid rgba(255, 255, 255, .30);
    border-radius: 50px;
    padding: .7rem 1.1rem;
    color: #fff;
  }

  .tarjeta-vidrio .form-control::placeholder {
    color: rgba(255, 255, 255, .55);
  }

  .tarjeta-vidrio .form-control:focus {
    background: rgba(255, 255, 255, .18);
    border-color: rgba(255, 255, 255, .70);
    color: #fff;
    box-shadow: 0 0 0 .2rem rgba(255, 255, 255, .15);
  }

  .btn-acceso {
    width: 100%;
    border: none;
    border-radius: 50px;
    padding: .7rem;
    font-weight: 700;
    color: #0b4a5e;
    background: #fff;
    transition: transform .15s ease, box-shadow .15s ease;
  }

  .btn-acceso:hover {
    transform: translateY(-1px);
    box-shadow: 0 8px 20px rgba(0, 0, 0, .25);
    color: #0b4a5e;
  }

  .aviso {
    border: none;
    border-radius: 12px;
    font-size: .85rem;
    padding: .6rem .9rem;
  }

  .aviso-error { background: rgba(220, 53, 69, .85); color: #fff; }
  .aviso-exito { background: rgba(25, 135, 84, .85); color: #fff; }

  .pie-acceso {
    text-align: center;
    margin-top: 1.5rem;
    font-size: .75rem;
    color: rgba(255, 255, 255, .6);
  }
</style>
</head>
<body>

<div class="pantalla-acceso">
  <div class="tarjeta-vidrio">

    <div class="text-center mb-4">
      <img src="<?= base_url('assets/img/logoAquora.png') ?>" alt="AQUORA" class="logo-acceso">
      <p class="marca-sub mb-0 mt-2">Sistema Integrado de Gestión de Agua</p>
    </div>

    <?php if (session('error')): ?>
      <div class="aviso aviso-error mb-3"><?= esc(session('error')) ?></div>
    <?php endif; ?>

    <?php if (session('mensaje')): ?>
      <div class="aviso aviso-exito mb-3"><?= esc(session('mensaje')) ?></div>
    <?php endif; ?>

    <form action="<?= site_url('login') ?>" method="post" autocomplete="off">
      <?= csrf_field() ?>

      <div class="mb-3">
        <label for="email" class="form-label">Correo electrónico</label>
        <input type="email" class="form-control" id="email" name="email"
               value="<?= esc(old('email')) ?>" placeholder="usuario@oficina-agua.local"
               required autofocus>
      </div>

      <div class="mb-4">
        <label for="password" class="form-label">Contraseña</label>
        <input type="password" class="form-control" id="password" name="password"
               placeholder="••••••••" required>
      </div>

      <button type="submit" class="btn btn-acceso">Entrar</button>
    </form>

    <div class="pie-acceso">Oficina Comunitaria de Agua Potable</div>

  </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
</body>
</html>