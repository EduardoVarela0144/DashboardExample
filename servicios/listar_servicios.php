<?php 
include('../conexion_bd.php');

$output= array();
$sql = "SELECT * FROM Servicios";

$totalQuery = mysqli_query($con,$sql);
$total_all_rows = mysqli_num_rows($totalQuery);

$columns = array(
    0 => 'id_servicio',
    1 => 'nombre_servicio',
    2 => 'descripcion',
    3 => 'precio',
    4 => 'duracion_estimada'
);

if(isset($_POST['search']['value']))
{
    $search_value = $_POST['search']['value'];
    $sql .= " WHERE id_servicio like '%".$search_value."%'";
    $sql .= " OR nombre_servicio like '%".$search_value."%'";
    $sql .= " OR descripcion like '%".$search_value."%'";
    $sql .= " OR precio like '%".$search_value."%'";
    $sql .= " OR duracion_estimada like '%".$search_value."%'";
}

if(isset($_POST['order']))
{
    $column_name = $_POST['order'][0]['column'];
    $order = $_POST['order'][0]['dir'];
    $sql .= " ORDER BY ".$columns[$column_name]." ".$order."";
}
else
{
    $sql .= " ORDER BY id_servicio desc";
}

if($_POST['length'] != -1)
{
    $start = $_POST['start'];
    $length = $_POST['length'];
    $sql .= " LIMIT  ".$start.", ".$length;
}   

$query = mysqli_query($con,$sql);
$count_rows = mysqli_num_rows($query);
$data = array();
while($row = mysqli_fetch_assoc($query))
{
    $sub_array = array();
    $sub_array[] = $row['id_servicio'];
    $sub_array[] = $row['nombre_servicio'];
    $sub_array[] = $row['descripcion'];
    $sub_array[] = $row['precio'];
    $sub_array[] = $row['duracion_estimada'];
    $data[] = $sub_array;
}

$output = array(
    'draw'=> intval($_POST['draw']),
    'recordsTotal' =>$count_rows ,
    'recordsFiltered'=>   $total_all_rows,
    'data'=>$data,
);
echo  json_encode($output);
?>
