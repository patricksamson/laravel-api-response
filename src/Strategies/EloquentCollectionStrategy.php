<?php
namespace Lykegenes\ApiResponse\Strategies;

use Illuminate\Support\Collection as EloquentCollection;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection as FractalCollection;
use League\Fractal\TransformerAbstract;

/**
 *
 */
class EloquentCollectionStrategy extends AbstractCollectionStrategy
{

    /**
     * The Eloquent Collection instance
     *
     * @var \Illuminate\Support\Collection
     */
    protected $collection;

    public function __construct(Manager $fractal, TransformerAbstract $transformer, EloquentCollection $collection)
    {
        parent::__construct($fractal, $transformer);

        $this->collection = $collection;
    }

    /**
     * Adds a search condition to this Eloquent Query
     *
     * @param  string The search query
     * @return $this
     */
    public function search($query)
    {
        // not implemented

        return $this;
    }

    /**
     * Adds a OrderBy to the query
     *
     * @param  string
     * @param  string
     * @return $this
     */
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

    /**
     * Include the selected relationships in the Fractal Transformer
     *
     * @param  string
     * @return $this
     */
    public function includeRelated($includes)
    {
        if ($includes != null) {
            $this->fractal->parseIncludes($includes);
        }

        return $this;
    }

    /**
     * Paginate the results of this query
     *
     * @param  int
     * @param  int
     * @return $this
     */
    public function paginate($perPage, $page)
    {
        if ($perPage > 0) {
            $this->collection = $this->collection->forPage($page, $perPage);
        }

        return $this;
    }

    /**
     * Make a Fractal Collection from this query
     *
     * @return \League\Fractal\Resource\Collection
     */
    public function getFractalCollection()
    {
        return new FractalCollection($this->collection, new $this->transformer);
    }

    /**
     * Compile this query into an Array using Fractal's Transformers
     *
     * @return array
     */
    public function compileFractalData()
    {
        $resource = $this->getFractalCollection();
        //$resource->setPaginator(new IlluminatePaginatorAdapter($paginator));

        return $this->fractal->createData($resource)->toArray();
    }
}
