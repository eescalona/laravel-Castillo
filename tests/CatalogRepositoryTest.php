<?php

use App\Models\Catalog;
use App\Repositories\CatalogRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CatalogRepositoryTest extends TestCase
{
    use MakeCatalogTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var CatalogRepository
     */
    protected $catalogRepo;

    public function setUp()
    {
        parent::setUp();
        $this->catalogRepo = App::make(CatalogRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateCatalog()
    {
        $catalog = $this->fakeCatalogData();
        $createdCatalog = $this->catalogRepo->create($catalog);
        $createdCatalog = $createdCatalog->toArray();
        $this->assertArrayHasKey('id', $createdCatalog);
        $this->assertNotNull($createdCatalog['id'], 'Created Catalog must have id specified');
        $this->assertNotNull(Catalog::find($createdCatalog['id']), 'Catalog with given id must be in DB');
        $this->assertModelData($catalog, $createdCatalog);
    }

    /**
     * @test read
     */
    public function testReadCatalog()
    {
        $catalog = $this->makeCatalog();
        $dbCatalog = $this->catalogRepo->find($catalog->id);
        $dbCatalog = $dbCatalog->toArray();
        $this->assertModelData($catalog->toArray(), $dbCatalog);
    }

    /**
     * @test update
     */
    public function testUpdateCatalog()
    {
        $catalog = $this->makeCatalog();
        $fakeCatalog = $this->fakeCatalogData();
        $updatedCatalog = $this->catalogRepo->update($fakeCatalog, $catalog->id);
        $this->assertModelData($fakeCatalog, $updatedCatalog->toArray());
        $dbCatalog = $this->catalogRepo->find($catalog->id);
        $this->assertModelData($fakeCatalog, $dbCatalog->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteCatalog()
    {
        $catalog = $this->makeCatalog();
        $resp = $this->catalogRepo->delete($catalog->id);
        $this->assertTrue($resp);
        $this->assertNull(Catalog::find($catalog->id), 'Catalog should not exist in DB');
    }
}
