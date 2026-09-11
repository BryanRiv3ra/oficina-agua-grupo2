<nav class="navbar navbar-dark navbar-agua no-imprimir">
  <div class="container-fluid">
    <button class="btn btn-sm btn-outline-light d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebar">
      ☰
    </button>
    <span class="navbar-brand fw-bold d-none d-lg-inline"><?= $titulo ?? 'Panel principal' ?></span>
    <span class="badge bg-light text-primary ms-auto"><?= session('rol') ?? 'Invitado' ?></span>
  </div>
</nav>