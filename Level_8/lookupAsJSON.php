<?php

include "../common/functions.php";

if ( isset($_REQUEST) ) {

    $args = array(
        'title' => 'title',
        'desc' => 'desc',
        'loc' => 'loc',
        'addr' => 'addr',
        'type' => 'House',
        'minBeds' => 1,
        'maxBeds' => 4,
        'minCost' => 1,
        'maxCost' => 10 * 1000,
        'limit' => 25,
        'offset' => 0
    );
    $queryString = http_build_query($args);

    $url = getISSHost() . '/search.asmx/lookupAllAsJSON?' . $queryString;
    $result = file_get_contents($url);

    echo $result;
}
?>