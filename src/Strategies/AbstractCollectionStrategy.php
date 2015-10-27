<?php
namespace Lykegenes\ApiResponse\Strategies;

use League\Fractal\Manager;
use League\Fractal\TransformerAbstract;
use Lykegenes\ApiResponse\Contracts\CollectionStrategyContract;
use Lykegenes\ApiResponse\ParamsBag;

/**
 *
 */
abstract class AbstractCollectionStrategy implements CollectionStrategyContract
{

    /**
     * The Fractal Manager instance
     *
     * @var \League\Fractal\Manager
     */
    protected $fractal;

    /**
     * The Fractal Transformer instance
     *
     * @var \League\Fractal\TransformerAbstract
     */
    protected $transformer;

    public function __construct(Manager $fractal, TransformerAbstract $transformer)
    {
        $this->fractal = $fractal;
        $this->transformer = $transformer;
    }

    /**
     * Adds a search condition to this Eloquent Query
     *
     * @param  string The search query
     * @return $this
     */
    abstract public function search($query);

    /**
     * Adds a OrderBy to the query
     *
     * @param  string
     * @param  string
     * @return $this
     */
    abstract public function orderBy($column, $order);

    /**
     * Include the selected relationships in the Fractal Transformer
     *
     * @param  string
     * @return $this
     */
    abstract public function includeRelated($includes);

    /**
     * Paginate the results of this query
     *
     * @param  int
     * @param  int
     * @return $this
     */
    abstract public function paginate($perPage, $page);

    /**
     * Make a Fractal Collection from this query
     *
     * @return \League\Fractal\Resource\Collection
     */
    abstract public function getFractalCollection();

    /**
     * Compile this query into an Array using Fractal's Transformers
     *
     * @return array
     */
    abstract public function compileFractalData();

    /**
     * Compile this query into an Array using Fractal's Transformers
     *
     * @param ParamBag $params
     * @return array
     */
    public function execute(ParamsBag $params)
    {
        return $this->search($params->getSearchQuery())
            ->orderBy($params->getSortColumn(), $params->getSortDirection())
            ->paginate($params->getPerPage(), $params->getPage())
            ->includeRelated($params->getIncludes())
            ->compileFractalData();
    }

}
