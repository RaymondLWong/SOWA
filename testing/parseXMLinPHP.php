<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

    <head></head>
    <body>
        <pre>
        <?php
            $xmlLocation = "house.xml";

            try {
                $xml = simplexml_load_file($xmlLocation);

//                $data = $xml->House[1];
//                print_r($xml); // pretty print object (<pre></pre> tags required)
//                print_r("<br /> --- <br />");
//                print_r($data);

                $heading = "<h1>Property addresses</h1><br/>";

                print_r($heading);
                foreach ($xml as $value) {
                    print($value->Address[0] . " " . count($value->Room) . " <br />");
                }
            } catch (Exception $e) {
                die($e);
            }
        ?>
        </pre>
    </body>

</html>