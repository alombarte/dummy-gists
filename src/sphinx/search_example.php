<?php

include '/var/lib/sphinx/api/sphinxapi.php';
$index = 'municipios';

if ( !isset( $argv[1] ) )
{
    die( 'You need to specify a search term' );
}

$query_string = $argv[1];
$sphinx = new \SphinxClient();
$sphinx->SetServer( '127.0.0.1', 9312);
$sphinx->SetMatchMode( SPH_MATCH_EXTENDED );
$sphinx->SetSortMode( SPH_SORT_RELEVANCE );
$sphinx->AddQuery( $query_string, $index );
$results = $sphinx->RunQueries();
if ( !empty( $results[0]['matches'] ) )
{
    var_dump( $results[0]['matches'] );
}
else
{
    die( "No results found for '$query_string'" );
}