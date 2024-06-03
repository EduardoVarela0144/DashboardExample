<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="css/bootstrap5.0.1.min.css" rel="stylesheet" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="css/datatables-1.10.25.min.css" />
    <link rel="stylesheet" type="text/css" href="css/Header.css" />
    <title>Control de detalles servicio</title>
    <style type="text/css">
    .btnAdd {
        text-align: right;
        width: 83%;
        margin-bottom: 20px;
    }
    </style>
</head>

<body>
    <div class="header">
        <a href="index.php" class="logo">Ordinario</a>
        <div class="header-right">
            <a href="index.php">Clientes</a>
            <a href="detalle_servicio.php">Detalle Servicio</a>
            <a href="pagos.php">Pagos</a>
            <a href="servicios.php">Servicios</a>
            <a href="vehiculos.php">Vehículos</a>
        </div>
    </div>
    <div class="container-fluid">
        <h2 class="text-center">Bienvenido</h2>
        <p class="datatable design text-center">Control de detalle servicio</p>
        <div class="row">
            <div class="container">
                <div class="btnAdd">
                    <a href="#!" data-id="" data-bs-toggle="modal" data-bs-target="#addUserModal"
                        class="btn btn-success btn-sm">Agregar Detalle Servicio</a>
                </div>
                <div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md-8">
                        <table id="example" class="table">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Servicio</th>
                                    <th>Vehículo</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-2"></div>
                </div>
            </div>
        </div>
    </div>

    <script src="js/jquery-3.6.0.min.js" crossorigin="anonymous"></script>
    <script src="js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script type="text/javascript" src="js/dt-1.10.25datatables.min.js"></script>

    <script type="text/javascript">
    $.ajax({
        url: 'servicios/select.php',
        type: 'get',
        dataType: 'json',
        success: function(response) {
            console.log(response);
            var len = response.length;
            $("#id_servicio").empty(); 
            $("#id_servicio").append("<option value=''>Seleccione un servicio</option>");
            for (var i = 0; i < len; i++) {
                var id = response[i]['id_servicio'];
                var nombre = response[i]['nombre_servicio'];
                $("#id_servicio").append("<option value='" + id + "'>" + nombre +
                    "</option>");
            }
        }
    });

    $.ajax({
        url: 'vehiculos/select.php',
        type: 'get',
        dataType: 'json',
        success: function(response) {
            console.log(response);
            var len = response.length;
            $("#id_vehiculo").empty(); 
            $("#id_vehiculo").append("<option value=''>Seleccione un vehículo</option>");
            for (var i = 0; i < len; i++) {
                var id = response[i]['id_vehiculo'];
                var nombre = response[i]['modelo'];
                $("#id_vehiculo").append("<option value='" + id + "'>" + nombre +
                    "</option>"); 
            }
        }
    });

    $(document).ready(function() {
        $('#example').DataTable({
            "fnCreatedRow": function(nRow, aData, iDataIndex) {
                $(nRow).attr('id', aData[0]);
            },
            'serverSide': 'true',
            'processing': 'true',
            'paging': 'true',
            'order': [],
            'ajax': {
                'url': 'detalle_servicio/listar_detalle_servicio.php',
                'type': 'post',
            },
            "aoColumnDefs": [{
                "bSortable": false,
                "aTargets": [3]
            }],
            'searching': false,
            'lengthChange': false,
        });
    });

    $(document).on('submit', '#addCliente', function(e) {
        e.preventDefault();

        var id_servicio = $('#id_servicio').val();
        var id_vehiculo = $('#id_vehiculo').val();
        var subtotal = $('#subtotal').val();


        if (
            id_servicio != '' &&
            id_vehiculo != '' &&
            subtotal != ''
        ) {
            $.ajax({
                url: "detalle_servicio/agregar_detalle_servicio.php",
                type: "post",
                data: {

                    id_servicio: id_servicio,
                    id_vehiculo: id_vehiculo,
                    subtotal: subtotal,
                },
                success: function(data) {
                    var json = JSON.parse(data);
                    var status = json.status;
                    if (status == 'true') {
                        mytable = $('#example').DataTable();
                        mytable.draw();
                        $('#addUserModal').modal('hide');
                    } else {
                        alert('failed');
                    }
                }
            });
        } else {
            alert('Fill all the required fields');
        }
    });
    </script>

    <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Agregar Detalle Servicio</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addCliente" action="">



                        <div class="mb-3 row">
                            <label for="id_vehiculo" class="col-md-3 form-label">Vehículo</label>
                            <div class="col-md-9">
                                <select class="form-control" id="id_vehiculo">
                                </select>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="id_servicio" class="col-md-3 form-label">Servicio</label>
                            <div class="col-md-9">
                                <select class="form-control" id="id_servicio">
                                </select>
                            </div>
                        </div>


                        <div class="mb-3 row">
                            <label for="subtotal" class="col-md-3 form-label
                                ">Subtotal</label>
                            <div class="col-md-9">
                                <input type="number" class="form-control" id="subtotal" name="subtotal">

                            </div>
                        </div>


                        <div class="row">
                            <div class="col-md-3"></div>
                            <div class="col-md-9 ">
                                <button type="submit" class="btn btn-primary w-100">Agregar</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

</body>

</html>
<script type="text/javascript">
</script>