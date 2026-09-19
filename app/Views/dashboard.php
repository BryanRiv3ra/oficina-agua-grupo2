<?= $this->extend('layouts/main') ?>

<?= $this->section('contenido') ?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css">

<script>
  // Se ejecuta antes de pintar el contenido para evitar el parpadeo blanco
  // cuando el usuario tiene guardado el modo oscuro.
  (function () {
    try {
      if (localStorage.getItem('aquora-tema') === 'oscuro') {
        document.documentElement.classList.add('tema-oscuro');
      }
    } catch (e) {
      // Si el navegador bloquea localStorage, simplemente se queda en modo claro.
    }
  })();
</script>

<style>
  /* ---------- Variables: un solo lugar donde cambian los colores ---------- */
  :root {
    --fondo-panel:   transparent;
    --fondo-tarjeta: #ffffff;
    --texto-titulo:  #0b4a5e;
    --texto-valor:   #0b4a5e;
    --texto-rotulo:  #6c757d;
    --texto-cuerpo:  #6c757d;
    --borde-suave:   rgba(0,0,0,.06);
    --velo-franja:   linear-gradient(90deg, rgba(255,255,255,.88) 0%, rgba(255,255,255,.70) 40%, rgba(255,255,255,.20) 100%);
        --foto-franja:   url('<?= base_url('assets/img/Lago-de-noche.png') ?>');
  }

  html.tema-oscuro {
    --fondo-panel:   #0f1b22;
    --fondo-tarjeta: #16252e;
    --texto-titulo:  #6fd3e8;
    --texto-valor:   #8ad9ec;
    --texto-rotulo:  #9bb2bd;
    --texto-cuerpo:  #adc2cc;
    --borde-suave:   rgba(255,255,255,.08);
    --velo-franja:   linear-gradient(90deg, rgba(15,27,34,.94) 0%, rgba(15,27,34,.80) 40%, rgba(15,27,34,.30) 100%);
        --foto-franja:   url('<?= base_url('assets/img/Lago-de-noche.png') ?>');
  }

  /* El fondo del área de contenido solo se pinta en modo oscuro,
     para no alterar el layout del equipo en modo claro. */
  html.tema-oscuro body { background-color: var(--fondo-panel); }

  /* ---------- Interruptor ---------- */
  .barra-tema {
    display: flex;
    justify-content: flex-end;
    margin-bottom: 1rem;
  }

  .btn-tema {
    display: inline-flex;
    align-items: center;
    gap: .45rem;
    border: 1px solid var(--borde-suave);
    background: var(--fondo-tarjeta);
    color: var(--texto-rotulo);
    border-radius: 50px;
    padding: .4rem 1rem;
    font-size: .8rem;
    font-weight: 600;
    cursor: pointer;
    transition: background .2s ease, color .2s ease, transform .15s ease;
  }

  .btn-tema:hover { transform: translateY(-1px); color: var(--texto-titulo); }

  /* ---------- Tarjetas ---------- */
  .tarjeta-dato {
    border-radius: 14px;
    background: var(--fondo-tarjeta);
    transition: transform .15s ease, box-shadow .15s ease, background .2s ease;
  }
  .tarjeta-dato:hover { transform: translateY(-2px); box-shadow: 0 .5rem 1.2rem rgba(0,0,0,.18) !important; }

  .icono-dato {
    width: 44px; height: 44px;
    display: flex; align-items: center; justify-content: center;
    border-radius: 12px;
    font-size: 1.35rem;
  }

  .icono-clientes   { background: rgba(13,110,253,.12); color: #4d9bff; }
  .icono-contadores { background: rgba(13,202,240,.14); color: #3fc4dd; }
  .icono-sectores   { background: rgba(25,135,84,.12);  color: #38b874; }
  .icono-pendiente  { background: rgba(220,53,69,.12);  color: #f06b78; }
  .icono-ok         { background: rgba(25,135,84,.12);  color: #38b874; }

  html:not(.tema-oscuro) .icono-clientes   { color: #0d6efd; }
  html:not(.tema-oscuro) .icono-contadores { color: #0aa2c0; }
  html:not(.tema-oscuro) .icono-sectores   { color: #198754; }
  html:not(.tema-oscuro) .icono-pendiente  { color: #dc3545; }
  html:not(.tema-oscuro) .icono-ok         { color: #198754; }

  .rotulo-dato {
    font-size: .72rem;
    letter-spacing: .04em;
    color: var(--texto-rotulo) !important;
  }

  .valor-dato {
    font-size: 2rem;
    font-weight: 700;
    line-height: 1.1;
    color: var(--texto-valor);
  }

  .titulo-tarjeta { color: var(--texto-titulo) !important; }
  .cuerpo-tarjeta { color: var(--texto-cuerpo) !important; }

  /* ---------- Franja de bienvenida ---------- */
  .franja-bienvenida {
    position: relative;
    border-radius: 14px;
    overflow: hidden;
        background: var(--foto-franja) center center / 100% auto no-repeat;
  }

  .franja-bienvenida::before {
    content: '';
    position: absolute;
    inset: 0;
    background: var(--velo-franja);
  }

  .franja-bienvenida .card-body { position: relative; }
</style>

<div class="barra-tema">
  <button type="button" class="btn-tema" id="btnTema">
    <i class="bi" id="iconoTema"></i>
    <span id="textoTema"></span>
  </button>
</div>

<div class="row g-3 mb-4">

  <div class="col-6 col-md-3">
    <div class="card border-0 shadow-sm h-100 tarjeta-dato">
      <div class="card-body">
        <div class="d-flex align-items-center gap-2 mb-3">
          <span class="icono-dato icono-clientes"><i class="bi bi-people-fill"></i></span>
          <div class="text-uppercase fw-semibold rotulo-dato">Clientes activos</div>
        </div>
        <div class="valor-dato"><?= $totalClientes ?></div>
      </div>
    
    </div>
  </div>

  <div class="col-6 col-md-3">
    <div class="card border-0 shadow-sm h-100 tarjeta-dato">
      <div class="card-body">
        <div class="d-flex align-items-center gap-2 mb-3">
          <span class="icono-dato icono-contadores"><i class="bi bi-speedometer2"></i></span>
          <div class="text-uppercase fw-semibold rotulo-dato">Contadores activos</div>
        </div>
        <div class="valor-dato"><?= $totalContadores ?></div>
      </div>
    </div>
  </div>

  <div class="col-6 col-md-3">
    <div class="card border-0 shadow-sm h-100 tarjeta-dato">
      <div class="card-body">
        <div class="d-flex align-items-center gap-2 mb-3">
          <span class="icono-dato icono-sectores"><i class="bi bi-geo-alt-fill"></i></span>
          <div class="text-uppercase fw-semibold rotulo-dato">Sectores cubiertos</div>
        </div>
        <div class="valor-dato"><?= $totalSectores ?></div>
      </div>
    </div>
  </div>

  <div class="col-6 col-md-3">
    <div class="card border-0 shadow-sm h-100 tarjeta-dato">
      <div class="card-body">
        <div class="d-flex align-items-center gap-2 mb-3">
          <span class="icono-dato <?= $lecturasPendientes > 0 ? 'icono-pendiente' : 'icono-ok' ?>">
            <i class="bi <?= $lecturasPendientes > 0 ? 'bi-exclamation-triangle-fill' : 'bi-check-circle-fill' ?>"></i>
          </span>
          <div class="text-uppercase fw-semibold rotulo-dato">Lecturas sin pagar</div>
        </div>
        <div class="valor-dato <?= $lecturasPendientes > 0 ? 'text-danger' : 'text-success' ?>">
          <?= $lecturasPendientes ?>
        </div>
        <?php if ($lecturasPendientes > 0): ?>
          <a href="<?= site_url('estado-cuenta?estado=pendiente') ?>" class="small text-decoration-none">
            Ver detalle <i class="bi bi-arrow-right"></i>
          </a>
        <?php else: ?>
          <span class="small text-success">Todo al día</span>
        <?php endif; ?>
      </div>
    </div>
  </div>

</div>

<div class="card border-0 shadow-sm franja-bienvenida">
  <div class="card-body" style="min-height: 320px;">
    <h2 class="h6 fw-bold titulo-tarjeta mb-2">
      <i class="bi bi-droplet-fill me-1"></i> Bienvenido a AQUORA
    </h2>
    <p class="small mb-0 cuerpo-tarjeta" style="max-width: 60ch;">
      Sistema Integrado de Gestión de Agua - desde aquí administras clientes,
      contadores, tarifas, el registro de lecturas casa por casa, el cobro en
      oficina y el estado de cuenta de cada usuario.
    </p>
  </div>
</div>

<script>
  (function () {
    const raiz   = document.documentElement;
    const boton  = document.getElementById('btnTema');
    const icono  = document.getElementById('iconoTema');
    const texto  = document.getElementById('textoTema');
    const CLAVE  = 'aquora-tema';

    function pintarBoton() {
      const oscuro = raiz.classList.contains('tema-oscuro');
      icono.className = oscuro ? 'bi bi-sun-fill' : 'bi bi-moon-stars-fill';
      texto.textContent = oscuro ? 'Modo claro' : 'Modo oscuro';
    }

    boton.addEventListener('click', function () {
      const oscuro = raiz.classList.toggle('tema-oscuro');
      try {
        localStorage.setItem(CLAVE, oscuro ? 'oscuro' : 'claro');
      } catch (e) {
        // Si no se puede guardar, el tema igual cambia durante esta visita.
      }
      pintarBoton();
    });

    pintarBoton();
  })();
</script>

<?= $this->endSection() ?>



