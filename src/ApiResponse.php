<?php
namespace Lykegenes\ApiResponse;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection as EloquentCollection;
use League\Fractal\Manager;
use League\Fractal\TransformerAbstract;
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
     * @return array              The generated Api Response as an array
     */
    public function makeFractalArray($stuff, $transformer)
    {
        // Make sure we have a Transformer instance
        if (!$transformer instanceof TransformerAbstract && is_subclass_of($transformer, TransformerAbstract::class)) {
            $transformer = new $transformer;
        }

        // Let's see which Strategy we're going to use depending on the input type
        if ($stuff instanceof Model) {
            // This is a single Model instance
            $handler = new ItemStrategy($this->fractal, $transformer, $stuff);
        } elseif (is_subclass_of($stuff, Model::class)) {
            // This is a Eloquent Model class. Query the database for it's items
            $handler = new ModelClassStrategy($this->fractal, $transformer, $stuff);
        } elseif ($stuff instanceof Builder) {
            // This is a Query Builder instance. Let's add our conditions on top of it
            $handler = new EloquentQueryStrategy($this->fractal, $transformer, $stuff);
        } elseif ($stuff instanceof EloquentCollection || is_subclass_of($stuff, EloquentCollection::class)) {
            // This is a already loaded Collection. We can still filter it
            $handler = new EloquentCollectionStrategy($this->fractal, $transformer, $stuff);
        }

        // Now, let's execute our strategy, see their respective implementation
        if ($handler instanceof FractalManagerContract) {
            return $handler->execute($this->paramsBag);
        }

        // Why don't you give me something to work with?
        return null;
    }

}
