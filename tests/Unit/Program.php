<?php

namespace Tests\Unit;

use App\Http\Controllers\ProgramController;
use App\Http\Requests\StoreProgramRequest;
use App\Http\Requests\UpdateProgramRequest;
use App\Repositories\ProgramRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class Program extends TestCase
{
    use RefreshDatabase;

    private $programRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->programRepository = $this->createMock(ProgramRepository::class);
    }

    public function testIndex()
    {
        // Crear un objeto ficticio de LengthAwarePaginator
        $paginator = $this->createMock(\Illuminate\Pagination\LengthAwarePaginator::class);

        // Crear un objeto ficticio de Builder
        $query = $this->createMock(\Illuminate\Database\Query\Builder::class);

        $query->method('paginate')->willReturn($paginator);


        // Configurar los métodos ficticios para devolver valores específicos
        $paginator->method('total')->willReturn(0);
        $paginator->method('items')->willReturn([]);

        // Configurar programRepository para devolver el objeto de consulta ficticio
        $this->programRepository->expects($this->once())
            ->method('index')
            ->willReturn($query);

        $controller = new ProgramController($this->programRepository);
        $response = $controller->index();

        $this->assertEquals([
            'total' => 0,
            'data' => []
        ], $response);
    }

    public function testStore()
    {
        $this->programRepository->expects($this->once())
            ->method('store')
            ->willReturn(true);

        // Crear un objeto ficticio de StoreProgramRequest
        $request = $this->createMock(StoreProgramRequest::class);

        $request->expects($this->any())
            ->method('validated')->willReturn([
                'title' => 'Test Program',
                'description' => 'Test Description',
                'start_date' => '2024-01-01',
                'end_date' => '2024-05-31',
            ]);

        $controller = new ProgramController($this->programRepository);
        $response = $controller->store($request);

        $this->assertEquals(201, $response->getStatusCode());
    }

    public function testShow()
    {
        $this->programRepository->expects($this->once())
            ->method('getById')
            ->willReturn(true);

        $controller = new ProgramController($this->programRepository);
        $response = $controller->show(1);

        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testUpdate()
    {
        $this->programRepository->expects($this->once())
            ->method('update')
            ->willReturn(true);

        // Crear un objeto ficticio de UpdateProgramRequest
        $request = $this->createMock(UpdateProgramRequest::class);

        $request->expects($this->any())
            ->method('validated')->willReturn([
               'title' => 'Test Program',
                'description' => 'Test Description',
                'start_date' => '2024-01-01',
                'end_date' => '2024-05-31',
            ]);

        $controller = new ProgramController($this->programRepository);
        $response = $controller->update(1, $request);

        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testDestroy()
    {
        $this->programRepository->expects($this->once())
            ->method('delete')
            ->willReturn(true);

        $controller = new ProgramController($this->programRepository);
        $response = $controller->destroy(1);

        $this->assertEquals(200, $response->getStatusCode());
    }
}
