<?php
namespace Lykegenes\ApiResponse\Strategies;

use Illuminate\Support\Collection as EloquentCollection;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection as FractalCollection;

/**
 *
 */
class EloquentCollectionStrategy extends AbstractCollectionStrategy
{
    protected $collection;

    public function __construct(Manager $fractal, $transformer, EloquentCollection $collection)
    {
        parent::__construct($fractal, $transformer);

        $this->collection = $collection;
    }

    public function search($query)
    {
        // not implemented

        return $this;
    }

    public function orderBy($column, $direction = 'asc')
    {
        if ($column != null) {
            if ($direction === 'asc') {
                $this->collection = $this->collection->sortBy($column);
            } elseif ($direction === 'desc') {
                $this->collection = $this->collection->sortByDesc($column);
            }
        }

        return $this;
    }

    public function includeRelated($includes)
    {
        if ($includes != null) {
            $this->fractal->parseIncludes($includes);
        }

        return $this;
    }

    public function paginate($perPage, $page)
    {
        if ($perPage > 0) {
            $this->collection = $this->collection->forPage($page, $perPage);
        }

        return $this;
    }

    public function getFractalCollection()
    {
        return new FractalCollection($this->collection, new $this->transformer);
    }

    public function compileFractalData()
    {
        $resource = $this->getFractalCollection();
        //$resource->setPaginator(new IlluminatePaginatorAdapter($paginator));

        return $this->fractal->createData($resource)->toArray();
    }
}
