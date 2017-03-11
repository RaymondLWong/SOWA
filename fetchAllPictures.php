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

    echo "<html><body>";
    while ($row = mysqli_fetch_assoc($result)) {
        $picID = $row['PictureID'];

        if ($picID != null) {
            echo findImageAndReturnLocation($picID, "fetchAllPictures.php");
        }
    }

    echo "</body></html>";
}
