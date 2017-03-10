<?php

include "db.php";
include "functions.php";

if (isset($_REQUEST['propID'])) {
    $query = "
    SELECT
        PictureID
    FROM gallery
    WHERE
        PropertyID = {$_REQUEST['propID']}
    ";

    $result = mysqli_query($link,$query) or showError(mysqli_error($link));
//    echo mysqli_num_rows($result);

    echo "<html><body>";
    while ($row = mysqli_fetch_assoc($result)) {
        $picID = $row['PictureID'];
        $picLoc = findImage($picID);

        if ($picLoc != null) {
            $imagePath = "http://" . $_SERVER['HTTP_HOST'] . str_replace('fetchAllPictures.php', $picLoc, $_SERVER['PHP_SELF']);
            echo "<img src='{$imagePath}' />";
        }
    }

    echo "</body></html>";
}
