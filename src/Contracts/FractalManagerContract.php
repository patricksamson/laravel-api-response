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
     * Compile Fractal data to an Array
     * 
     * @return $this
     */
    public function compileFractalData();

	/**
	 * @param  ParamsBag
	 * @return [type]
	 */
    public function execute(ParamsBag $params);

}
