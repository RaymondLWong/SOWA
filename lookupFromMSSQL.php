<?php

if (!empty($_POST)) {
    $client = new SoapClient('http://localhost:64153/search.asmx?WSDL');

    $xmlResult = $client->lookup($_POST)->lookupResult->any;

    $xmlDom = new DOMDocument();
    $xmlDom->loadXML($xmlResult, LIBXML_NOBLANKS);

    echo $xmlDom->saveXML(); // TODO: redirect or fix return as XML
}
?>

<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
    <label for="search">Search a property by its description.</label>
    <input type="text" name="search" id="search" value="desc"/>
    <input type="submit" name="submit" value="Search"/>
</form>
