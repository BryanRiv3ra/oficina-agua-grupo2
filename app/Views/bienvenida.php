<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>AQUORA — Sistema Integrado de Gestión de Agua</title>
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css" rel="stylesheet">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<style>
  body {
    margin: 0;
    min-height: 100vh;
    font-family: 'Inter', system-ui, sans-serif;
    background: url('<?= base_url('assets/img/semuc.jpg') ?>') center center / cover no-repeat fixed;
  }

  body::before {
    content: '';
    position: fixed;
    inset: 0;
    background: linear-gradient(180deg, rgba(4,28,38,.45) 0%, rgba(4,28,38,.65) 100%);
  }

  .portada {
    position: relative;
    min-height: 100vh;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    text-align: center;
    padding: 2rem 1.5rem;
  }

  .logo-portada {
    width: 460px;
    max-width: 85%;
    height: auto;
    filter: drop-shadow(0 6px 18px rgba(0,0,0,.35));
  }

  .lema-portada {
    color: rgba(255,255,255,.88);
    font-size: 1.05rem;
    font-weight: 500;
    letter-spacing: .02em;
    margin-top: 1.25rem;
    margin-bottom: 2.5rem;
    text-shadow: 0 2px 10px rgba(0,0,0,.4);
  }

  .btn-comenzar {
    display: inline-block;
    border: none;
    border-radius: 50px;
    padding: .85rem 3.5rem;
    font-weight: 700;
    font-size: 1.05rem;
    color: #0b4a5e;
    background: #fff;
    text-decoration: none;
    box-shadow: 0 8px 24px rgba(0,0,0,.28);
    transition: transform .15s ease, box-shadow .15s ease;
  }

   .btn-comenzar:hover {
    transform: translateY(-2px);
    box-shadow: 0 12px 30px rgba(0,0,0,.35);
    background: #0b4a5e;
    color: #fff;
  }

  .btn-comenzar:active {
    transform: translateY(0);
    background: #063542;
    color: #fff;
  }
  .pie-portada {
    position: absolute;
    bottom: 1.5rem;
    left: 0; right: 0;
    color: rgba(255,255,255,.65);
    font-size: .75rem;
  }
</style>
</head>
<body>

<div class="portada">
  <img src="<?= base_url('assets/img/logoAquora.png') ?>" alt="AQUORA" class="logo-portada">

  <p class="lema-portada">Sistema Integrado de Gestión de Agua</p>

  <a href="<?= site_url('login') ?>" class="btn-comenzar">Comenzar</a>

  <div class="pie-portada">Oficina Comunitaria de Agua Potable</div>
</div>

</body>
</html>