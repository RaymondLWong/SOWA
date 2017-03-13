<?php

if(isset($_POST['submit'])){
    $currentPage = $_SERVER['REQUEST_URI'];
    $newPage = str_replace('findImageTest.php', 'findImage.php?picID=' . $_POST['search'], $currentPage);
    header('Location: '. $newPage);
}
?>

<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
    <label for="search">Search a property picture by its id.</label>
    <input type="text" name="search" id="search" value="2"/>
    <input type="submit" name="submit" value="Search">
</form>