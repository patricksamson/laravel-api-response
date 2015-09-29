<?php
namespace Lykegenes\ApiResponse\Contracts;

use Lykegenes\ApiResponse\ParamsBag;

interface FractalManagerContract
{

    /**
     * Use Fractal to parse the Included relationships
     *
     * @param  string $include
     * @return $this
     */
    public function includeRelated($include);

    /**
     * Compile this query into an Array using Fractal's Transformers
     *
     * @return $this
     */
    public function compileFractalData();

    /**
     * Compile this query into an Array using Fractal's Transformers
     *
     * @param  ParamsBag
     * @return [type]
     */
    public function execute(ParamsBag $params);

}
