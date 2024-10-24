<?php

namespace Tests;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\RefreshDatabase;

abstract class EntityTestCase extends TestCase
{
    use CreatesApplication;
    use RefreshDatabase;

    /**
     * @test
     */
    public function if_any_missing_property_not_tested_or_added_to_factory(): void
    {
        $this->assertModelFactoryDefined($this->model());
    }

    protected function assertModelFactoryDefined(string $modelClass, array $virtualPropertyNames = []): void
    {
        // Since virtual properties can not be defined in factory, we need to pass it in.
        $factory = $modelClass::factory();
        $model = $factory->create();
        $model->refresh();

        $factoryKeys = array_keys($factory->definition());
        $allKeys = [
            'id',
            'created_at',
            'updated_at',
            ...$factoryKeys,
            ...$virtualPropertyNames,
        ];

        $modelCurrentKeys = array_keys($model->toArray());

        foreach ($modelCurrentKeys as $key) {
            $this->assertContains($key, $allKeys);
        }
    }

    /**
     * @return class-string<Model>
     */
    abstract protected function model(): string;
}
