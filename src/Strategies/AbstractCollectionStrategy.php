<?php
namespace Lykegenes\ApiResponse\Strategies;

use League\Fractal\Manager;
use Lykegenes\ApiResponse\Contracts\CollectionStrategyContract;
use Lykegenes\ApiResponse\ParamsBag;

/**
 *
 */
abstract class AbstractCollectionStrategy implements CollectionStrategyContract
{

    protected $fractal;

    protected $transformer;

    public function __construct(Manager $fractal, $transformer)
    {
        $this->fractal     = $fractal;
        $this->transformer = $transformer;
    }

    public function search($query)
    {}

    public function orderBy($column, $order)
    {}

    public function includeRelated($includes)
    {}

    public function paginate($perPage, $page)
    {}

    public function getFractalCollection()
    {}

    public function compileFractalData()
    {}

    public function execute(ParamsBag $params)
    {
        return $this->search($params->getSearchQuery())
                    ->orderBy($params->getSortColumn(), $params->getSortDirection())
                    ->paginate($params->getPerPage(), $params->getPage())
                    ->includeRelated($params->getIncludes())
                    ->compileFractalData();
    }

}
