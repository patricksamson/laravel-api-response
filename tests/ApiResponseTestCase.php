<?php

use Illuminate\Contracts\Container\Container;
use League\Fractal\Manager;
use Lykegenes\ApiResponse\ApiResponse;
use Lykegenes\ApiResponse\ParamsBag;
use Orchestra\Testbench\TestCase;

abstract class ApiResponseTestCase extends TestCase
{

    /**
     * @var \Illuminate\Http\Request
     */
    protected $request;

    /**
     * @var array
     */
    protected $config;

    /**
     * @var \Illuminate\Contracts\Container\Container
     */
    protected $container;

    /**
     * A Fractal Manager instance
     * @var \League\Fractal\Manager
     */
    protected $fractal;

    /**
     * @var \Lykegenes\ApiResponse\ParamsBag
     */
    protected $paramsBag;

    /**
     * @var \Lykegenes\ApiResponse\ApiResponse
     */
    protected $apiResponse;

    /**
     * @var \League\Fractal\TransformerAbstract
     */
    protected $transformer;

    public function setUp() : void
    {
        parent::setUp();

        $this->request = $this->app['request'];
        $this->config = include __DIR__ . '/../config/config.php';

        $this->fractal     = Mockery::mock(League\Fractal\Manager::class);
        $this->transformer = Mockery::mock(League\Fractal\TransformerAbstract::class);

        $this->paramsBag   = new ParamsBag($this->request);
        $this->apiResponse = new ApiResponse($this->fractal, $this->paramsBag);
    }

    public function tearDown() : void
    {
        Mockery::close();
        $this->request     = null;
        $this->container   = null;
        $this->config      = null;
        $this->fractal     = null;
        $this->paramsBag   = null;
        $this->apiResponse = null;
    }

    protected function getPackageProviders($app)
    {
        return ['Lykegenes\ApiResponse\ServiceProvider'];
    }

    protected function getPackageAliases($app)
    {
        return [
            'Acme' => 'Lykegenes\ApiResponse\Facades\ApiResponse',
        ];
    }

}

class People extends Illuminate\Database\Eloquent\Model
{
}
