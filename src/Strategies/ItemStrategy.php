<?php
namespace Lykegenes\ApiResponse\Strategies;

use League\Fractal\Manager;
use League\Fractal\Resource\Item;
use League\Fractal\TransformerAbstract;
use Lykegenes\ApiResponse\Contracts\ItemStrategyContract;
use Lykegenes\ApiResponse\ParamsBag;

/**
 *
 */
class ItemStrategy implements ItemStrategyContract
{

    protected $fractal;

    protected $transformer;

    protected $model;

    public function __construct(Manager $fractal, TransformerAbstract $transformer, $model)
    {
        $this->fractal     = $fractal;
        $this->transformer = $transformer;
        $this->model       = $model;
    }

    public function includeRelated($includes)
    {
        if ($includes != null) {
            $this->fractal->parseIncludes($includes);
        }

        return $this;
    }

    public function getFractalItem()
    {
        return new Item($this->model, new $this->transformer);
    }

    public function compileFractalData()
    {
        $resource = $this->getFractalItem();
        return $this->fractal->createData($resource)->toArray();
    }

    public function execute(ParamsBag $params)
    {
        return $this->includeRelated($params->getIncludes())
                    ->compileFractalData();
    }

}
