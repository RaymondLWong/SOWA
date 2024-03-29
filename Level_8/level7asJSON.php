<?php

include "../common/functions.php";

if (isset($_POST['submit'])) {
    echo getScaffoldingPart1(
        $_POST['minBeds'],
        $_POST['maxBeds'],
        $_POST['minCost'],
        $_POST['maxCost']
    );
} else {
    echo getScaffoldingPart1();
}
?>

<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">

<?php

if (isset($_POST['submit'])) {

    $typeOfHousing = getHousingAsStr($_POST['type']);

    $args = array(
        'title' => $_POST['title'],
        'desc' => $_POST['desc'],
        'loc' => $_POST['loc'],
        'addr' => $_POST['addr'],
        'type' => $typeOfHousing,
        'minBeds' => $_POST['minBeds'],
        'maxBeds' => $_POST['maxBeds'],
        'minCost' => $_POST['minCost'],
        'maxCost' => $_POST['maxCost'],
        'limit' => $_POST['limit'],
        'offset' => $_POST['offset']
    );
    $queryString = http_build_query($args);

    $url = getLevelFromHost(0, 8) . 'level4asJSON.php?' . $queryString;

    $divID = "example";
    $executeJS = "
<script type=\"text/javascript\">
    displayResultFromJSON('{$url}', '{$divID}');
</script>
";

    // http://stackoverflow.com/questions/4035742/parsing-json-object-in-php-using-json-decode
//    $json = json_decode($result, true);
//
//    header('Content-Type: application/json');
//    echo $json['listings']['Property'][0]['@source'];

    echo getScaffoldingPart2(
        $_POST['title'],
        $_POST['desc'],
        $_POST['loc'],
        $_POST['addr'],
        $_POST['type'],
        $_POST['limit'],
        $_POST['offset'],
        $divID,
        $executeJS
    );
} else {
    echo getScaffoldingPart2();
}