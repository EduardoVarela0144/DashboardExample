<?php include('conexion_bd.php'); ?>
<!doctype html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="css/bootstrap5.0.1.min.css" rel="stylesheet" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="css/datatables-1.10.25.min.css" />
    <link rel="stylesheet" type="text/css" href="css/Header.css" />
    <title>Control de clientes</title>
    <style type="text/css">
    .btnAdd {
        text-align: right;
        width: 83%;
        margin-bottom: 20px;
    }
    </style>
</head>

<body class="pb-4">
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
        <p class="datatable design text-center">Control de clientes</p>

        <div class="row">
            <div class="container">
                <div class="btnAdd">
                    <a href="#!" data-id="" data-bs-toggle="modal" data-bs-target="#addUserModal"
                        class="btn btn-success btn-sm">Agregar Cliente</a>
                </div>

                <div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md-8">
                        <table id="example" class="table">
                            <thead>
                                <th>Id</th>
                                <th>Nombre</th>
                                <th>Apellido</th>
                                <th>Correo</th>
                                <th>Dirección</th>
                                <th>Teléfono</th>
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
        $('#example').DataTable({
            "fnCreatedRow": function(nRow, aData, iDataIndex) {
                $(nRow).attr('id', aData[0]);
            },
            'serverSide': 'true',
            'processing': 'true',
            'paging': 'true',
            'order': [],
            'ajax': {
                'url': 'clientes/listar_clientes.php',
                'type': 'post',
            },
            "dataSrc": function(json) {
                    console.log("hola", json); // Esto debería imprimir el JSON en la consola
                    return json.data;
                },
            "aoColumnDefs": [{
                "bSortable": false,
                "aTargets": [4]
            }, ],
        });
    });



    $(document).on('submit', '#addCliente', function(e) {
        e.preventDefault();

        var Nombre = $('#nombre').val();
        var Apellido = $('#apellido').val();
        var Correo = $('#correo').val();
        var Direccion = $('#direccion').val();
        var Telefono = $('#telefono').val();

        if (
            Nombre != '' &&
            Apellido != '' &&
            Correo != '' &&
            Direccion != '' &&
            Telefono != ''
        ) {
            $.ajax({
                url: "clientes/agregar_cliente.php",
                type: "post",
                data: {
                    nombre: Nombre,
                    apellido: Apellido,
                    correo: Correo,
                    direccion: Direccion,
                    telefono: Telefono
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

    <!-- Agregar Usuario Modal -->
    <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Agregar Cliente</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addCliente" action="">
                        <div class="mb-3 row">
                            <label for="nombre" class="col-md-3 form-label">Nombre</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" id="nombre" name="nombre">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="apellido" class="col-md-3 form-label">Apellido</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" id="apellido" name="apellido">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="correo" class="col-md-3 form-label">Correo</label>
                            <div class="col-md-9">
                                <input type="email" class="form-control" id="correo" name="correo">
                            </div>

                        </div>

                        <div class="mb-3 row">
                            <label for="direccion" class="col-md-3 form-label">Dirección</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" id="direccion" name="direccion">
                            </div>

                        </div>
                        <div class="mb-3 row">
                            <label for="telefono" class="col-md-3 form-label">Teléfono</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" id="telefono" name="telefono">
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