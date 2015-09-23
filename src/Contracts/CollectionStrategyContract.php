<?php
namespace Lykegenes\ApiResponse\Contracts;

use Lykegenes\ApiResponse\ParamsBag;

interface CollectionStrategyContract extends FractalManagerContract
{

    public function search($query);

    public function orderBy($column, $order);

    public function includeRelated($include);

    public function paginate($per_page, $page);

    public function getFractalCollection();

    public function compileFractalData();

    public function execute(ParamsBag $params);
}
