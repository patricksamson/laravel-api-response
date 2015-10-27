<?php
namespace Lykegenes\ApiResponse;

use Illuminate\Http\Request;

class ParamsBag
{

    /**
     * Request parameters names
     */
    const PAGE = 'page';
    const PER_PAGE = 'per_page';
    const SORT = 'sort';
    const ORDER = 'order';
    const SEARCH = 'search';
    const FRACTAL_INCLUDE = 'include';

    /**
     * Request parameters default values
     */
    const PAGE_DEFAULT = 1;
    const PER_PAGE_DEFAULT = 10;
    const SORT_DEFAULT = null;
    const ORDER_DEFAULT = 'asc';
    const SEARCH_DEFAULT = null;
    const FRACTAL_INCLUDE_DEFAULT = null;

    /**
     * The Request instance
     *
     * @var \Illuminate\Http\Request
     */
    protected $request;

    /**
     * Various request parameters
     *
     * @var String
     */
    protected $page;
    protected $perPage;
    protected $sortColumn;
    protected $sortDirection;
    protected $searchQuery;
    protected $includes;

    public function __construct(Request $request)
    {
        $this->request = $request;

        $this->parseParams();
    }

    /**
     * Parse all of the request parameters
     */
    private function parseParams()
    {
        $this->page = $this->parseSingleParam(self::PAGE, self::PAGE_DEFAULT);
        $this->perPage = $this->parseSingleParam(self::PER_PAGE, self::PER_PAGE_DEFAULT);
        $this->sortColumn = $this->parseSingleParam(self::SORT, self::SORT_DEFAULT);
        $this->sortDirection = $this->parseSingleParam(self::ORDER, self::ORDER_DEFAULT);
        $this->searchQuery = $this->parseSingleParam(self::SEARCH, self::SEARCH_DEFAULT);
        $this->includes = $this->parseSingleParam(self::FRACTAL_INCLUDE, self::FRACTAL_INCLUDE_DEFAULT);
    }

    /**
     * Parse a single parameter from the request.
     *
     * It parses it in the following order :
     * 1) Parse from the request
     * 2) If it is missing, get the default value from the config
     * 3) If it is still missing, use the default passed in the function
     *
     * @param  string $paramKey The key of this parameter
     * @param  string $default  The default value if it is missing.
     * @return mixed           [description]
     */
    private function parseSingleParam($paramKey, $default)
    {
        return $this->getParamValue($paramKey, $this->getParamDefaultValue($paramKey, $default));
    }

    /**
     * Get the name of a request parameter from the user's configuration
     *
     * @param  String $key This parameter's key
     * @return String      This parameter's name
     */
    public function getParamName($key)
    {
        return config('api-response.parameters.' . $key, $key);
    }

    /**
     * Get the value of a request parameter
     *
     * @param  String $key    This parameter's key
     * @param  mixed $default The default value to return
     * @return mixed          This paramter's value
     */
    public function getParamValue($key, $default = null)
    {
        return $this->request->input($this->getParamName($key), $default);
    }

    /**
     * Get the default value of a request parameter from the config file
     *
     * @param  String $key    This parameter's key
     * @param  mixed $default The default value to return
     * @return mixed          This paramter's value
     */
    public function getParamDefaultValue($key, $default = null)
    {
        return config('api-response.parameters_defaults.' . $key, $default);
    }

    /**
     * Determine if a feature is enabled or not
     *
     * @param  String $key This feature's key
     * @return String      This feature's state
     */
    public function isFeatureEnabled($key, $default = true)
    {
        return config('api-response.features.' . $key, $default);
    }

    /**
     * Get the Page parameter
     *
     * @return mixed
     */
    public function getPage()
    {
        // the page must be >= 1
        return ($this->page < 1 ? 1 : $this->page);
    }

    /**
     * Get the PerPage parameter
     *
     * @return mixed
     */
    public function getPerPage()
    {
        if ($this->isFeatureEnabled('pagination')) {
            if ($this->perPage < 1 && $this->isFeatureEnabled('force_pagination', false)) {
                // pagination is forced on, we can't return everything all at once
                return $this->getParamDefaultValue(self::PER_PAGE, self::PER_PAGE_DEFAULT);
            }

            // pagination is enabled, and "force_pagination" is off, or not required
            return $this->perPage;
        }

        // pagination is disabled, return all results without pagination
        return -1;
    }

    /**
     * Get the Sort Column parameter
     *
     * @return mixed
     */
    public function getSortColumn()
    {
        if ($this->isFeatureEnabled('sorting')) {
            return $this->sortColumn;
        }

        return null;
    }

    /**
     * Get the Sort Direction parameter
     *
     * @return mixed
     */
    public function getSortDirection()
    {
        if ($this->isFeatureEnabled('ordering')) {
            return $this->sortDirection;
        }

        return null;
    }

    /**
     * Get the Search Query parameter
     *
     * @return mixed
     */
    public function getSearchQuery()
    {
        if ($this->isFeatureEnabled('search', false)) {
            return $this->searchQuery;
        }

        return null;
    }

    /**
     * Get the Includes parameter
     *
     * @return mixed
     */
    public function getIncludes()
    {
        if ($this->isFeatureEnabled('includes')) {
            return $this->includes;
        }

        return null;
    }
}
