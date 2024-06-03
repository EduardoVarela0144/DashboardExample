<?php include('conexion_bd.php'); ?>
<!doctype html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="css/bootstrap5.0.1.min.css" rel="stylesheet" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="css/datatables-1.10.25.min.css" />
    <link rel="stylesheet" type="text/css" href="css/Header.css" />
    <title>Control de servicios</title>
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
        <p class="datatable design text-center">Control de servicios</p>

        <div class="row">
            <div class="container">
                <div class="btnAdd">
                    <a href="#!" data-id="" data-bs-toggle="modal" data-bs-target="#addUserModal"
                        class="btn btn-success btn-sm">Agregar Servicio</a>
                </div>

                <div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md-8">
                        <table id="example" class="table">
                            <thead>
                                <th>Id</th>
                                <th>Nombre</th>
                                <th>Descripción</th>
                                <th>Precio</th>
                                <th>Duracion</th>
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
                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url": "servicios/listar_servicios.php",
                    "type": "POST"
                },
                "order": [
                    [0, "desc"]
                ],
                "paging": true,
                "searching": true,
                "lengthChange": true
            });
    });


    $(document).on('submit', '#addCliente', function(e) {
        e.preventDefault();

        var nombre_servicio = $('#nombre_servicio').val();
        var descripcion = $('#descripcion').val();
        var precio = $('#precio').val();
        var duracion_estimada = $('#duracion_estimada').val();

        if (
            nombre_servicio != '' &&
            descripcion != '' &&
            precio != '' &&
            duracion_estimada != ''
        ) {
            $.ajax({
                url: "servicios/agregar_servicio.php",
                type: "post",
                data: {
                    nombre_servicio: nombre_servicio,
                    descripcion: descripcion,
                    precio: precio,
                    duracion_estimada: duracion_estimada
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
                    <h5 class="modal-title" id="exampleModalLabel">Agregar Servicio</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addCliente" action="">


                        <div class="mb-3 row">
                            <label for="nombre_servicio" class="col-md-3 form-label">Nombre</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" id="nombre_servicio" name="nombre_servicio">
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="descripcion" class="col-md-3 form-label">Descripción</label>
                            <div class="col-md-9">
                                <textarea type="text" class="form-control" id="descripcion" name="descripcion">
                                </textarea>
                            </div>

                        </div>
                        <div class="mb-3 row">
                            <label for="precio" class="col-md-3 form-label">Precio</label>
                            <div class="col-md-9">
                                <input type="number" min="1" step="any" class="form-control" id="precio" name="precio">
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="duracion_estimada" class="col-md-3 form-label">Duración</label>
                            <div class="col-md-9">
                                <input type="number" min="1" max="24" class="form-control" id="duracion_estimada"
                                    name="duracion_estimada">
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