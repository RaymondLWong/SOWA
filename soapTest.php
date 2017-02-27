<p>80 degrees Fahrenheit is
 <?php
    $client = new SoapClient('http://localhost:64153/HelloWorld.asmx?WSDL');

    echo $client->toCentigrade(array('dFahrenheit'=>80.0))->toCentigradeResult;
?>
 degrees Centigrade</p>