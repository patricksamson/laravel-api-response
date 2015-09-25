<?php
namespace Lykegenes\ApiResponse\Contracts;

use Lykegenes\ApiResponse\ParamsBag;

interface CollectionStrategyContract extends FractalManagerContract
{

    /**
     * Adds a search condition to this Eloquent Query
     *
     * @param  string The search query
     * @return $this
     */
    public function search($query);

    /**
     * Adds a OrderBy to the query
     *
     * @param  string
     * @param  string
     * @return $this
     */
    public function orderBy($column, $order);

    /**
     * Include the selected relationships in the Fractal Transformer
     *
     * @param  string
     * @return $this
     */
    public function includeRelated($include);

    /**
     * Paginate the results of this query
     *
     * @param  int
     * @param  int
     * @return $this
     */
    public function paginate($per_page, $page);

    /**
     * Make a Fractal Collection from this query
     *
     * @return \League\Fractal\Resource\Collection
     */
    public function getFractalCollection();

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
