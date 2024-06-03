<?php
include('../conexion_bd.php');

$output = array();
$sql = "SELECT Pagos.*, Clientes.nombre AS nombre_cliente 
        FROM Pagos 
        LEFT JOIN Clientes ON Pagos.id_cliente = Clientes.id_cliente";

$totalQuery = mysqli_query($con, $sql);
$total_all_rows = mysqli_num_rows($totalQuery);

$columns = array(
    0 => 'id_pago',
    1 => 'id_detalleservicio',
    2 => 'nombre_cliente',
    3 => 'fecha_pago',
    4 => 'monto',
    5 => 'metodo_pago',
);

if (isset($_POST['search']['value'])) {
    $search_value = $_POST['search']['value'];
    $sql .= " WHERE id_pago LIKE '%$search_value%'
                OR id_detalleservicio LIKE '%$search_value%'
                OR Pagos.id_cliente LIKE '%$search_value%'
                OR fecha_pago LIKE '%$search_value%'
                OR monto LIKE '%$search_value%'
                OR metodo_pago LIKE '%$search_value%'
                OR Clientes.nombre LIKE '%$search_value%'";
}

if (isset($_POST['order'])) {
    $column_name = $columns[$_POST['order'][0]['column']];
    $order = $_POST['order'][0]['dir'];
    $sql .= " ORDER BY $column_name $order";
} else {
    $sql .= " ORDER BY id_pago DESC";
}

if ($_POST['length'] != -1) {
    $start = $_POST['start'];
    $length = $_POST['length'];
    $sql .= " LIMIT $start, $length";
}

$query = mysqli_query($con, $sql);
$count_rows = mysqli_num_rows($query);

$data = array();
while ($row = mysqli_fetch_assoc($query)) {
    $sub_array = array();
    $sub_array[] = $row['id_pago'];
    $sub_array[] = $row['id_detalleservicio'];
    $sub_array[] = $row['nombre_cliente'];
    $sub_array[] = $row['fecha_pago'];
    $sub_array[] = $row['monto'];
    $sub_array[] = $row['metodo_pago'];
    $data[] = $sub_array;
}

$output = array(
    'draw' => intval($_POST['draw']),
    'recordsTotal' => $total_all_rows,
    'recordsFiltered' => $count_rows,
    'data' => $data
);

echo json_encode($output);
?>