<?php 
include('../conexion_bd.php');

$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$correo = $_POST['correo'];
$direccion = $_POST['direccion'];
$telefono = $_POST['telefono'];

$sql = "INSERT INTO `Clientes` (`nombre`, `apellido`, `correo`, `direccion`, `telefono`) VALUES ('$nombre', '$apellido', '$correo', '$direccion', '$telefono')";
$query = mysqli_query($con, $sql);

$lastId = mysqli_insert_id($con);

if ($query == true) {
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