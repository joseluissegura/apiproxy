# apiproxy
proxy FacturaElectronica

###para llamar al servicio desde el browser mandar los siguientes parametros
* r = // este es el servicio
* data = // este es el json con los datos de la factura

servicios (r=) :
* ack: tipo ping devuelve nack.  Para que la aplicacion si lo desea utilice para verificar que el api esta instalado y funcionando
* enums: trae los enums de los campos y algunas caracterisitcas como regex si se desean usar
* struct:  trae una estructura json vacia del documento. Con el objeto de ayudar al integrador de la aplicacion a ver como es la estructura a recibir
* example: trae una estructura json de ejemplo para guiarse. Estos son casos de estrcturas ya llenas de datos validas que hacienda acepta o acepto cuando se probo en sandbox 
* download: baja un zip con los xml y su respuesta xml
* calcula: calcula los totales y subtotales de la factura y devuelve el documento este es un proceso de loopback no va a hacienda ni es necesario para enviarlo a hacienda. Es solo de informacion para las aplicaciones que lo deseen usar
* validate: valida json contra xsd no valida ninguna logica de negocio aun
* saveXML:  guarda en el servidor el archivo xml y envia a hacienda el documento.  Devuelve la clave (consecutivo universal) y el consecutivo (por Emisor,Agencia,Terminal,Tipo de Documento

Servicios prontos por salir:
* pdf por clave: esta funcionalidad es para clientes que deseen que les impriman una factura en papel.
* la documentacion de los reportes esta pendiente

ejemplo:
http://localhost/factura.php?r=example&data={...}

http://localhost/apiproxytest/api.php?r=ack

http://localhost/apiproxytest/api.php?r=enums

http://localhost/apiproxytest/api.php?r=struct

http://localhost/apiproxytest/api.php?r=example

http://localhost/apiproxytest/api.php?r=download&data={%20%22Emisor%22:{%20%22Identificacion%22:{%20%22Tipo%22:%2201%22,%20%22Numero%22:%22000114050239%22%20}},%20%22Clave%22:%2250622081800011405023900100001010000000081100000081%22%20}

http://localhost/fe/api.php?r=calcula&data={%20%22Documento%22:{%22Tipo%22:%2201%22},%20%22Agencia%22:%22001%22,%20%22Terminal%22:%2200001%22,%20%22Emisor%22:{%20%22Identificacion%22:{%20%22Tipo%22:%2201%22,%20%22Numero%22:%22000114050239%22%20}},%20%22Receptor%22:{%20%22Nombre%22:%22ASDFASDF%22,%20%22Identificacion%22:{%20%22Tipo%22:%2202%22,%20%22Numero%22:%223105685003%22%20},%20%22NombreComercial%22:%22BurgerKing%22,%20%22Ubicacion%22:{%20%22Provincia%22:%221%22,%20%22Canton%22:%221%22,%20%22Distrito%22:%221%22,%20%22Barrio%22:%221%22,%20%22OtrasSenas%22:%22100%20sur%20de..%22%20},%20%22Telefono%22:{%20%22CodigoPais%22:%22506%22,%20%22NumTelefono%22:%2287654321%22%20}%20},%20%22CondicionVenta%22:%2201%22,%20%22MedioPago%22:1,%20%22DetalleServicio%22:{%20%22LineaDetalle%22:[%20{%20%22NumeroLinea%22:%221%22,%20%22Mercancia%22:1,%20%22Cantidad%22:%221%22,%20%22UnidadMedida%22:%22Sp%22,%20%22Detalle%22:%22Serv%20Prof%20%22,%20%22PrecioUnitario%22:%225.500%22,%20%22Impuesto%22:[%20{%20%22Codigo%22:%2201%22,%20%22Tarifa%22:%2213%22,%20%22Exoneracion%22:[{%20%22TipoDocumento%22:%2203%22,%20%22NumeroDocumento%22:%221201%22,%20%22NombreInstitucion%22:%22Esc.%20Figueres%20Ferrer%22,%20%22FechaEmision%22:%222018-07-15T06:45:08-06:00%22,%20%22PorcentajeCompra%22:50%20}]%20}%20]%20},%20{%20%22NumeroLinea%22:%222%22,%20%22Mercancia%22:1,%20%22Cantidad%22:%221%22,%20%22UnidadMedida%22:%22Sp%22,%20%22Detalle%22:%22Serv%20Prof%20%22,%20%22PrecioUnitario%22:%225.500%22,%20%22Impuesto%22:[%20{%20%22Codigo%22:%2201%22,%20%22Tarifa%22:%2213%22,%20%22Exoneracion%22:[{%20%22TipoDocumento%22:%2203%22,%20%22NumeroDocumento%22:%221201%22,%20%22NombreInstitucion%22:%22Esc.%20Figueres%20Ferrer%22,%20%22FechaEmision%22:%222018-07-15T06:45:08-06:00%22,%20%22PorcentajeCompra%22:100%20}]%20},%20{%20%22Codigo%22:%2202%22,%20%22Tarifa%22:%222%22,%20%22Exoneracion%22:[{%20%22TipoDocumento%22:%2203%22,%20%22NumeroDocumento%22:%221201%22,%20%22NombreInstitucion%22:%22Esc.%20Figueres%20Ferrer%22,%20%22FechaEmision%22:%222018-07-15T06:45:08-06:00%22,%20%22PorcentajeCompra%22:100%20}]%20}%20]%20},%20{%20%22NumeroLinea%22:%223%22,%20%22Mercancia%22:1,%20%22Cantidad%22:%221%22,%20%22UnidadMedida%22:%22Sp%22,%20%22Detalle%22:%22Serv%20Prof%20%22,%20%22PrecioUnitario%22:%225.500%22%20}%20]%20},%20%22ResumenFactura%22:{}%20}

http://localhost/fe/api.php?r=validate&data={%20%22Documento%22:{%22Tipo%22:%2201%22},%20%22Agencia%22:%22001%22,%20%22Terminal%22:%2200001%22,%20%22Emisor%22:{%20%22Identificacion%22:{%20%22Tipo%22:%2201%22,%20%22Numero%22:%22000114050239%22%20}},%20%22Receptor%22:{%20%22Nombre%22:%22ASDFASDF%22,%20%22Identificacion%22:{%20%22Tipo%22:%2202%22,%20%22Numero%22:%223105685003%22%20},%20%22NombreComercial%22:%22BurgerKing%22,%20%22Ubicacion%22:{%20%22Provincia%22:%221%22,%20%22Canton%22:%221%22,%20%22Distrito%22:%221%22,%20%22Barrio%22:%221%22,%20%22OtrasSenas%22:%22100%20sur%20de..%22%20},%20%22Telefono%22:{%20%22CodigoPais%22:%22506%22,%20%22NumTelefono%22:%2287654321%22%20}%20},%20%22CondicionVenta%22:%2201%22,%20%22MedioPago%22:1,%20%22DetalleServicio%22:{%20%22LineaDetalle%22:[%20{%20%22NumeroLinea%22:%221%22,%20%22Mercancia%22:1,%20%22Cantidad%22:%221%22,%20%22UnidadMedida%22:%22Sp%22,%20%22Detalle%22:%22Serv%20Prof%20%22,%20%22PrecioUnitario%22:%225.500%22,%20%22Impuesto%22:[%20{%20%22Codigo%22:%2201%22,%20%22Tarifa%22:%2213%22,%20%22Exoneracion%22:[{%20%22TipoDocumento%22:%2203%22,%20%22NumeroDocumento%22:%221201%22,%20%22NombreInstitucion%22:%22Esc.%20Figueres%20Ferrer%22,%20%22FechaEmision%22:%222018-07-15T06:45:08-06:00%22,%20%22PorcentajeCompra%22:50%20}]%20}%20]%20},%20{%20%22NumeroLinea%22:%222%22,%20%22Mercancia%22:1,%20%22Cantidad%22:%221%22,%20%22UnidadMedida%22:%22Sp%22,%20%22Detalle%22:%22Serv%20Prof%20%22,%20%22PrecioUnitario%22:%225.500%22,%20%22Impuesto%22:[%20{%20%22Codigo%22:%2201%22,%20%22Tarifa%22:%2213%22,%20%22Exoneracion%22:[{%20%22TipoDocumento%22:%2203%22,%20%22NumeroDocumento%22:%221201%22,%20%22NombreInstitucion%22:%22Esc.%20Figueres%20Ferrer%22,%20%22FechaEmision%22:%222018-07-15T06:45:08-06:00%22,%20%22PorcentajeCompra%22:100%20}]%20},%20{%20%22Codigo%22:%2202%22,%20%22Tarifa%22:%222%22,%20%22Exoneracion%22:[{%20%22TipoDocumento%22:%2203%22,%20%22NumeroDocumento%22:%221201%22,%20%22NombreInstitucion%22:%22Esc.%20Figueres%20Ferrer%22,%20%22FechaEmision%22:%222018-07-15T06:45:08-06:00%22,%20%22PorcentajeCompra%22:100%20}]%20}%20]%20},%20{%20%22NumeroLinea%22:%223%22,%20%22Mercancia%22:1,%20%22Cantidad%22:%221%22,%20%22UnidadMedida%22:%22Sp%22,%20%22Detalle%22:%22Serv%20Prof%20%22,%20%22PrecioUnitario%22:%225.500%22%20}%20]%20},%20%22ResumenFactura%22:{}%20}

http://localhost/fe/api.php?r=validate&data={%20%22Documento%22:{%22Tipo%22:%2201%22},%20%22Agencia%22:%22001%22,%20%22Terminal%22:%2200001%22,%20%22Emisor%22:{%20%22Identificacion%22:{%20%22Tipo%22:%2201%22,%20%22Numero%22:%22000114050239%22%20}},%20%22Receptor%22:{%20%22Nombre%22:%22ASDFASDF%22,%20%22Identificacion%22:{%20%22Tipo%22:%2202%22,%20%22Numero%22:%223105685003%22%20},%20%22NombreComercial%22:%22BurgerKing%22,%20%22Ubicacion%22:{%20%22Provincia%22:%221%22,%20%22Canton%22:%221%22,%20%22Distrito%22:%221%22,%20%22Barrio%22:%221%22,%20%22OtrasSenas%22:%22100%20sur%20de..%22%20},%20%22Telefono%22:{%20%22CodigoPais%22:%22506%22,%20%22NumTelefono%22:%2287654321%22%20}%20},%20%22CondicionVenta%22:%2201%22,%20%22MedioPago%22:1,%20%22DetalleServicio%22:{%20%22LineaDetalle%22:[%20{%20%22NumeroLinea%22:%221%22,%20%22Mercancia%22:1,%20%22Cantidad%22:%221%22,%20%22UnidadMedida%22:%22Sp%22,%20%22Detalle%22:%22Serv%20Prof%20%22,%20%22PrecioUnitario%22:%225.500%22,%20%22Impuesto%22:[%20{%20%22Codigo%22:%2201%22,%20%22Tarifa%22:%2213%22,%20%22Exoneracion%22:[{%20%22TipoDocumento%22:%2203%22,%20%22NumeroDocumento%22:%221201%22,%20%22NombreInstitucion%22:%22Esc.%20Figueres%20Ferrer%22,%20%22FechaEmision%22:%222018-07-15T06:45:08-06:00%22,%20%22PorcentajeCompra%22:50%20}]%20}%20]%20},%20{%20%22NumeroLinea%22:%222%22,%20%22Mercancia%22:1,%20%22Cantidad%22:%221%22,%20%22UnidadMedida%22:%22Sp%22,%20%22Detalle%22:%22Serv%20Prof%20%22,%20%22PrecioUnitario%22:%225.500%22,%20%22Impuesto%22:[%20{%20%22Codigo%22:%2201%22,%20%22Tarifa%22:%2213%22,%20%22Exoneracion%22:[{%20%22TipoDocumento%22:%2203%22,%20%22NumeroDocumento%22:%221201%22,%20%22NombreInstitucion%22:%22Esc.%20Figueres%20Ferrer%22,%20%22FechaEmision%22:%222018-07-15T06:45:08-06:00%22,%20%22PorcentajeCompra%22:100%20}]%20},%20{%20%22Codigo%22:%2202%22,%20%22Tarifa%22:%222%22,%20%22Exoneracion%22:[{%20%22TipoDocumento%22:%2203%22,%20%22NumeroDocumento%22:%221201%22,%20%22NombreInstitucion%22:%22Esc.%20Figueres%20Ferrer%22,%20%22FechaEmision%22:%222018-07-15T06:45:08-06:00%22,%20%22PorcentajeCompra%22:100%20}]%20}%20]%20},%20{%20%22NumeroLinea%22:%223%22,%20%22Mercancia%22:1,%20%22Cantidad%22:%221%22,%20%22UnidadMedida%22:%22Sp%22,%20%22Detalle%22:%22Serv%20Prof%20%22,%20%22PrecioUnitario%22:%225.500%22%20}%20]%20},%20%22ResumenFactura%22:{}%20}

http://localhost/fe/api.php?r=saveXML&data={%20%22Documento%22:{%22Tipo%22:%2201%22},%20%22Agencia%22:%22001%22,%20%22Terminal%22:%2200001%22,%20%22Emisor%22:{%20%22Identificacion%22:{%20%22Tipo%22:%2201%22,%20%22Numero%22:%22000114050239%22%20}},%20%22Receptor%22:{%20%22Nombre%22:%22ASDFASDF%22,%20%22Identificacion%22:{%20%22Tipo%22:%2202%22,%20%22Numero%22:%223105685003%22%20},%20%22NombreComercial%22:%22BurgerKing%22,%20%22Ubicacion%22:{%20%22Provincia%22:%221%22,%20%22Canton%22:%221%22,%20%22Distrito%22:%221%22,%20%22Barrio%22:%221%22,%20%22OtrasSenas%22:%22100%20sur%20de..%22%20},%20%22Telefono%22:{%20%22CodigoPais%22:%22506%22,%20%22NumTelefono%22:%2287654321%22%20}%20},%20%22CondicionVenta%22:%2201%22,%20%22MedioPago%22:1,%20%22DetalleServicio%22:{%20%22LineaDetalle%22:[%20{%20%22NumeroLinea%22:%221%22,%20%22Mercancia%22:1,%20%22Cantidad%22:%221%22,%20%22UnidadMedida%22:%22Sp%22,%20%22Detalle%22:%22Serv%20Prof%20%22,%20%22PrecioUnitario%22:%225.500%22,%20%22Impuesto%22:[%20{%20%22Codigo%22:%2201%22,%20%22Tarifa%22:%2213%22,%20%22Exoneracion%22:[{%20%22TipoDocumento%22:%2203%22,%20%22NumeroDocumento%22:%221201%22,%20%22NombreInstitucion%22:%22Esc.%20Figueres%20Ferrer%22,%20%22FechaEmision%22:%222018-07-15T06:45:08-06:00%22,%20%22PorcentajeCompra%22:50%20}]%20}%20]%20},%20{%20%22NumeroLinea%22:%222%22,%20%22Mercancia%22:1,%20%22Cantidad%22:%221%22,%20%22UnidadMedida%22:%22Sp%22,%20%22Detalle%22:%22Serv%20Prof%20%22,%20%22PrecioUnitario%22:%225.500%22,%20%22Impuesto%22:[%20{%20%22Codigo%22:%2201%22,%20%22Tarifa%22:%2213%22,%20%22Exoneracion%22:[{%20%22TipoDocumento%22:%2203%22,%20%22NumeroDocumento%22:%221201%22,%20%22NombreInstitucion%22:%22Esc.%20Figueres%20Ferrer%22,%20%22FechaEmision%22:%222018-07-15T06:45:08-06:00%22,%20%22PorcentajeCompra%22:100%20}]%20},%20{%20%22Codigo%22:%2202%22,%20%22Tarifa%22:%222%22,%20%22Exoneracion%22:[{%20%22TipoDocumento%22:%2203%22,%20%22NumeroDocumento%22:%221201%22,%20%22NombreInstitucion%22:%22Esc.%20Figueres%20Ferrer%22,%20%22FechaEmision%22:%222018-07-15T06:45:08-06:00%22,%20%22PorcentajeCompra%22:100%20}]%20}%20]%20},%20{%20%22NumeroLinea%22:%223%22,%20%22Mercancia%22:1,%20%22Cantidad%22:%221%22,%20%22UnidadMedida%22:%22Sp%22,%20%22Detalle%22:%22Serv%20Prof%20%22,%20%22PrecioUnitario%22:%225.500%22%20}%20]%20},%20%22ResumenFactura%22:{}%20}






###los campos que el servicio calcula son:
* MontoTotal
* SubTotal
* Impuesto.Monto
* ResumenFactura.TotalMercanciasGravadas
* ResumenFactura.TotalServGravados
* ResumenFactura.TotalMercanciasExentas
* ResumenFactura.TotalServExentos
* ResumenFactura.TotalGravado
* ResumenFactura.TotalExento
* ResumenFactura.TotalVenta
* ResumenFactura.TotalDescuentos
* ResumenFactura.TotalImpuesto
* ResumenFactura.TotalComprobante
* Normativa.NumeroResolucion
* Normativa.FechaResolucion

