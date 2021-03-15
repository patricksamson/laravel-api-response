<?php

use Lykegenes\ApiResponse\Strategies\ItemStrategy;

/**
 *
 */
class ItemStrategyTest extends ApiResponseTestCase
{

    /**
     * @var \Lykegenes\ApiResponse\Strategies\ItemStrategy
     */
    protected $itemStrategy;

    /**
     * @var \Illuminate\Database\Eloquent\Model
     */
    protected $model;

    public function setUp() : void
    {
        parent::setUp();

        $this->model = Mockery::mock(Illuminate\Database\Eloquent\Model::class);

        $this->itemStrategy = new ItemStrategy($this->fractal, $this->transformer, $this->model);
    }

    /** @test */
    public function it_includes_related()
    {
        $this->fractal->shouldReceive('parseIncludes')->once();

        $this->itemStrategy->includeRelated('posts');
    }

}
