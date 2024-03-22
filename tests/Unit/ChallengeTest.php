<?php

namespace Tests\Unit;

use App\Http\Controllers\ChallengeController;
use App\Http\Requests\StoreChallengeRequest;
use App\Http\Requests\UpdateChallengeRequest;
use App\Repositories\ChallengeRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ChallengeTest extends TestCase
{
    use RefreshDatabase;

    private $challengeRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->challengeRepository = $this->createMock(ChallengeRepository::class);
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

        // Configurar challengeRepository para devolver el objeto de consulta ficticio
        $this->challengeRepository->expects($this->once())
            ->method('index')
            ->willReturn($query);

        $controller = new ChallengeController($this->challengeRepository);
        $response = $controller->index();

        $this->assertEquals([
            'total' => 0,
            'data' => []
        ], $response);
    }

    public function testStore()
    {
        $this->challengeRepository->expects($this->once())
            ->method('store')
            ->willReturn(true);

        // Crear un objeto ficticio de StoreChallengeRequest
        $request = $this->createMock(StoreChallengeRequest::class);

        $request->expects($this->any())
            ->method('validated')->willReturn([
                'title' => 'Test Challenge',
                'description' => 'Test Description',
                'difficulty' => 5,
                'user_id' => 1
            ]);

        $controller = new ChallengeController($this->challengeRepository);
        $response = $controller->store($request);

        $this->assertEquals(201, $response->getStatusCode());
    }

    public function testShow()
    {
        $this->challengeRepository->expects($this->once())
            ->method('getById')
            ->willReturn(true);

        $controller = new ChallengeController($this->challengeRepository);
        $response = $controller->show(1);

        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testUpdate()
    {
        $this->challengeRepository->expects($this->once())
            ->method('update')
            ->willReturn(true);

        // Crear un objeto ficticio de UpdateChallengeRequest
        $request = $this->createMock(UpdateChallengeRequest::class);

        $request->expects($this->any())
            ->method('validated')->willReturn([
                'title' => 'Test Challenge',
                'description' => 'Test Description',
                'difficulty' => 5,
            ]);

        $controller = new ChallengeController($this->challengeRepository);
        $response = $controller->update(1, $request);

        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testDestroy()
    {
        $this->challengeRepository->expects($this->once())
            ->method('delete')
            ->willReturn(true);

        $controller = new ChallengeController($this->challengeRepository);
        $response = $controller->destroy(1);

        $this->assertEquals(200, $response->getStatusCode());
    }
}
