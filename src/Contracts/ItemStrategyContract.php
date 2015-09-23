<?php
namespace Lykegenes\ApiResponse\Contracts;

use Lykegenes\ApiResponse\ParamsBag;

interface ItemStrategyContract extends FractalManagerContract
{

    public function includeRelated($include);

    public function getFractalItem();

    public function compileFractalData();

    public function execute(ParamsBag $params);

}
