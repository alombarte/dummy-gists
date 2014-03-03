<?php

// Connection
$cache = new Memcached();
$cache->addServer( 'localhost', 11211 );

// Key behaviour
$key = __CLASS__ ;
$expiration_in_seconds = 300;

// Return the value from cache or calculate it + store it
$value = $cache->get( $key );
if ( null === $value )
{
    $value = 'CALCULATE THE COSTLY OPERATION HERE';
    $cache->set( $key, $value, $expiration_in_seconds );
}

return $value;