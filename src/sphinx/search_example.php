<?php

require_once __DIR__ . '/vendor/autoload.php';

error_reporting(E_ALL);
ini_set("display_errors", true);

if (empty($_GET['q'])) {
    echo 'Choose a query string like: <a href="search_example.php.php?q=barcelona">barcelona</a>';
    die();
}

// Create Sphinx client instance
$sphinx = new \Sphinx\SphinxClient();

// Set where the sphinx server (searchd) is running
$sphinx->SetServer('localhost', "9312");

/**
 * We can select how sphinx will order the results.
 *
 * We'll use SPH_SORT_EXTENDED when we want SQL like ordering, selecting the fields to order by.
 * For example, the default Sphinx order returns the same order as:
 *
 *      $sphinx->SetSortMode(\Sphinx\SphinxClient::SPH_SORT_EXTENDED, '@weight DESC, municipio ASC');
 *
 *
 * ...where internal fields like 'weight' are prefixed by '@', while our own fields are not. We can order
 * by any field that we've specified as sql_field_string or sql_attr_string in the index configuration.
 *
 * We'll use SPH_SORT_EXPR when we need to use some values/fields to calculate our own ranking. You can
 * use Sphinx functions and expressions listed here http://sphinxsearch.com/docs/current/expressions.html
 * For example, improving users' weight by adding user_karma and pageviews:
 *
 *      $sphinx->SetSortMode(\Sphinx\SphinxClient::SPH_SORT_EXPR, "@weight + (user_karma + ln(pageviews)) * 0.1");
 *
 *
 * More info: http://sphinxsearch.com/docs/current/sorting-modes.html
 */
$sphinx->SetSortMode(\Sphinx\SphinxClient::SPH_SORT_EXTENDED, '@weight DESC, municipio ASC');

// Choose the offset and limit for the query.
$sphinx->SetLimits(0, 23);

// We can restrict values on attributes.
// Restrict attribute id_provincia to Barcelona and Girona (id_provincia=8, id_provincia=17):
$sphinx->SetFilter( 'id_provincia', array( 8, 17 ) );

/**
 * We've two different ways to execute sphinx queries.
 * If you want to execute just one query, use:
 *
 *      $results = $sphinx->query('Barcelona', 'municipios');
 *
 * If you need to execute several queries at the same time, you can do it like these:
 *
 *      $sphinx->AddQuery('Barcelona', 'municipios');
 *      $sphinx->AddQuery('Vigo', 'municipios');
 *      $results = $sphinx->RunQueries();
 *
 *
 * Returned array will contain a different key for every query.
 *
 * In both cases, if there is an error the function will return false. To see which error, use:
 *
 *      var_dump($sphinx->getLastError());
 *      var_dump($sphinx->getLastWarning());
 *
 *
 * If there were no errors, $results will be an array of matching documents with the following interesting fields:
 *
 *      - matches: Documents that matched the query
 *      - total: How many documents have returned, depending on Sphinx configuration
 *      - total_found: How many documents contain the query
 *      - time: Time taken to perform the query
 *      - words: Words that Sphinx tried to find
 *
 */
?>



    <!DOCTYPE html>
    <html lang="es-ES">
    <head>
        <meta charset="utf-8">
    </head>
    <body>

<?php
/**
 * Example that will search in Sphinx the query passed as query string, like:
 * http://vagrant.dev:8080/sphinx/search_example.php?q=barcelona
 *
 * If we want to match substrings and we have 'enable_star' set to 1, we can use wildcards like
 *
 *      $results = $sphinx->query($_GET['q'] . "*", 'municipios');
 */


$results = $sphinx->query($_GET['q'], 'municipios');

if (!$results) {
    var_dump($sphinx->getLastError());
    var_dump($sphinx->getLastWarning());
}else{
    echo "TOTAL: " . $results['total'] . "<br /><br />";
    foreach($results['matches'] as $municipio) {
        echo "{$municipio['attrs']['municipio']}<br />";
    }
}