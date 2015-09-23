<?php
namespace Lykegenes\ApiResponse\Strategies;

use Illuminate\Database\Eloquent\Builder;
use League\Fractal\Manager;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use League\Fractal\Resource\Collection;

/**
 *
 */
class EloquentQueryStrategy extends AbstractCollectionStrategy
{
    protected $query;

    protected $paginator;

    public function __construct(Manager $fractal, $transformer, Builder $query)
    {
        parent::__construct($fractal, $transformer);

        $this->query = $query;
    }

    public function search($search)
    {
        if ($search != null && method_exists($this->query, 'search')) {
            $this->query->search($search);
        }

        return $this;
    }

    public function orderBy($column, $order = 'asc')
    {
        if ($column != null) {
            $this->query->orderBy($column, $order);
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
            $this->paginator = $this->query->paginate($perPage);
        }

        return $this;
    }

    public function getFractalCollection()
    {
        return new Collection($this->paginator->getCollection(), new $this->transformer);
    }

    public function compileFractalData()
    {
        $resource = $this->getFractalCollection();
        $resource->setPaginator(new IlluminatePaginatorAdapter($this->paginator));

        return $this->fractal->createData($resource)->toArray();
    }

}
