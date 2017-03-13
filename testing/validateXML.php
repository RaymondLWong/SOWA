    <?php

    $xml = <<<END
<?xml version="1.0" encoding="utf-8"?>
<foo>
    <bar>baz</bar>
</foo>
END;

    $root = 'foo';

    $old = new DOMDocument;
    $old->loadXML($xml);

    $creator = new DOMImplementation;
    $doctype = $creator->createDocumentType($root, null, 'bar.dtd');
    $new = $creator->createDocument(null, null, $doctype);
    $new->encoding = "utf-8";

    $oldNode = $old->getElementsByTagName($root)->item(0);
    $newNode = $new->importNode($oldNode, true);
    $new->appendChild($newNode);

    if($new->validate()) {
        echo "VALID";
    } else {
        echo "NOT VALID";
    }

    ?>
</p>


