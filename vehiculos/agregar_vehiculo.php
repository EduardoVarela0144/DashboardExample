<?php 
include('../conexion_bd.php');

$id_cliente = $_POST['id_cliente'];
$marca = $_POST['marca'];
$modelo = $_POST['modelo'];
$ano = $_POST['ano'];
$matricula = $_POST['matricula'];

$sql = "INSERT INTO `Vehiculos` (`id_cliente`, `marca`, `modelo`, `ano`, `matricula`) 
        VALUES ('$id_cliente', '$marca', '$modelo', '$ano', '$matricula')";
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