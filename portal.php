<?php
if(!empty($_POST)){
    $currentPage = $_SERVER['REQUEST_URI'];
    $newPage = str_replace('portal.php', 'aggregate.php?name=' . $_POST['search'], $currentPage);
    header('Location: '. $newPage);
}
?>

<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
    <label for="search">Search a property by its description.</label>
    <input type="text" name="search" id="search" value="desc"/>
    <input type="submit" name="submit" value="Search"/>
</form>