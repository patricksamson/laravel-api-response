<?php

use Lykegenes\ApiResponse\Strategies\EloquentQueryStrategy;

/**
 *
 */
class EloquentQueryStrategyTest extends ApiResponseTestCase
{

    /**
     * @var \Lykegenes\ApiResponse\Strategies\EloquentCollectionStrategy
     */
    protected $strategy;

    /**
     * @var \Illuminate\Database\Eloquent\Builder
     */
    protected $query;

    public function setUp()
    {
        parent::setUp();

        $this->query = Mockery::mock(Illuminate\Database\Eloquent\Builder::class);

        $this->strategy = new EloquentQueryStrategy($this->fractal, $this->transformer, $this->query);
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
        $this->query->shouldReceive('orderBy')->twice()->andReturn($this->query);

        $this->strategy->orderBy('some-column');
        $this->strategy->orderBy('some-column', 'asc');
    }

    /** @test */
    public function it_can_be_ordered_by_desc()
    {
        $this->query->shouldReceive('orderBy')->once();

        $this->strategy->orderBy('some-column', 'desc');
    }

    /** @test */
    public function it_can_be_paginated()
    {
        $this->query->shouldReceive('paginate')->once();

        $this->strategy->paginate(50, 2);
    }

}
