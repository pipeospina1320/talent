<?php

namespace Tests\Unit;

use App\Http\Controllers\UserController;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Repositories\UserRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    private $userRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->userRepository = $this->createMock(UserRepository::class);
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

        // Configurar UserRepository para devolver el objeto de consulta ficticio
        $this->userRepository->expects($this->once())
            ->method('index')
            ->willReturn($query);

        $controller = new UserController($this->userRepository);
        $response = $controller->index();

        $this->assertEquals([
            'total' => 0,
            'data' => []
        ], $response);
    }

    public function testStore()
    {
        $this->userRepository->expects($this->once())
            ->method('store')
            ->willReturn(true);

        // Crear un objeto ficticio de StoreUserRequest
        $request = $this->createMock(StoreUserRequest::class);

        $request->expects($this->any())
            ->method('validated')->willReturn([
                'name' => 'Test User',
                'email' => 'test@example.com',
                'password' => 'password',
                'password_confirmation' => 'password',
            ]);

        $controller = new UserController($this->userRepository);
        $response = $controller->store($request);

        $this->assertEquals(201, $response->getStatusCode());
    }

    public function testShow()
    {
        $this->userRepository->expects($this->once())
            ->method('getById')
            ->willReturn(true);

        $controller = new UserController($this->userRepository);
        $response = $controller->show(1);

        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testUpdate()
    {
        $this->userRepository->expects($this->once())
            ->method('update')
            ->willReturn(true);

        $request = $this->createMock(UpdateUserRequest::class);

        $request->expects($this->any())
            ->method('validated')->willReturn([
                'name' => 'Test User',
            ]);

        $controller = new UserController($this->userRepository);
        $response = $controller->update(1, $request);

        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testDestroy()
    {
        $this->userRepository->expects($this->once())
            ->method('delete')
            ->willReturn(true);

        $controller = new UserController($this->userRepository);
        $response = $controller->destroy(1);

        $this->assertEquals(200, $response->getStatusCode());
    }
}
