<?php

use Lykegenes\ApiResponse\Strategies\EloquentCollectionStrategy;

/**
 *
 */
class EloquentCollectionStrategyTest extends ApiResponseTestCase
{

    /**
     * @var \Lykegenes\ApiResponse\Strategies\EloquentCollectionStrategy
     */
    protected $strategy;

    /**
     * @var \Illuminate\Support\Collection
     */
    protected $collection;

    public function setUp()
    {
        parent::setUp();

        $this->collection = Mockery::mock(Illuminate\Support\Collection::class);

        $this->strategy = new EloquentCollectionStrategy($this->fractal, $this->transformer, $this->collection);
    }

    /** @test */
    public function it_includes_related()
    {
        $this->fractal->shouldReceive('parseIncludes')->once();

        $this->strategy->includeRelated('posts');
    }

    /** @test */
    public function it_can_be_ordered_by_asc()
    {
        $this->collection->shouldReceive('sortBy')->twice()->andReturn($this->collection);

        $this->strategy->orderBy('some-column');
        $this->strategy->orderBy('some-column', 'asc');
    }

    /** @test */
    public function it_can_be_ordered_by_desc()
    {
        $this->collection->shouldReceive('sortByDesc')->once();

        $this->strategy->orderBy('some-column', 'desc');
    }

    /** @test */
    public function it_can_be_paginated()
    {
        $this->collection->shouldReceive('forPage')->once();

        $this->strategy->paginate(50, 2);
    }

}
