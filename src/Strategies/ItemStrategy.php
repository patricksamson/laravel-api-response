<?php
namespace Lykegenes\ApiResponse\Strategies;

use Illuminate\Database\Eloquent\Model;
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

    /**
     * The Eloquent Model instance
     *
     * @var \Illuminate\Database\Eloquent\Model
     */
    protected $model;

    public function __construct(Manager $fractal, TransformerAbstract $transformer, Model $model)
    {
        $this->fractal     = $fractal;
        $this->transformer = $transformer;
        $this->model       = $model;
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
     * Make a Fractal Item from this model instance
     *
     * @return \League\Fractal\Resource\Item
     */
    public function getFractalItem()
    {
        return new Item($this->model, new $this->transformer);
    }

    /**
     * Compile this item into an Array using Fractal's Transformers
     *
     * @return array
     */
    public function compileFractalData()
    {
        $resource = $this->getFractalItem();
        return $this->fractal->createData($resource)->toArray();
    }

    /**
     * Compile this item into an Array using Fractal's Transformers
     *
     * @param ParamBag $params
     * @return array
     */
    public function execute(ParamsBag $params)
    {
        return $this->includeRelated($params->getIncludes())
                    ->compileFractalData();
    }

}
