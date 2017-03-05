<?php

if(isset($_POST['submit'])){
    if (
        isset($_POST['title']) &&
        isset($_POST['desc']) &&
        isset($_POST['loc']) &&
        isset($_POST['addr'])
    ) {
        $currentPage = $_SERVER['REQUEST_URI'];

        $vars = array(
            'title' => $_POST['title'],
            'desc' => $_POST['desc'],
            'loc' => $_POST['loc'],
            'addr' => $_POST['addr'],
            'type' => $_POST['type'],
            'minBeds' => $_POST['beds']
        );
        $queryString = http_build_query($vars);

        $newPage = str_replace('searchTest.php', 'search.php?' . $queryString, $currentPage);
        header('Location: '. $newPage);
    } else {
        echo "One of the fields are empty, please fill them all in.";
    }
}
?>

<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">

    <div>
        <label for="title">Title</label>
        <input type="text" name="title" id="title" value="title"/>
    </div>

    <div>
        <label for="desc">Description</label>
        <input type="text" name="desc" id="desc" value="desc"/>
    </div>

    <div>
        <label for="loc">Location</label>
        <input type="text" name="loc" id="loc" value="loc"/>
    </div>

    <div>
        <label for="addr">Address</label>
        <input type="text" name="addr" id="addr" value="addr"/>
    </div>

    <div>
        <label for="type">Type of housing</label>
        <select name="type" id="type">
            <option value="0" selected="selected">Any</option>
            <option value="1">House</option>
            <option value="2">Flat</option>
            <option value="3">Villa</option>
        </select>
    </div>

<!--    <div>-->
<!--        <label for="beds">Type of housing</label>-->
<!--        <select name="beds" id="beds">-->
<!--            <option value="0" selected="selected">Any</option>-->
<!--            <option value="1">1</option>-->
<!--            <option value="2">2</option>-->
<!--            <option value="3">3</option>-->
<!--            <option value="4">4</option>-->
<!--            <option value="5">5/+</option>-->
<!--        </select>-->
<!--    </div>-->

    <input type="submit" name="submit" value="Search">
</form>