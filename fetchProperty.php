<?php

include "db.php";
include "functions.php";

if (isset($_REQUEST['propID'])) {

    $propID = $_REQUEST['propID'];

    // get property details (excluding images)
    $query = "
    SELECT
        Title, 
        Description, 
        Type, 
        Location, 
        NoOfBeds, 
        CostPerWeek, 
        Address,
        Email
    FROM Properties
    INNER JOIN users ON users.UserID=properties.UserID
    WHERE
        PropertyID = {$propID}
    ";

    $result = mysqli_query($link,$query) or showError(mysqli_error($link));

    // get all images from property
    $imageQuery = "
    SELECT
        PictureID
    FROM gallery
    WHERE
        PropertyID = {$propID}
    ";

    $imageResult = mysqli_query($link, $imageQuery) or showError(mysqli_error($link));

    $html = getSinglePropertyScaffold();

    $nodes = getHeadings();

    $curPage = "fetchProperty.php";

    while ($row = mysqli_fetch_assoc($result)) {

        // property table
        $html .= "<tr>\r\n
    <td>{$propID}</td>\r\n";

        foreach ($nodes as $field) {
            $html .= "    <td>{$row[$field]}</td>\r\n";
        }

        $html .= "</table>\r\n<br/>";

        // get pictures and display in its on table
        if (mysqli_num_rows($imageResult) > 0) {
            // heading that spans all columns: http://stackoverflow.com/questions/398734/colspan-all-columns
            $html .= getImageTableHTML();
        }

        while ($imageRow = mysqli_fetch_assoc($imageResult)) {
            $picID = $imageRow['PictureID'];

            if ($picID != null) {
                $imgTag = findImageAndReturnLocation($picID, $curPage);
                $imgTag = ($imgTag != null) ? $imgTag : getImageNotFoundError($picID);
                $html .= "    <td>{$imgTag}</td>\r\n";
            }
        }

        $html .= "</table></tr>\r\n";
    }

    $html .=  "</body>\r\n</html>";
    echo $html;
}
