<?php 
include('../conexion_bd.php');

$id_servicio = $_POST['id_servicio'];
$id_vehiculo = $_POST['id_vehiculo'];
$subtotal = $_POST['subtotal'];

$sql = "INSERT INTO `DetalleServicio` (`id_servicio`, `id_vehiculo`, `subtotal`) 
        VALUES ('$id_servicio', '$id_vehiculo', '$subtotal')";
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