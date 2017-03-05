<?php

include "functions.php";

if(isset($_POST['submit'])){
    if (
        isset($_POST['title']) &&
        isset($_POST['desc']) &&
        isset($_POST['loc']) &&
        isset($_POST['addr']) &&
        isset($_POST['type']) &&
        isset($_POST['minBeds']) &&
        isset($_POST['maxBeds']) &&
        isset($_POST['minCost']) &&
        isset($_POST['maxCost']) &&
        isset($_POST['limit']) &&
        isset($_POST['offset'])
    ) {
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

        $newPage = str_replace('searchTest.php', 'search.php?' . $queryString, $currentPage);
        header('Location: '. $newPage);
    } else {
        echo "One of the fields are empty, please fill them all in.";
    }
}

echo getScaffoldingPart1();
?>
<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
<?php echo getScaffoldingPart2(); ?>