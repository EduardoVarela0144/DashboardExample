<?php include('conexion_bd.php'); ?>
<!doctype html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="css/bootstrap5.0.1.min.css" rel="stylesheet" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="css/datatables-1.10.25.min.css" />
    <link rel="stylesheet" type="text/css" href="css/Header.css" />
    <title>Control de pagos</title>
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
        <p class="datatable design text-center">Control de pagos</p>

        <div class="row">
            <div class="container">
                <div class="btnAdd">
                    <a href="#!" data-id="" data-bs-toggle="modal" data-bs-target="#addUserModal"
                        class="btn btn-success btn-sm">Agregar pago</a>
                </div>

                <div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md-8">
                        <table id="example" class="table">
                            <thead>
                                <th>Id</th>
                                <th>Id detalle servicio</th>
                                <th>Id cliente</th>
                                <th>Fecha</th>
                                <th>Monto</th>
                                <th>Metodo de pago</th>
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
    $(document).ready(function() {

        $.ajax({
            url: 'detalle_servicio/select.php',
            type: 'get',
            dataType: 'json',
            success: function(response) {
                var len = response.length;
                console.log(response)
                $("#id_detalleservicio").empty();

                $("#id_detalleservicio").append(
                    "<option value=''>Seleccione un detalle de servicio</option>")
                for (var i = 0; i < len; i++) {
                    var id = response[i]['id_detalleservicio'];
                    var nombre = response[i]['id_detalleservicio'];
                    $("#id_detalleservicio").append("<option value='" + id + "'>" + nombre +
                        "</option>");
                }
            }
        });


        $.ajax({
            url: 'clientes/select.php',
            type: 'get',
            dataType: 'json',
            success: function(response) {
                console.log(response);
                var len = response.length;
                $("#id_cliente").empty();
                $("#id_cliente").append("<option value=''>Seleccione un cliente</option>");
                for (var i = 0; i < len; i++) {
                    var id = response[i]['id_cliente'];
                    var nombre = response[i]['nombre'];
                    $("#id_cliente").append("<option value='" + id + "'>" + nombre +
                        "</option>");
                }
            }
        });

        $('#example').DataTable({
            "fnCreatedRow": function(nRow, aData, iDataIndex) {
                $(nRow).attr('id', aData[0]);
            },
            'serverSide': 'true',
            'processing': 'true',
            'paging': 'true',
            'order': [],
            'ajax': {
                'url': 'pagos/listar_pagos.php',
                'type': 'post',
            },
            "aoColumnDefs": [{
                "bSortable": false,
                "aTargets": [4]
            }, ],
            'searching': false,
            'lengthChange': false,
        });
    });

    $(document).on('submit', '#addCliente', function(e) {
        e.preventDefault();

        var ID_DetalleServicio = $('#id_detalleservicio').val();
        var ID_Cliente = $('#id_cliente').val();
        var Fecha_Pago = $('#fecha_pago').val();
        var Monto = $('#monto').val();
        var Metodo_Pago = $('#metodo_pago').val();

        if (
            ID_DetalleServicio != '' && ID_Cliente != '' && Fecha_Pago != '' && Monto != '' && Metodo_Pago !=
            ''
        ) {
            $.ajax({
                url: "pagos/agregar_pago.php",
                type: "post",
                data: {
                    id_detalleservicio: ID_DetalleServicio,
                    id_cliente: ID_Cliente,
                    fecha_pago: Fecha_Pago,
                    monto: Monto,
                    metodo_pago: Metodo_Pago
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
                    <h5 class="modal-title" id="exampleModalLabel">Agregar Pago</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addCliente" action="">
                        <div class="mb-3">
                            <label for="id_detalleservicio" class="form-label">ID del detalle servicio</label>
                            <select class="form-control" id="id_detalleservicio">
                            </select>

                        </div>

                        <div class="mb-3">
                            <label for="id_detalleservicio" class="form-label">Cliente</label>

                            <select class="form-control" id="id_cliente">
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="fecha_pago" class="form-label">Fecha de Pago</label>
                            <input type="date" class="form-control" id="fecha_pago" name="fecha_pago" required>
                        </div>
                        <div class="mb-3">
                            <label for="monto" class="form-label">Monto</label>
                            <input type="number" step="0.01" class="form-control" id="monto" name="monto" required>
                        </div>
                        <div class="mb-3">
                            <label for="metodo_pago" class="form-label">Método de Pago</label>
                            <select class="form-control" id="metodo_pago" name="metodo_pago">
                                >
                                <option value="">Seleccione un método de pago</option>
                                <option value="Efectivo">Efectivo</option>
                                <option value="Tarjeta">Tarjeta</option>
                                <option value="Transferencia">Transferencia</option>
                            </select>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
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