<?php 
include('../conexion_bd.php');

$output = array();
$sql = "SELECT DetalleServicio.*, Vehiculos.modelo AS modelo, Servicios.nombre_servicio AS nombre_servicio 
        FROM DetalleServicio 
        LEFT JOIN Vehiculos ON DetalleServicio.id_vehiculo = Vehiculos.id_vehiculo
        LEFT JOIN Servicios ON DetalleServicio.id_servicio = Servicios.id_servicio";

$totalQuery = mysqli_query($con, $sql);
$total_all_rows = mysqli_num_rows($totalQuery);

$columns = array(
    0 => 'id_detalleservicio',
    1 => 'nombre_servicio',
    2 => 'modelo',
    3 => 'subtotal',
    4 => 'nombre_servicio',
);

$search_value = '';
$order_clause = ' ORDER BY id_detalleservicio DESC';

if(isset($_POST['search']['value']) && $_POST['search']['value'] != '')
{
    $search_value = $_POST['search']['value'];
    $sql .= " WHERE id_detalleservicio LIKE '%" . $search_value . "%'";
    $sql .= " OR DetalleServicio.id_servicio LIKE '%" . $search_value . "%'";
    $sql .= " OR Vehiculos.modelo LIKE '%" . $search_value . "%'";
    $sql .= " OR subtotal LIKE '%" . $search_value . "%'";
    $sql .= " OR Servicios.nombre_servicio LIKE '%" . $search_value . "%'";
}

if(isset($_POST['order']))
{
    $column_name = $columns[$_POST['order'][0]['column']];
    $order = $_POST['order'][0]['dir'];
    $order_clause = " ORDER BY " . $column_name . " " . $order;
}

$sql .= $order_clause;

$filteredQuery = mysqli_query($con, $sql);
$total_filtered_rows = mysqli_num_rows($filteredQuery);

if($_POST['length'] != -1)
{
    $start = $_POST['start'];
    $length = $_POST['length'];
    $sql .= " LIMIT " . $start . ", " . $length;
}   

$query = mysqli_query($con, $sql);
$data = array();
while($row = mysqli_fetch_assoc($query))
{
    $sub_array = array();
    $sub_array[] = $row['id_detalleservicio'];
    $sub_array[] = $row['nombre_servicio'];
    $sub_array[] = $row['modelo'];
    $sub_array[] = $row['subtotal'];
    $sub_array[] = $row['nombre_servicio'];
    $data[] = $sub_array;
}

$output = array(
    'draw' => intval($_POST['draw']),
    'recordsTotal' => $total_all_rows,
    'recordsFiltered' => $total_filtered_rows,
    'data' => $data,
);

echo json_encode($output);
?>