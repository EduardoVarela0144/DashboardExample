<?php
include('../conexion_bd.php');

$output = array();
$sql = "SELECT Vehiculos.*, Clientes.nombre AS nombre_cliente FROM Vehiculos 
        LEFT JOIN Clientes ON Vehiculos.id_cliente = Clientes.id_cliente";

// Conteo total de registros
$totalQuery = mysqli_query($con, $sql);
$total_all_rows = mysqli_num_rows($totalQuery);

$columns = array(
    0 => 'id_vehiculo',
    1 => 'nombre_cliente',  // Nombre del cliente en lugar de ID
    2 => 'marca',
    3 => 'modelo',
    4 => 'ano',
    5 => 'matricula'
);

if (isset($_POST['search']['value'])) {
    // Filtro de búsqueda
    $search_value = $_POST['search']['value'];
    $sql .= " WHERE Vehiculos.id_vehiculo LIKE '%$search_value%'
                OR Clientes.nombre LIKE '%$search_value%'
                OR Vehiculos.marca LIKE '%$search_value%'
                OR Vehiculos.modelo LIKE '%$search_value%'
                OR Vehiculos.ano LIKE '%$search_value%'
                OR Vehiculos.matricula LIKE '%$search_value%'";
}

if (isset($_POST['order'])) {
    // Ordenar resultados
    $column_name = $_POST['order'][0]['column'];
    $order = $_POST['order'][0]['dir'];
    $sql .= " ORDER BY ".$columns[$column_name]." ".$order;
} else {
    // Ordenar por defecto
    $sql .= " ORDER BY Vehiculos.id_vehiculo DESC";
}

if ($_POST['length'] != -1) {
    // Paginación
    $start = $_POST['start'];
    $length = $_POST['length'];
    $sql .= " LIMIT $start, $length";
}

$query = mysqli_query($con, $sql);
$count_rows = mysqli_num_rows($query);

$data = array();
while ($row = mysqli_fetch_assoc($query)) {
    $sub_array = array();
    $sub_array[] = $row['id_vehiculo'];
    $sub_array[] = $row['nombre_cliente'];  
    $sub_array[] = $row['marca'];
    $sub_array[] = $row['modelo'];
    $sub_array[] = $row['ano'];
    $sub_array[] = $row['matricula'];
    $data[] = $sub_array;
}

$output = array(
    'draw' => intval($_POST['draw']),
    'recordsTotal' => $total_all_rows,
    'recordsFiltered' => $total_all_rows,
    'data' => $data
);

echo json_encode($output);
?>
