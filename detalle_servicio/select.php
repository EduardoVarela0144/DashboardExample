<?php 
include('../conexion_bd.php');

$sql = "SELECT * FROM DetalleServicio";
$query = mysqli_query($con, $sql);
$data = array();

while($row = mysqli_fetch_assoc($query)) {
    $data[] = array(
        'id_detalleservicio' => $row['id_detalleservicio'],
    );
}
echo json_encode($data);
?>