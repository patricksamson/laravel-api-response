<?php
namespace Lykegenes\ApiResponse;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection as EloquentCollection;
use League\Fractal\Manager;
use Lykegenes\ApiResponse\Contracts\FractalManagerContract;
use Lykegenes\ApiResponse\Strategies\EloquentCollectionStrategy;
use Lykegenes\ApiResponse\Strategies\EloquentQueryStrategy;
use Lykegenes\ApiResponse\Strategies\ItemStrategy;
use Lykegenes\ApiResponse\Strategies\ModelClassStrategy;

class ApiResponse
{

    /**
     * The Fractal Manager instance
     * @var \League\Fractal\Manager
     */
    protected $fractal;

    /**
     * The current request parameters
     * @var ParamsBag
     */
    protected $paramsBag;

    /**
     * Construct a new ApiResponse instance
     * @param \Illuminate\Http\Request $request The current request instance
     * @param \League\Fractal\Manager $fractal A Fractal manager instance
     */
    public function __construct(Manager $fractal, ParamsBag $paramsBag)
    {
        $this->fractal   = $fractal;
        $this->paramsBag = $paramsBag;
    }

    public function make($stuff, $transformer)
    {
        return JsonResponse::create($this->makeFractalArray($stuff, $transformer));
    }

    /**
     * Try to guess what to do with this stuff
     * @param  mixed $stuff       A Class, a Model instance or a Query Builder instance
     * @param  mixed $transformer The Fractal transformer to use
     * @return array              The genrated Api Response as an array
     */
    public function makeFractalArray($stuff, $transformer)
    {
        if ($stuff instanceof Model) {
            $handler = new ItemStrategy($this->fractal, $transformer, $stuff);
        } elseif (is_subclass_of($stuff, Model::class)) {
            $handler = new ModelClassStrategy($this->fractal, $transformer, $stuff);
        } elseif ($stuff instanceof Builder) {
            $handler = new EloquentQueryStrategy($this->fractal, $transformer, $stuff);
        } elseif (is_subclass_of($stuff, EloquentCollection::class)) {
            $handler = new EloquentCollectionStrategy($this->fractal, $transformer, $stuff);
        }

        if ($handler instanceof FractalManagerContract) {
            return $handler->execute($this->paramsBag);
        }

        return null;
    }

}
