<?php

namespace Tests\Unit;

use App\Http\Controllers\CompanyController;
use App\Http\Requests\StoreCompanyRequest;
use App\Http\Requests\UpdateCompanyRequest;
use App\Repositories\CompanyRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CompanyTest extends TestCase
{
    use RefreshDatabase;

    private $companyRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->companyRepository = $this->createMock(CompanyRepository::class);
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

        // Configurar companyRepository para devolver el objeto de consulta ficticio
        $this->companyRepository->expects($this->once())
            ->method('index')
            ->willReturn($query);

        $controller = new CompanyController($this->companyRepository);
        $response = $controller->index();

        $this->assertEquals([
            'total' => 0,
            'data' => []
        ], $response);
    }

    public function testStore()
    {
        $this->companyRepository->expects($this->once())
            ->method('store')
            ->willReturn(true);

        // Crear un objeto ficticio de StoreCompanyRequest
        $request = $this->createMock(StoreCompanyRequest::class);

        $request->expects($this->any())
            ->method('validated')->willReturn([
                'name' => 'Test User',
                'image_path' => 'test.jpg',
                'location' => 'Test Location',
                'industry' => 'Test Industry',
                'user_id' => 1,
            ]);

        $controller = new CompanyController($this->companyRepository);
        $response = $controller->store($request);

        $this->assertEquals(201, $response->getStatusCode());
    }

    public function testShow()
    {
        $this->companyRepository->expects($this->once())
            ->method('getById')
            ->willReturn(true);

        $controller = new CompanyController($this->companyRepository);
        $response = $controller->show(1);

        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testUpdate()
    {
        $this->companyRepository->expects($this->once())
            ->method('update')
            ->willReturn(true);

        // Crear un objeto ficticio de StoreCompanyRequest
        $request = $this->createMock(UpdateCompanyRequest::class);

        $request->expects($this->any())
            ->method('validated')->willReturn([
                'name' => 'Test User',
                'image_path' => 'test.jpg',
                'location' => 'Test Location',
                'industry' => 'Test Industry',
            ]);

        $controller = new CompanyController($this->companyRepository);
        $response = $controller->update(1, $request);

        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testDestroy()
    {
        $this->companyRepository->expects($this->once())
            ->method('delete')
            ->willReturn(true);

        $controller = new CompanyController($this->companyRepository);
        $response = $controller->destroy(1);

        $this->assertEquals(200, $response->getStatusCode());
    }
}
