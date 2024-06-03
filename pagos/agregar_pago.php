<?php 
include('../conexion_bd.php');

$id_detalleservicio = $_POST['id_detalleservicio'];
$id_cliente = $_POST['id_cliente'];
$fecha_pago = $_POST['fecha_pago'];
$monto = $_POST['monto'];
$metodo_pago = $_POST['metodo_pago'];

$sql = "INSERT INTO `Pagos` (`id_detalleservicio`, `id_cliente`, `fecha_pago`, `monto`, `metodo_pago`) VALUES ('$id_detalleservicio', '$id_cliente', '$fecha_pago', '$monto', '$metodo_pago')";
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