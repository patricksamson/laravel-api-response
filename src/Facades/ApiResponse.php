<?php
namespace Lykegenes\ApiResponse\Facades;

use Illuminate\Support\Facades\Facade;

class ApiResponse extends Facade
{
    public static function getFacadeAccessor()
    {
        return \Lykegenes\ApiResponse\ApiResponse::class;
    }
}
