<?php
include("../../bd.php");
if (isset($_GET['txtID'])) {
    $txtID=(isset($_GET['txtID']))?$_GET['txtID']:"";

    $sentencia=$conexion->prepare("SELECT *, (SELECT nombredelpuesto 
    FROM tbl_puestos 
    WHERE tbl_puestos.id = tbl_empleados.idpuesto limit 1) as puesto
    FROM tbl_empleados WHERE id=:id");
    $sentencia->bindParam(":id", $txtID);
    $sentencia->execute();
    $registro=$sentencia->fetch (PDO::FETCH_LAZY);

    //print_r($registro);

    $primernombre=$registro["primernombre"];
    $segundonombre=$registro["segundonombre"];
    $primerapellido=$registro["primerapellido"];
    $segundoapellido=$registro["segundoapellido"];

    $nombreCompleto=$primernombre." ".$segundonombre." ".$primerapellido." ".$segundoapellido;
   
    $foto=$registro["foto"];
    $cv=$registro["cv"];
    $idpuesto=$registro["idpuesto"];
    $puesto=$registro["puesto"];
    
    $fechadeingreso=$registro["fechadeingreso"];

    $fechaInicio = new DateTime($fechadeingreso);
    $fechaFin = new DateTime(date('Y-m-d'));
    $diferencia = date_diff($fechaInicio,$fechaFin);   
}
ob_start(); // todo lo que mostrara de aca, se recolectara y se almacenará 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carta de recomendacion</title>
</head>
<body>
    <h1>Carta de recomendacion Laboral</h1>
    <br/><br/>
    La Paz Bolivia <strong> <?php echo date ('d-m-Y')?> </strong>
    <br/><br/>
    A quien le puede interesar:
    <br/><br/>
    Reciba un cordial saludo
    <br/><br/>
    a través de estas lineas deseo hacer de su conocimiento que Sr (a) <strong><?php echo $nombreCompleto;?></strong>
    quien laboró en mi organizacion durante <strong> <?php echo $diferencia->y;?> año(s) </strong>
    es un ciudadano con conducta intachable. Ha demostrado ser un gran trabajador,
    comprometido, responsable y fiel cumplidor de tareas.
    Siempre ha manisfestado preocupacion por mejorar, capacitarse y actualizar sus conocimiento.
    <br/><br/>
    se ah desempeñado como: <strong><?php echo $puesto;?></strong>
    <br/><br/>
    sin mas que decir, y esperando su consideracion me despido 
    
    <br/><br/>
    _______________________________
    <br/><br/>
    atentamente,
    <br/>
    Ing. Jorge Lezano

</body>
</html>

<?php
$HTML = ob_get_clean();

require_once ("../../libs/autoload.inc.php");
use Dompdf\Dompdf;
$dompdf = new Dompdf();

$opciones = $dompdf->getOptions();
$opciones-> set(array("isRemoteEnabled"=>true));

$dompdf->setOptions($opciones);

$dompdf->loadHTML($HTML);

$dompdf->setPaper('letter');
$dompdf->render();
$dompdf->stream("archivo.pdf",array("Attachment"=>false));



?>