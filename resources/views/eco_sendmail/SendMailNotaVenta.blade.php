<html>
  <head>
<style type="text/css">
body{
    font-family: 'Source Sans Pro',sans-serif;
    font-size: 10px;
}
</style>
</head>
        <body>
        <h5><?=$id_correo?></h5>
        <table style="font-size: 10px; border-collapse: collapse; width: 600px" border="1" >
            <tr>
                <td>PEDIDO WEB</td>
                <td>NV SOFTLAND</td>
                <td>COND VTA</td>
                <td>COND PAGO</td>
                <td>COBRADOR</td>
                <td>CLIENTE</td>
                <td>NOMBRE</td>
                <td>NETO</td>
                <td>NETO+IVA</td>
            </tr>
            <tr>
                <td><?=$tabla_1[0]->pedido?></td>
                <td><?=$tabla_1[0]->nvnumero?></td>
                <td><?=$tabla_1[0]->condventa?></td>
                <td><?=$tabla_1[0]->condpago?></td>
                <td><?=$tabla_1[0]->cobrador?></td>
                <td><?=$tabla_1[0]->rut?></td>
                <td><?=$tabla_1[0]->nombre?></td>
                <td><?=$tabla_1[0]->pventa?></td>
                <td><?=$tabla_1[0]->subtotal?></td>
            </tr>
        </table>
        <br>
        <table style="font-size: 10px; border-collapse: collapse; width: 600px" border="1" >
            <tr>
                <td>OBSERVACIONES</td>
            </tr>
            <tr>
                <td><?=$tabla_1[0]->observaciones?></td>
            </tr>
        </table>
        <br>
        <table style="font-size: 10px; border-collapse: collapse; width: 600px" border="1" >
            <tr>
                <td>DIRECCION</td>
                <td>COMUNA</td>
                <td>REGION</td>
            </tr>
            <tr>
                <td><?=$tabla_2[0]->direccion?></td>
                <td><?=$tabla_2[0]->comuna?></td>
                <td><?=$tabla_2[0]->region?></td>
            </tr>
        </table>
        <br>    
        <table style="font-size: 10px; border-collapse: collapse; width: 600px" border="1" >
            <tr>
                <td>PEDIDO WEB</td>
                <td>NV SOFTLAND</td>
                <td>FAMILIA</td>
                <td>CODIGO</td>
                <td>DESCRIPCION</td>
                <td>CANTIDAD</td>
                <td>P.VENTA</td>
                <td>SUBTOTAL</td>
            </tr>
            <?php
                for($i=0; $i<count($tabla_3); $i++)
                {
                   ?>
                    <tr>
                        <td><?=$tabla_3[$i]->web?></td>
                        <td><?=$tabla_3[$i]->nvnumero?></td>
                        <td><?=$tabla_3[$i]->grupo?></td>
                        <td><?=$tabla_3[$i]->codprod?></td>
                        <td><?=$tabla_3[$i]->desprod?></td>
                        <td><?=$tabla_3[$i]->cantidad?></td>
                        <td><?=$tabla_3[$i]->pventa?></td>
                        <td><?=$tabla_3[$i]->subtotal?></td>
                    </tr>
                    <?php
                }
            ?>
        </table>            
        </body>
</html>
