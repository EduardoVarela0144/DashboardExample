<?php 
include('../conexion_bd.php');

$sql = "SELECT * FROM Clientes";
$query = mysqli_query($con, $sql);
$data = array();

while($row = mysqli_fetch_assoc($query)) {
    $data[] = array(
        'id_cliente' => $row['id_cliente'],
        'nombre' => $row['nombre']
    );
}

echo json_encode($data);
?>