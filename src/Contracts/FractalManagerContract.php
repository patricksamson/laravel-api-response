<?php
namespace Lykegenes\ApiResponse\Contracts;

use Lykegenes\ApiResponse\ParamsBag;

interface FractalManagerContract
{

    public function includeRelated($include);

    public function compileFractalData();

    public function execute(ParamsBag $params);

}
