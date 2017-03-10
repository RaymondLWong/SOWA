<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
    <label for="search">Search a property picture by its id.</label>
    <input type="text" name="search" id="search" value="2"/>
    <input type="submit" name="submit" value="Search">
</form>

<?php

include "functions.php";

if(isset($_POST['submit'])){
    $currentPage = $_SERVER['REQUEST_URI'];
    $url = getHost() . str_replace('image.php', 'findImage.php?picID=' . $_POST['search'], $currentPage);

    $xml = new DOMDocument();
    $xml->load($url);

    $data = $xml->firstChild->nodeValue;
    if ($data != null) {
        echo "<img src='{$data}' />";
    }
}
?>
