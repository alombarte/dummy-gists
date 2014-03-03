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

// Restrict to Barcelona and Girona (id_provincia=8, id_provincia=17):
$sphinx->SetFilter( 'id_provincia', array( 8, 17 ) );
// Returns the first 5 results, let's say we want the "page 1".
$sphinx->SetLimits( 0, 5 );

$sphinx->AddQuery( $query_string, $index );
$results = $sphinx->RunQueries();
if ( !empty( $results[0]['matches'] ) )
{
    var_dump( $results[0]['matches'] );
    echo "Total matches: " . $results[0]['total_found'];
}
else
{
    die( "No results found for '$query_string'" );
}