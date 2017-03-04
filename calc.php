<h1>SOAP WebSite </h1>
<form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>">
    <p>
        <?php
        $t = ( isset($_POST['target']) ) ? $_POST['target'] : 'goldfish';
        $dF = ( isset($_POST['dF']) ) ? $_POST['dF'] : '80.0';
        ?>
        <input type="text" name="target" value="<?php echo $t ?>"/>
        <input type="text" name="dF" value="<?php echo $dF ?>"/>
        <input type="submit" />
    </p>
</form>
<p>
    <?php
    if ( isset($_POST['dF']) ) {
        $dFarray = array('dFahrenheit'=>(double)$dF);
        $client = new SoapClient('http://localhost:64153/HelloWorld.asmx?WSDL');
        echo $client->encodeMd5($_POST)->encodeMd5Result;
        echo '<br /><br />';
        echo $client->toCentigrade($dFarray)->toCentigradeResult;
    }
    ?>
</p>