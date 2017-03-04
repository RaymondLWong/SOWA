<?php
if(!empty($_POST)){
    $currentPage = $_SERVER['REQUEST_URI'];
    $newPage = str_replace('searchTest.php', 'search.php?name=' . $_POST['search'], $currentPage);
    header('Location: '. $newPage);
//    http_redirect('/images/hut.png');
}
?>

<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
    <label for="search">Search a property by its description.</label>
    <input type="text" name="search" id="search" value="desc"/>
    <input type="submit" name="submit" value="Search">
</form>