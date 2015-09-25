<?php

use Lykegenes\ApiResponse\Strategies\ItemStrategy;

/**
 *
 */
class ItemStrategyTest extends ApiResponseTestCase
{

    protected $itemStrategy;

    public function setUp()
    {
        parent::setUp();

        $this->itemStrategy = new ItemStrategy($this->fractal, null, null);
    }

    /** @test */
    public function it_includes_related()
    {
        $this->fractal->shouldReceive('parseIncludes')->once();

        $this->itemStrategy->includeRelated('posts');
    }

}
