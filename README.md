# AQUORA — Sistema Integrado de Gestión de Agua

Sistema web para la administración de clientes, contadores, tarifas, lecturas, pagos y recibos de una oficina municipal de agua potable. Proyecto desarrollado por el **Grupo 2 — Stack 1** como parte del curso de Desarrollo Web.

## Demo en vivo

El sistema está desplegado y disponible públicamente en:

### 🔗 [https://aquora.duckdns.org](https://aquora.duckdns.org)

Puedes ingresar directamente con las credenciales de prueba indicadas en la sección [Credenciales de prueba](#credenciales-de-prueba) más abajo, sin necesidad de instalar nada localmente.

## Equipo de desarrollo

| Nombre completo | Carnet | Correo electrónico | Rol en el equipo |
|---|---|---|---|
| Bryan Josué Rivera Hernández — **Líder del equipo** | 0905-23-1623 | briverah6@miumg.edu.gt | Coordinador + CRUD + UI / Integración |
| Blanky Marisol López Marroquín | 0905-23-5227 | blopezm50@miumg.edu.gt | Base de datos |
| Jesús Alberto Quintanilla Monzón | 0905-21-9366 | jquintanillam2@miumg.edu.gt | Tarifas / Lecturas |
| Yenci María Hernández Martínez | 0905-23-6756 | yhernandezm11@miumg.edu.gt | Autenticación y roles |

**Proyecto en Jira:** [Grupo 2 Stack 1 — Tablero](https://miumg-team-os5t4oqe.atlassian.net/?continue=https%3A%2F%2Fmiumg-team-os5t4oqe.atlassian.net%2Fwelcome%2Fsoftware%3FprojectId%3D10001&atlOrigin=eyJpIjoiYjI4Yzk4ODQ3ODMyNGIyM2FiZTM3MzJjMzdiNDY4YmUiLCJwIjoiamlyYS1zb2Z0d2FyZSJ9)

## Descripción

AQUORA centraliza el ciclo completo del servicio de agua: registro de clientes y sus contadores, definición de tarifas vigentes, captura de lecturas mensuales, cálculo automático de consumo y monto a pagar, registro de pagos y generación de recibos imprimibles. El acceso está controlado por roles, de modo que cada usuario solo ve y utiliza las opciones que le corresponden.

## Funcionalidades principales

- **Autenticación y control de acceso** con tres roles: Administrador, Secretaria y Lector. Cada rol tiene un menú y permisos distintos; el sistema bloquea el acceso directo por URL a secciones no autorizadas.
- **Panel principal** con indicadores generales: clientes activos, contadores activos, sectores cubiertos y lecturas pendientes de pago.
- **Gestión de clientes y contadores**, incluyendo dirección de servicio y sector de cada contador.
- **Gestión de tarifas**: tarifa simple por metro cúbico, con vigencia (`vigente_desde` / `vigente_hasta`). Al crear una tarifa nueva, la anterior se cierra automáticamente, y el sistema rechaza tarifas cuyo periodo se solape con una ya existente.
- **Registro de lecturas**, con cálculo automático de consumo (lectura actual − lectura anterior) y monto a pagar según la tarifa vigente.
- **Registro de pagos**, con validación de número de boleta obligatorio cuando el método de pago es depósito o transferencia.
- **Recibo de pago imprimible**, con formato de tique (ticket), que incluye los datos del cliente, el contador, el periodo, el desglose de lecturas/consumo/tarifa y el total a pagar.
- **Estado de cuenta** por cliente.

## Tecnologías utilizadas

- **Backend:** PHP 8.3 + CodeIgniter 4
- **Base de datos:** MariaDB / MySQL
- **Frontend:** Bootstrap 5.3, tipografías Inter y JetBrains Mono
- **Control de versiones:** Git y GitHub (flujo de ramas `feature/*` y `fix/*` hacia `develop`)
- **Gestión del proyecto:** Jira

## Instalación y configuración local

Esta sección es solo para quien quiera correr el proyecto en su propia computadora (por ejemplo, para seguir desarrollando). Para simplemente usar el sistema, entra directo a la [demo en vivo](#demo-en-vivo).

### Requisitos previos

- PHP 8.1 o superior
- Composer
- MariaDB o MySQL
- Git

### Pasos

1. Clonar el repositorio:
   ```bash
   git clone https://github.com/BryanRiv3ra/oficina-agua-grupo2.git
   cd oficina-agua-grupo2
   ```

2. Instalar las dependencias de PHP:
   ```bash
   composer install
   ```

3. Copiar el archivo de entorno de ejemplo y configurarlo:
   ```bash
   cp .env.example .env
   ```
   Editar `.env` y descomentar/completar la sección de `DATABASE` con los datos de tu servidor local (hostname, nombre de base de datos, usuario y contraseña).

4. Ejecutar las migraciones para crear las tablas:
   ```bash
   php spark migrate
   ```

5. (Opcional) Ejecutar los seeders para cargar datos de ejemplo, incluyendo el usuario administrador:
   ```bash
   php spark db:seed RolesUsuariosSeeder
   ```

6. Levantar el servidor de desarrollo:
   ```bash
   php spark serve
   ```

7. Abrir el navegador en `http://localhost:8080/index.php/login`.

### Credenciales de prueba

| Rol | Correo | Contraseña |
|---|---|---|
| Administrador | admin@oficina-agua.local | Admin1234 |
| Secretaria | secretaria@oficina-agua.local | Admin1234 |
| Lector | lector@oficina-agua.local | Admin1234 |

## Manual de usuario

Consultar el documento [`Manual_de_usuario_AQUORA.pdf`](./Manual_de_usuario_AQUORA.pdf) incluido en este repositorio para una guía visual paso a paso de cada módulo del sistema.
