<?php

use App\Models\LecturaModel;
use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\DatabaseTestTrait;

/**
 * @internal
 */
final class LecturaModelTest extends CIUnitTestCase
{
    use DatabaseTestTrait;

    protected function setUp(): void
    {
        parent::setUp();

        // Eliminar la tabla si quedó de una prueba anterior.
        $this->db->query('DROP TABLE IF EXISTS db_lecturas');

        // Crear la tabla utilizada por LecturaModel.
        $this->db->query('
            CREATE TABLE db_lecturas (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                contador_id INTEGER NOT NULL,
                periodo CHAR(7) NOT NULL,
                usuario_lector_id INTEGER NOT NULL DEFAULT 1,
                fecha_lectura DATE NOT NULL DEFAULT "2026-09-01",
                lectura_anterior DECIMAL(10,2) NOT NULL DEFAULT 0,
                lectura_actual DECIMAL(10,2) NOT NULL DEFAULT 0,
                consumo DECIMAL(10,2) NOT NULL DEFAULT 0,
                tarifa_id INTEGER NOT NULL DEFAULT 1,
                monto DECIMAL(10,2) NOT NULL DEFAULT 0,
                creado_en TIMESTAMP NULL
            )
        ');
    }

    protected function tearDown(): void
    {
        $this->db->query('DROP TABLE IF EXISTS db_lecturas');

        parent::tearDown();
    }

    public function testDetectaLecturaExistenteEnElMismoPeriodo(): void
    {
        $model = new LecturaModel();

        $model->insert([
            'contador_id' => 1,
            'periodo'     => '2026-09',
        ]);

        $resultado = $model->existeEnPeriodo(1, '2026-09');

        $this->assertTrue($resultado);
    }

    public function testNoDetectaLecturaCuandoElPeriodoEsDiferente(): void
    {
        $model = new LecturaModel();

        $model->insert([
            'contador_id' => 1,
            'periodo'     => '2026-09',
        ]);

        $resultado = $model->existeEnPeriodo(1, '2026-10');

        $this->assertFalse($resultado);
    }

    public function testNoDetectaLecturaCuandoElContadorEsDiferente(): void
    {
        $model = new LecturaModel();

        $model->insert([
            'contador_id' => 1,
            'periodo'     => '2026-09',
        ]);

        $resultado = $model->existeEnPeriodo(2, '2026-09');

        $this->assertFalse($resultado);
    }
}