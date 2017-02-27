<h1>SOAP WebSite </h1>
<form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>">
    <p>
        <?php
        $t = ( isset($_POST['title']) ) ? $_POST['title'] : 'title';
        ?>
        <input type="text" name="title" value="<?php echo $t ?>"/>
        <input type="submit" />
    </p>
</form>
<p>
    <?php
    if ( isset($_POST['title']) ){
        try {
            $client = new SoapClient('http://localhost:64153/HelloWorld.asmx?WSDL');
            $xmlString = $client->lookup($_POST)->lookupResult->any;

            $root = 'listings';

            $old = new DOMDocument;
            $old->loadXML($xmlString);

            $creator = new DOMImplementation;
            $doctype = $creator->createDocumentType($root, null, 'test.dtd');
            $new = $creator->createDocument(null, null, $doctype);
            $new->encoding = "utf-8";

            $oldNode = $old->getElementsByTagName($root)->item(0);
            $newNode = $new->importNode($oldNode, true);
            $new->appendChild($newNode);

            if($new->validate()) {
                echo "VALID\n";

                $xslt = new XSLTProcessor();
                $xslDoc = new DOMDocument();
                $xslDoc->load('test.xsl', LIBXML_NOCDATA);
                $xslt->importStylesheet($new);

                echo $xslt->transformToXML($new);
            } else {
                echo "NOT VALID\n";
            }
        } catch ( exception $e ) {
            echo '<p>Unable to contact Web Service</p>';
            echo '<p>Caught exception: ' . $e->getMessage() . "</p>\n";
        }
    }
    ?>
</p>


