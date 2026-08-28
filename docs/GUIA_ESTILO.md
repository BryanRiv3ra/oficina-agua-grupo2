# GuÃ­a de estilo y componentes reutilizables



GuÃ­a breve para mantener una apariencia visual consistente en las vistas

del sistema de Oficina de Agua.



---



## 1. Framework visual



El proyecto utiliza **Bootstrap** para el diseño y los componentes de la interfaz.



Las nuevas vistas deben aprovechar las clases y componentes existentes de

Bootstrap antes de crear estilos personalizados.



La plantilla principal se encuentra en:



`app/Views/layouts/main.php`



---



## 2. Paleta de colores



Se utilizan principalmente los colores estándar de Bootstrap.



| Uso | Clase Bootstrap | Aplicación |

|---|---|---|

| Principal | `primary` | TÃ­tulos, botones principales y elementos destacados |

| Éxito | `success` | Operaciones correctas y estados positivos |

| Información | `info` | Información y estados programados |

| Secundario | `secondary` | Estados inactivos o vencidos |

| Peligro | `danger` | Errores y acciones destructivas |

| Claro | `light` | Fondos de encabezados y elementos secundarios |

| Texto muted | `text-muted` | Información secundaria |



### Color de marca



Cuando sea necesario utilizar un color propio de la marca, debe mantenerse

la variable o definición existente en los estilos del proyecto en lugar de

crear diferentes tonos para cada vista.



---



## 3. Cards



Las tarjetas (`card`) se utilizan para agrupar contenido relacionado.



### Estructura recomendada



```html

<div class="card border-0 shadow-sm">

    <div class="card-body">

        <!-- Contenido -->

    </div>

</div>

```



Para formularios y bloques de información se recomienda utilizar:



- `card`

- `card-body`

- `border-0`

- `shadow-sm`



Esto mantiene una apariencia limpia y consistente.



---



## 4. Badges



Los `badge` se utilizan para representar estados o categorías.



### Ejemplos



```html

<span class="badge text-bg-success">

    Vigente

</span>



<span class="badge text-bg-secondary">

    Vencida

</span>



<span class="badge text-bg-info">

    Programada

</span>

```



### Criterio de uso



- `success`: estado activo, correcto o vigente.

- `secondary`: estado inactivo, vencido o neutral.

- `info`: información o estado programado.

- `danger`: errores o situaciones que requieren atención.



Los badges deben contener textos cortos y fáciles de identificar.



---



## 5. Alertas



Las alertas se utilizan para comunicar el resultado de una operación.



### Operación exitosa



```html

<div class="alert alert-success">

    Operación realizada correctamente.

</div>

```



### Error



```html

<div class="alert alert-danger">

    No fue posible realizar la operación.

</div>

```



Se recomienda utilizar mensajes breves y claros.



---



## 6. Offcanvas



El menú lateral utiliza el componente `offcanvas` de Bootstrap para permitir

la navegación en dispositivos pequeños.



La implementación se encuentra en:



`app/Views/layouts/partials/sidebar.php`



Las nuevas vistas no deben crear un segundo menú lateral. Deben utilizar la

estructura proporcionada por la plantilla principal.



---



## 7. Botones



Se deben utilizar las clases estándar de Bootstrap.



### Acción principal



```html

<a class="btn btn-primary">

    Nueva acción

</a>

```



### Acción secundaria



```html

<a class="btn btn-outline-primary">

    Editar

</a>

```



### Tamaño pequeño



Para acciones dentro de tablas:



```html

<a class="btn btn-sm btn-outline-primary">

    Editar

</a>

```



Las acciones deben utilizar textos claros y consistentes.



---



## 8. Tablas



Para listados se recomienda utilizar:



```html

<div class="table-responsive">

    <table class="table table-hover align-middle mb-0">

        ...

    </table>

</div>

```



Clases utilizadas:



- `table`: estructura estándar.

- `table-hover`: resalta la fila al pasar el cursor.

- `align-middle`: centra verticalmente el contenido.

- `table-responsive`: permite desplazamiento horizontal en pantallas pequeñas.

- `mb-0`: elimina el margen inferior innecesario.



---



## 9. Utilidades de texto y espaciado



Se utilizan las utilidades de Bootstrap para evitar estilos CSS innecesarios.



Algunas de las utilizadas actualmente son:



- `fw-bold`: texto en negrita.

- `text-primary`: texto principal.

- `text-muted`: texto secundario.

- `text-end`: alineación a la derecha.

- `mb-0`: elimina margen inferior.

- `mb-3`: separación inferior.

- `py-4`: espaciado vertical.

- `shadow-sm`: sombra ligera.



Antes de crear una clase CSS personalizada, comprobar si Bootstrap ya

proporciona una utilidad equivalente.



---



## 10. Estructura recomendada de una vista



Las vistas deben utilizar la plantilla principal:



```php

<?= $this->extend('layouts/main') ?>



<?= $this->section('contenido') ?>



<!-- Contenido de la vista -->



<?= $this->endSection() ?>

```



La estructura permite mantener el navbar, sidebar y estilos generales

compartidos por las diferentes pantallas.



---



## 11. Reglas generales



1. Reutilizar Bootstrap antes de crear CSS personalizado.

2. Mantener los mismos colores para los mismos significados.

3. Utilizar `card` para agrupar contenido relacionado.

4. Utilizar `badge` para estados cortos.

5. Utilizar `alert` para mensajes de resultado.

6. Utilizar el `offcanvas` existente para la navegación lateral.

7. Mantener botones y acciones con textos claros.

8. Utilizar `table-responsive` para tablas.

9. Mantener la estructura de `layouts/main.php`.

10. Evitar crear componentes visuales duplicados cuando ya existe uno

    reutilizable en el proyecto.



---



## 12. Referencias dentro del proyecto



| Elemento | Ubicación |

|---|---|

| Plantilla principal | `app/Views/layouts/main.php` |

| Navbar | `app/Views/layouts/partials/navbar.php` |

| Sidebar / Offcanvas | `app/Views/layouts/partials/sidebar.php` |

| Ejemplo de cards | `app/Views/dashboard.php` |

| Ejemplo de formularios | `app/Views/Clientes/form.php` |

| Ejemplo de tablas | `app/Views/Clientes/index.php` |

| Ejemplo de estados | `app/Views/tarifas/index.php` |





