<?php

use Faker\Factory as Faker;
use App\Models\Catalog;
use App\Repositories\CatalogRepository;

trait MakeCatalogTrait
{
    /**
     * Create fake instance of Catalog and save it in database
     *
     * @param array $catalogFields
     * @return Catalog
     */
    public function makeCatalog($catalogFields = [])
    {
        /** @var CatalogRepository $catalogRepo */
        $catalogRepo = App::make(CatalogRepository::class);
        $theme = $this->fakeCatalogData($catalogFields);
        return $catalogRepo->create($theme);
    }

    /**
     * Get fake instance of Catalog
     *
     * @param array $catalogFields
     * @return Catalog
     */
    public function fakeCatalog($catalogFields = [])
    {
        return new Catalog($this->fakeCatalogData($catalogFields));
    }

    /**
     * Get fake data of Catalog
     *
     * @param array $postFields
     * @return array
     */
    public function fakeCatalogData($catalogFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'title' => $fake->word,
            'image' => $fake->randomDigitNotNull,
            'url' => $fake->word,
            'created_at' => $fake->date('Y-m-d H:i:s'),
            'updated_at' => $fake->word,
            'deleted_at' => $fake->word
        ], $catalogFields);
    }
}
