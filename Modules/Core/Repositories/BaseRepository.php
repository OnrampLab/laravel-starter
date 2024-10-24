<?php

namespace Modules\Core\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Illuminate\Support\LazyCollection;
use Modules\Core\Contracts\Repository;
use Modules\Core\Contracts\Sort;
use Modules\Core\Contracts\SortDirection;

/**
 * @template M of Model
 * @implements Repository<M>
 */
abstract class BaseRepository implements Repository
{
    /**
     * @return LazyCollection<int, M>
     */
    public function all(): LazyCollection
    {
        return $this->model()::lazy();
    }

    /**
     * @return M
     */
    public function find(string|int $id)
    {
        return $this->model()->findOrFail($id);
    }

    /**
     * @param array<string, mixed> $attributes
     * @return M
     */
    public function create(array $attributes)
    {
        /**
         * @var M $entity
         */
        $entity = App::make($this->model()::class);
        $entity->fill($attributes);

        return $this->save($entity);
    }

    /**
     * @return M
     */
    public function update(array $attributes, int|string $id)
    {
        $entity = $this->find($id);
        $entity->fill($attributes);

        return $this->save($entity);
    }

    /**
     * @param M|int|string $entityOrEntityId
     */
    public function delete($entityOrEntityId): int
    {
        if (is_int($entityOrEntityId) || is_string($entityOrEntityId)) {
            return (int) $this->model()->whereIn('id', [$entityOrEntityId])->delete();
        }

        return (int) $entityOrEntityId->delete();
    }

    /**
     * @param M $entity
     * @return M
     */
    public function save($entity)
    {
        $entity->save();

        return $entity;
    }

    /**
     * @param array<string, mixed> $conditions
     * @param Collection<int, Sort>|null $sorts
     * @return LazyCollection<int, M>
     */
    public function search(array $conditions, null|Collection $sorts = null): LazyCollection
    {
        $query = $this->model()->where($conditions);

        if ($sorts) {
            $sorts->each(function ($sort) use ($query) {
                $direction = $sort->getDirection();
                $order = $direction === SortDirection::ASC
                    ? 'asc'
                    : 'desc';
                $query = $query->orderBy($sort->getField(), $order);
            });
        }

        return $query->lazy();
    }

    /**
     * @return M
     */
    abstract protected function model();
}
