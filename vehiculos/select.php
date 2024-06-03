<?php 
include('../conexion_bd.php');

$sql = "SELECT * FROM Vehiculos";
$query = mysqli_query($con, $sql);
$data = array();

while($row = mysqli_fetch_assoc($query)) {
    $data[] = array(
        'id_vehiculo' => $row['id_vehiculo'],
        'modelo' => $row['modelo']
    );
}

echo json_encode($data);
?>