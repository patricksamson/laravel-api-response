<?php

/**
 *
 */
class ParamsBagTest extends ApiResponseTestCase
{

    public function setUp()
    {
        parent::setUp();

        $this->app['config']->set('api-response.parameters', [
            'page'     => 'page',
            'per_page' => 'per_page',
            'sort'     => 'sort',
            'order'    => 'order',
            'search'   => 'search',
            'include'  => 'include',
        ]);
    }

    /** @test */
    public function it_gets_default_parameters_names()
    {
        $this->assertEquals('page', $this->paramsBag->getParamName('page'));
        $this->assertEquals('per_page', $this->paramsBag->getParamName('per_page'));
        $this->assertEquals('sort', $this->paramsBag->getParamName('sort'));
        $this->assertEquals('order', $this->paramsBag->getParamName('order'));
        $this->assertEquals('search', $this->paramsBag->getParamName('search'));
        $this->assertEquals('include', $this->paramsBag->getParamName('include'));
    }

    /** @test */
    public function it_gets_custom_parameters_names()
    {
        $this->app['config']->set('api-response.parameters', [
            'custom-parameter' => 'and-its-name',
        ]);

        $this->assertEquals('and-its-name', $this->paramsBag->getParamName('custom-parameter'));
    }

    /** @test */
    public function it_returns_key_name_if_parameter_name_is_not_found()
    {
        $this->assertEquals('this-doesnt-exist', $this->paramsBag->getParamName('this-doesnt-exist'));
    }

    /** @test */
    public function it_gets_parameters_default_values()
    {
        $this->assertEquals(1, $this->paramsBag->getPage());
        $this->assertEquals(10, $this->paramsBag->getPerPage());
        $this->assertEquals(null, $this->paramsBag->getSortColumn());
        $this->assertEquals('asc', $this->paramsBag->getSortDirection());
        $this->assertEquals(null, $this->paramsBag->getSearchquery());
        $this->assertEquals(null, $this->paramsBag->getIncludes());
    }

    /** @test */
    public function it_gets_parameters_values_from_request()
    {
        $this->request->replace([
            'page'     => 3,
            'per_page' => 50,
            'sort'     => 'name',
            'order'    => 'desc',
            'search'   => 'John',
            'include'  => 'posts',
        ]);

        $this->assertEquals(3, $this->paramsBag->getParamValue('page'));
        $this->assertEquals(50, $this->paramsBag->getParamValue('per_page'));
        $this->assertEquals('name', $this->paramsBag->getParamValue('sort'));
        $this->assertEquals('desc', $this->paramsBag->getParamValue('order'));
        $this->assertEquals('John', $this->paramsBag->getParamValue('search'));
        $this->assertEquals('posts', $this->paramsBag->getParamValue('include'));
    }
}
