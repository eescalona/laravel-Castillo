<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CatalogApiTest extends TestCase
{
    use MakeCatalogTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateCatalog()
    {
        $catalog = $this->fakeCatalogData();
        $this->json('POST', '/api/v1/catalogs', $catalog);

        $this->assertApiResponse($catalog);
    }

    /**
     * @test
     */
    public function testReadCatalog()
    {
        $catalog = $this->makeCatalog();
        $this->json('GET', '/api/v1/catalogs/'.$catalog->id);

        $this->assertApiResponse($catalog->toArray());
    }

    /**
     * @test
     */
    public function testUpdateCatalog()
    {
        $catalog = $this->makeCatalog();
        $editedCatalog = $this->fakeCatalogData();

        $this->json('PUT', '/api/v1/catalogs/'.$catalog->id, $editedCatalog);

        $this->assertApiResponse($editedCatalog);
    }

    /**
     * @test
     */
    public function testDeleteCatalog()
    {
        $catalog = $this->makeCatalog();
        $this->json('DELETE', '/api/v1/catalogs/'.$catalog->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/catalogs/'.$catalog->id);

        $this->assertResponseStatus(404);
    }
}
