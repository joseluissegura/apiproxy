<?php
function nvl(&$var, $default = 0)
{
    return isset($var)==true ? $var
                       : $default;
}
class XMLSerializer {

    public static function generateValidXmlFromObj(stdClass $obj, $node_block='nodes', $node_name='node') {
        $arr = get_object_vars($obj);
        return self::generateValidXmlFromArray($arr, $node_block, $node_name);
    }

    public static function generateValidXmlFromArray($array, $node_block='nodes', $node_name='node') {
        $xml = '<?xml version="1.0" encoding="UTF-8" ?>';

        $xml .= '<' . $node_block . '>';
        $xml .= self::generateXmlFromArray($array, $node_name);
        $xml .= '</' . $node_block . '>';

        return $xml;
    }

    private static function generateXmlFromArray($array, $node_name) {
        $xml = '';

        if (is_array($array) || is_object($array)) {
            foreach ($array as $key=>$value) {
                if (is_numeric($key)) {
                    //$key = $node_name;
                    $xml .= self::generateXmlFromArray($value, $node_name);
                    if ($key < (count($array)-1)){
                        $xml .= '</' .$node_name . '><' . $node_name . '>';
                    }
                }else{
                    if ($key == "Mercancia"){
                        self::generateXmlFromArray($value, $node_name);
                    }else{
                        $xml .= '<' . $key . '>' . self::generateXmlFromArray($value, $key) . '</' . $key . '>';                          
                    }
                }
            }
        } else {
            $xml = htmlspecialchars($array, ENT_QUOTES);
        }
        return $xml;
    }
}

class Factura {
    public function __construct() {
        // allocate your stuff
    }
    public static function calcula(&$data){
        $detalle = $data->DetalleServicio->LineaDetalle;
        $TotalServExentosTally = 0;
        $TotalServGravadosTally = 0;
        $TotalMercanciasExentasTally = 0;
        $TotalMercanciasGravadasTally = 0;
        $DescuentosTally = 0;
        $ImpuestosTally = 0;
        foreach($detalle as $l){
            $l->MontoTotal = $l->Cantidad*$l->PrecioUnitario;
            $l->SubTotal = $l->MontoTotal-$l->MontoDescuento;
            $tMontoTally = 0;
            foreach($l->Impuesto as $t){
                $t->Tarifa = number_format($t->Tarifa,2);
                $t->Monto = $l->SubTotal*($t->Tarifa/100);
                $tMontoTally += $t->Monto;
            }
            $l->MontoTotalLinea = $l->SubTotal+$tMontoTally;
            
            if (isset($l->Mercancia)){
                if ($tMontoTally > 0){
                    $TotalServGravadosTally += $l->MontoTotal;
                } else {
                    $TotalServExentosTally += $l->MontoTotal;    
                }
            }
            else{
                if ($tMontoTally > 0){
                    $TotalMercanciasGravadasTally += $l->MontoTotal;
                } else {
                    $TotalMercanciasExentasTally += $l->MontoTotal;    
                }
            }
            $DescuentosTally =+ $l->MontoDescuento;
            $ImpuestosTally += $tMontoTally;
        }
        $r = $data->ResumenFactura;
        if ($TotalMercanciasGravadasTally > 0){
            $r->TotalMercanciasGravadas = $TotalMercanciasGravadasTally;
        }
        if ($TotalServGravadosTally  > 0){
            $r->TotalServGravados = $TotalServGravadosTally;
        }
        if ($TotalMercanciasExentasTally > 0){
            $r->TotalMercanciasExentas = $TotalMercanciasExentasTally;
        }
        if ($TotalServExentosTally > 0){
            $r->TotalServExentos = $TotalServExentosTally;
        }
        if (($TotalServGravadosTally+$TotalMercanciasGravadasTally) > 0){
            $r->TotalGravado =$TotalServGravadosTally+$TotalMercanciasGravadasTally;
        }
        if (($TotalServExentosTally+$TotalMercanciasExentasTally) > 0){
            $r->TotalExento =$TotalServExentosTally+$TotalMercanciasExentasTally;
        }
        $r->TotalVenta = $TotalServGravadosTally+$TotalMercanciasGravadasTally+$TotalServExentosTally+$TotalMercanciasExentasTally;
        if ($DescuentosTally > 0){
            $r->TotalDescuentos =$DescuentosTally; //":{},opc /=Suma(LineaDetalle.MontoDescuento)
        }
        $r->TotalVentaNeta =$r->TotalVenta-$DescuentosTally;
        if ($ImpuestosTally > 0){
            $r->TotalImpuesto =$ImpuestosTally;  //":{},opc /=Suam(LineaDetalle.Impuesto.Monto)
        }
        $r->TotalComprobante =$r->TotalVentaNeta+$ImpuestosTally;
        $data->Normativa = (object) [
            'NumeroResolucion' => 'DGT-R-48-2016',
            'FechaResolucion' => '20-02-2017 13:22:22',
        ];
        return $data;
    }
    public static function loopArray(&$data,$confObj,$lvl=0){
        foreach($data as $value){
            Factura::loopObject($value,$confObj,$lvl+1);
        }
        unset($value);
    }
    public static function loopObject(&$data,$confObj,$lvl=0){
        if (is_array($data)){
////            echo "<br>";
            Factura::loopArray($data,$confObj,$lvl);
            return;
        }
        if (!is_object($data)){
            if (isset($confObj['dinero'])){
                $data = number_format($data,5,".","");
            }
            if (isset($confObj['decimal'])){
                $data = number_format($data,$confObj['decimal'],".","");
            }
            if (isset($confObj['pad'])){
////                echo "{$data}/pad:{$confObj['pad']}<br>";
                $data = str_pad($data, $confObj['pad'], "0", STR_PAD_LEFT);
            }
            if (isset($confObj['max'])){
                $data = substr($data,0,$confObj['max']);
            }
////            echo "$data<br>";
            return;
        }
////        echo "<br>";
        foreach ($data as $key => &$value) {
////                    echo str_repeat("&nbsp;",$lvl*5)."$key =>";
                    Factura::loopObject($value,$confObj[$key],$lvl+1);
        }
        unset($value);
    }
    public static function isValid($xml_name,$xsd){
        $xml = new DOMDocument(); 
        $xml->loadXML($xml_name);
        if (!$xml->schemaValidate($xsd)) {
            return 'DOMDocument::schemaValidate() Generated Errors!';
            //libxml_display_errors();
        }else{
            return 'ok';
        }
    }
    public static function formatea(&$data,$confObj){
        Factura::loopObject($data,Factura::getEnums());
        return $data;
    }
    public static function withJson($json){
        $data = json_decode(utf8_encode($json),false);
        return $data;
    }
    public static function getJsonEnums(){
        return json_encode(Factura::getEnums());
    }
    public static function getEnums(){
        $factura_rules = json_decode(utf8_encode(file_get_contents("datasets/factura_rules.json")),true);
        $factura = $factura_rules['factura'];
        $factura['Emisor']['Ubicacion']['Provincia']['enum']    = $factura_rules['Provincia'];
        $factura['Emisor']['Ubicacion']['Canton']['enum']       = $factura_rules['Canton'];
        $factura['Emisor']['Ubicacion']['Distrito']['enum']     = $factura_rules['Distrito'];
        $factura['Receptor']['Ubicacion']['Provincia']['enum']  = $factura_rules['Provincia'];
        $factura['Receptor']['Ubicacion']['Canton']['enum']     = $factura_rules['Canton'];
        $factura['Receptor']['Ubicacion']['Distrito']['enum']   = $factura_rules['Distrito'];
        return $factura;
    }
};
