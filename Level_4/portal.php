<?php
include "../functions.php";

if(!empty($_POST)){
    $currentPage = $_SERVER['REQUEST_URI'];

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

    $newPage = str_replace('portal.php', 'aggregate.php?' . $queryString, $currentPage);
    header('Location: '. $newPage);
}

echo getScaffoldingPart1();
?>
<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
<?php echo getScaffoldingPart2(); ?>