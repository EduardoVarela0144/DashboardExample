<?php 
include('../conexion_bd.php');

$nombre_servicio = $_POST['nombre_servicio'];
$descripcion = $_POST['descripcion'];
$precio = $_POST['precio'];
$duracion_estimada = $_POST['duracion_estimada'];

$sql = "INSERT INTO `Servicios` (`nombre_servicio`, `descripcion`, `precio`, `duracion_estimada`) 
        VALUES ('$nombre_servicio', '$descripcion', '$precio', '$duracion_estimada')";
$query = mysqli_query($con, $sql);
$lastId = mysqli_insert_id($con);

if ($query) {
    $data = array(
        'status' => 'true',
        'lastId' => $lastId
    );
    echo json_encode($data);
} else {
    $data = array(
        'status' => 'false',
        'error' => mysqli_error($con)
    );
    echo json_encode($data);
}
?>