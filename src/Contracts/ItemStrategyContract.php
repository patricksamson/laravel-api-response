<?php
namespace Lykegenes\ApiResponse\Contracts;

use Lykegenes\ApiResponse\ParamsBag;

interface ItemStrategyContract extends FractalManagerContract
{

    /**
     * Include the selected relationships in the Fractal Transformer
     *
     * @param  string
     * @return $this
     */
    public function includeRelated($include);

    /**
     * Make a Fractal Item from this model instance
     *
     * @return \League\Fractal\Resource\Item
     */
    public function getFractalItem();

    /**
     * Compile this query into an Array using Fractal's Transformers
     *
     * @return array
     */
    public function compileFractalData();

    /**
     * Compile this query into an Array using Fractal's Transformers
     *
     * @param ParamBag $params
     * @return array
     */
    public function execute(ParamsBag $params);

}
