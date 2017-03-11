<p>80 degrees Fahrenheit is
 <?php
    $client = new SoapClient(getISSHost() . '/HelloWorld.asmx?WSDL');

    echo $client->toCentigrade(array('dFahrenheit'=>80.0))->toCentigradeResult;
?>
 degrees Centigrade</p>