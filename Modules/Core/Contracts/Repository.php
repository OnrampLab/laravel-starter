<?php

namespace Modules\Core\Contracts;

use Illuminate\Support\Collection;
use Illuminate\Support\LazyCollection;

/**
 * @template T
 */
interface Repository
{
    /**
     * @return LazyCollection<int, T>
     */
    public function all(): LazyCollection;

    /**
     * @return T
     */
    public function find(string|int $id);

    /**
     * @param array<string, mixed> $attributes
     * @return T
     */
    public function create(array $attributes);

    /**
     * @param array<string, mixed> $attributes
     * @return T
     */
    public function update(array $attributes, int|string $id);

    /**
     * @param T|int|string $entityOrEntityId
     */
    public function delete($entityOrEntityId): int;

    /**
     * @param T $entity
     * @return T
     */
    public function save($entity);

    /**
     * @param array<string, mixed> $conditions
     * @param Collection<int, Sort>|null $sorts
     * @return LazyCollection<int, T>
     */
    public function search(array $conditions, ?Collection $sorts = null): LazyCollection;
}
