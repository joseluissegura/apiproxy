<?php
include('factura_lib.php');
$json = utf8_encode(file_get_contents("factura1.json"));
$data = Factura::withJson($json);
$data = Factura::calcula($data);
$data = Factura::formatea($data,Factura::getEnums());

$data = XMLSerializer::generateValidXmlFromObj($data,'FacturaElectronica');
file_put_contents("example1.xml",$data);
