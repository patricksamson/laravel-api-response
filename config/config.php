<?php

return [

    /**
     * Set the features you want to be enabled by default
     */
    'features' => [
        'pagination'       => true,
        'force_pagination' => false, // Refuse to return all results on a single page ( per_page = -1 )
        'sorting'          => true, // Sort based on specified attribute
        'ordering'         => true, // Sort by ascending/descending order
        'search'           => false, // Filter results based on a search query (YOU NEED TO IMPLEMENT THE SEARCH FUNCTION, SEE THE DOCS)
        'includes'         => true, // Use Fractal's Transformers and Serializers
    ],

    /**
     * Set the URL parameters names
     */
    'parameters' => [
        'page'     => 'page',
        'per_page' => 'per_page',
        'sort'     => 'sort',
        'order'    => 'order',
        'search'   => 'search',
        'include'  => 'include',
    ],

    /**
     * Set the URL parmeters default values
     */
    'parameters_defaults' => [
        'page'     => 1,
        'per_page' => 10,
        'sort'     => null,
        'order'    => 'asc',
        'search'   => null,
        'include'  => null,
    ],

];
