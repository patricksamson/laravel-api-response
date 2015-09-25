<?php
namespace Lykegenes\ApiResponse\Strategies;

use Illuminate\Database\Eloquent\Model;
use League\Fractal\Manager;
use League\Fractal\TransformerAbstract;

/**
 *
 */
class ModelClassStrategy extends EloquentQueryStrategy
{

    public function __construct(Manager $fractal, TransformerAbstract $transformer, $model)
    {
        if (is_subclass_of($model, Model::class)) {
            parent::__construct($fractal, $transformer, $model::query());
        }
    }

}
