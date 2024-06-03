<?php 
include('../conexion_bd.php');

$output= array();
$sql = "SELECT * FROM Clientes";

$totalQuery = mysqli_query($con,$sql);
$total_all_rows = mysqli_num_rows($totalQuery);

$columns = array(
    0 => 'id_cliente',
    1 => 'nombre',
    2 => 'apellido',
    3 => 'correo',
    4 => 'direccion',
    5 => 'telefono'
);

if(isset($_POST['search']['value']))
{
    $search_value = $_POST['search']['value'];
    $sql .= " WHERE id_cliente like '%".$search_value."%'";
    $sql .= " OR nombre like '%".$search_value."%'";
    $sql .= " OR apellido like '%".$search_value."%'";
    $sql .= " OR correo like '%".$search_value."%'";
    $sql .= " OR direccion like '%".$search_value."%'";
    $sql .= " OR telefono like '%".$search_value."%'";
}

if(isset($_POST['order']))
{
    $column_name = $_POST['order'][0]['column'];
    $order = $_POST['order'][0]['dir'];
    $sql .= " ORDER BY ".$columns[$column_name]." ".$order."";
}
else
{
    $sql .= " ORDER BY id_cliente desc";
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
    $sub_array[] = $row['id_cliente'];
    $sub_array[] = $row['nombre'];
    $sub_array[] = $row['apellido'];
    $sub_array[] = $row['correo'];
    $sub_array[] = $row['direccion'];
    $sub_array[] = $row['telefono'];
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