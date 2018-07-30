<?php
include('factura_lib');
/*
$json = utf8_encode(file_get_contents("factura1.json"));
$data = Factura::withJson($json);
$data = Factura::calcula($data);
$data = Factura::formatea($data,Factura::getEnums());

$data = XMLSerializer::generateValidXmlFromObj($data,'FacturaElectronica');
//file_put_contents("example1.xml",$data);
Factura::isValid($data,'xsd/FacturaElectronica.xsd');
*/
$func = $_GET['r'];

$json = utf8_encode(nvl($_GET['data'],'{}'));

switch ($func){
    case "enums":
        echo json_encode(Factura::getEnums());
        break;
    case "struct":
        echo file_get_contents("json/FacturaElectronica.json");
        break;
    case "example":
        echo file_get_contents("example/FacturaElectronica.json");
        break;
    case "save":
        file_put_contents("example1.json",$json);
        echo "{'status':'ok'}";
        break;
    case "calcula":
        $data = Factura::withJson($json);
        $data = Factura::calcula($data);
        $data = Factura::formatea($data,Factura::getEnums());
        echo json_encode($data);
        break;
    case "genXML":
        $data = Factura::withJson($json);
        $data = Factura::calcula($data);
        $data = Factura::formatea($data,Factura::getEnums());
        $data = XMLSerializer::generateValidXmlFromObj($data,'FacturaElectronica');
        echo $data;
        break;
    case "saveXML":
        $data = Factura::withJson($json);
        $data = Factura::calcula($data);
        $data = Factura::formatea($data,Factura::getEnums());
        $data = XMLSerializer::generateValidXmlFromObj($data,'FacturaElectronica');
        file_put_contents("example1.xml",$data);
        echo "{'status':'ok'}";
        break;
    case "validate":
        $data = Factura::withJson($json);
        $data = Factura::calcula($data);
        $data = Factura::formatea($data,Factura::getEnums());

        $data = XMLSerializer::generateValidXmlFromObj($data,'FacturaElectronica');
        //file_put_contents("example1.xml",$data);
        $status = Factura::isValid($data,'xsd/FacturaElectronica.xsd');
        echo "{'status':'{$status}'}";
        break;
    default:
        echo "{}";
        break;
}
        
