<?php
namespace Lykegenes\ApiResponse\Strategies;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\Paginator;
use League\Fractal\Manager;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use League\Fractal\Resource\Collection as FractalCollection;
use League\Fractal\TransformerAbstract;

/**
 *
 */
class EloquentQueryStrategy extends AbstractCollectionStrategy
{
    /**
     * The Eloquent Query Builder instance
     *
     * @var \Illuminate\Database\Eloquent\Builder
     */
    protected $query;

    /**
     * The paginator instance
     *
     * @var \League\Fractal\Pagination\IlluminatePaginatorAdapter
     */
    protected $paginator;

    /**
     * The Query results Collection
     *
     * @var \Illuminate\Support\Collection
     */
    protected $collection;

    public function __construct(Manager $fractal, TransformerAbstract $transformer, Builder $query)
    {
        parent::__construct($fractal, $transformer);

        $this->query = $query;
    }

    /**
     * Adds a search condition to this Eloquent Query
     *
     * @param  string The search query
     * @return $this
     */
    public function search($search)
    {
        if ($search != null) {
            // Will throw an error if the scope doesn't exist
            $this->query->search($search);
        }

        return $this;
    }

    /**
     * Adds a OrderBy to the query
     *
     * @param  string
     * @param  string
     * @return $this
     */
    public function orderBy($column, $order = 'asc')
    {
        if ($column != null) {
            $this->query->orderBy($column, $order);
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
            Paginator::currentPageResolver(function () use ($page) {
                return $page;
            });

            $this->paginator = $this->query->paginate($perPage);
        } else {
            $this->collection = $this->query->get();
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
        if ($this->paginator) {
            return new FractalCollection($this->paginator->getCollection(), $this->transformer);
        } elseif ($this->collection) {
            return new FractalCollection($this->collection, $this->transformer);
        }

    }

    /**
     * Compile this query into an Array using Fractal's Transformers
     *
     * @return array
     */
    public function compileFractalData()
    {
        $resource = $this->getFractalCollection();

        if ($this->paginator) {
            $resource->setPaginator(new IlluminatePaginatorAdapter($this->paginator));
        }

        return $this->fractal->createData($resource)->toArray();
    }

}
