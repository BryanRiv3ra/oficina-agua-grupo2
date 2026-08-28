<?php

use App\Models\TarifaModel;
use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\DatabaseTestTrait;

/**
 * @internal
 */
final class TarifaModelTest extends CIUnitTestCase
{
    use DatabaseTestTrait;

    protected function setUp(): void
    {
        parent::setUp();

        // Eliminar la tabla si quedó de una prueba anterior.
        $this->db->query('DROP TABLE IF EXISTS db_tarifas');

        // Crear la tabla utilizada por TarifaModel.
        $this->db->query('
            CREATE TABLE db_tarifas (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                monto_por_unidad DECIMAL(10,2) NOT NULL,
                vigente_desde DATE NOT NULL,
                vigente_hasta DATE NULL,
                activo INTEGER NOT NULL DEFAULT 1
            )
        ');
    }

    protected function tearDown(): void
    {
        $this->db->query('DROP TABLE IF EXISTS db_tarifas');

        parent::tearDown();
    }

    public function testDetectaSolapamiento(): void
    {
        $model = new TarifaModel();

        $model->insert([
            'monto_por_unidad' => 6.50,
            'vigente_desde'    => '2027-03-01',
            'vigente_hasta'    => '2027-03-31',
            'activo'           => 1,
        ]);

        $resultado = $model->existeSolapamiento(
            '2027-03-15',
            '2027-04-15'
        );

        $this->assertTrue($resultado);
    }

    public function testNoDetectaSolapamientoCuandoLosPeriodosSonConsecutivos(): void
    {
        $model = new TarifaModel();

        $model->insert([
            'monto_por_unidad' => 6.50,
            'vigente_desde'    => '2027-03-01',
            'vigente_hasta'    => '2027-03-31',
            'activo'           => 1,
        ]);

        $resultado = $model->existeSolapamiento(
            '2027-04-01',
            '2027-04-30'
        );

        $this->assertFalse($resultado);
    }

    public function testEncuentraTarifaAbiertaAnterior(): void
    {
        $model = new TarifaModel();

        $id = $model->insert([
            'monto_por_unidad' => 6.50,
            'vigente_desde'    => '2027-03-01',
            'vigente_hasta'    => null,
            'activo'           => 1,
        ]);

        $tarifa = $model->obtenerTarifaAbiertaAnterior('2027-04-01');

        $this->assertNotNull($tarifa);
        $this->assertSame($id, (int) $tarifa['id']);
    }
}