<?php


function test( $passed, $message )
{
    $label = $passed ? 'PASSED' : 'FAILED';
    echo "[$label]: $message\n";
    return $passed;
}

header( 'Content-Type: text/plain' );
if ( test( class_exists( '\Memcached' ), 'Loading PHP extension Memcached' ) )
{
    $memcached = new \Memcached();
    test( $memcached->addServer( 'localhost', 11211 ), 'Connecting to memcached server' );
    test( null === $memcached->get( 'cache_test' ), 'Getting unknown items' );
    test( $memcached->set( 'cache_test', 'HELLO WORLD', 10 ), 'Setting data' );
    test( 'HELLO WORLD' == $memcached->get( 'cache_test' ), 'Getting saved data' );
}
elseif( test( class_exists( '\Memcache' ), 'Loading PHP extension Memcache' ) )
{
    $memcached = new \Memcache();
    test( $memcached->addServer( 'localhost', 11211 ), 'Connecting to memcached server' );
    test( null === $memcached->get( 'cache_test' ), 'Getting unknown items' );
    test( $memcached->set( 'cache_test', 'HELLO WORLD', 0,  10 ), 'Setting data' );
    test( 'HELLO WORLD' == $memcached->get( 'cache_test' ), 'Getting saved data' );
}

