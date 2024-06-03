<?php 
include('../conexion_bd.php');

$sql = "SELECT * FROM Servicios";
$query = mysqli_query($con, $sql);
$data = array();

while($row = mysqli_fetch_assoc($query)) {
    $data[] = array(
        'id_servicio' => $row['id_servicio'],
        'nombre_servicio' => $row['nombre_servicio']
    );
}

echo json_encode($data);
?>