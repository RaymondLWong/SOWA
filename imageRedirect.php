<?php
if(!empty($_POST)){
    $currentPage = $_SERVER['REQUEST_URI'];
    $newPage = str_replace('imageRedirect.php', 'images/hut.png', $currentPage);
    header('Location: '. $newPage);
//    http_redirect('/images/hut.png');
}
?>

<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
    <label for="search">Search an image by its ID.</label>
    <input type="text" name="search" id="search" value="hut"/>
    <input type="submit" name="submit" value="Search">

    <div id="imageResult"></div>
</form>