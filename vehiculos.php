<?php include('conexion_bd.php'); ?>
<!doctype html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="css/bootstrap5.0.1.min.css" rel="stylesheet" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="css/datatables-1.10.25.min.css" />
    <link rel="stylesheet" type="text/css" href="css/Header.css" />
    <title>Control de vehiculos</title>
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
        <p class="datatable design text-center">Control de vehiculos</p>

        <div class="row">
            <div class="container">
                <div class="btnAdd">
                    <a href="#!" data-id="" data-bs-toggle="modal" data-bs-target="#addUserModal" class="btn btn-success btn-sm">Agregar Vehículo</a>
                </div>

                <div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md-8">
                        <table id="example" class="table">
                            <thead>
                                <th>Id</th>
                                <th>Cliente</th>
                                <th>Marca</th>
                                <th>Modelo</th>
                                <th>Año</th>
                                <th>Placa</th>
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
                    "url": "vehiculos/listar_vehiculos.php",
                    "type": "POST"
                },
                "order": [
                    [0, "desc"]
                ],
                "paging": true,
                "searching": true,
                "lengthChange": true
            });


            $.ajax({
                url: 'clientes/select.php',
                type: 'get',
                dataType: 'json',
                success: function(response) {
                    var len = response.length;
                    $("#id_cliente").empty();
                    $("#id_cliente").append("<option value='" + -1 + "'>" + "Selecciona un cliente" +
                        "</option>");
                    for (var i = 0; i < len; i++) {
                        var id = response[i]['id_cliente'];
                        var nombre = response[i]['nombre'];

                        $("#id_cliente").append("<option value='" + id + "'>" + nombre +
                            "</option>");
                    }
                }
            });


        });

        $(document).on('submit', '#addCliente', function(e) {
            e.preventDefault();

            var id_cliente = $('#id_cliente').val();
            var marca = $('#marca').val();
            var modelo = $('#modelo').val();
            var ano = $('#ano').val();
            var matricula = $('#matricula').val();

            if (
                id_cliente != '' &&
                marca != '' &&
                modelo != '' &&
                ano != '' &&
                matricula != ''
            ) {
                $.ajax({
                    url: "vehiculos/agregar_vehiculo.php",
                    type: "post",
                    data: {
                        id_cliente: id_cliente,
                        marca: marca,
                        modelo: modelo,
                        ano: ano,
                        matricula: matricula
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
                    <h5 class="modal-title" id="exampleModalLabel">Agregar Vehículo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addCliente" action="">

                        <div class="mb-3 row">
                            <label for="id_cliente" class="col-md-3 form-label">Cliente</label>
                            <div class="col-md-9">
                                <select class="form-control" id="id_cliente">
                                </select>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="marca" class="col-md-3 form-label">Marca</label>
                            <div class="col-md-9">
                                <select class="form-control" id="marca">
                                    <option value="">Selecciona una marca</option>
                                    <option value="Chevrolet">Chevrolet</option>
                                    <option value="Ford">Ford</option>
                                    <option value="Toyota">Toyota</option>
                                    <option value="Nissan">Nissan</option>
                                    <option value="Honda">Honda</option>
                                    <option value="Hyundai">Hyundai</option>
                                    <option value="Kia">Kia</option>
                                    <option value="Mazda">Mazda</option>
                                    <option value="Volkswagen">Volkswagen</option>
                                    <option value="Audi">Audi</option>
                                    <option value="BMW">BMW</option>
                                    <option value="Mercedes-Benz">Mercedes-Benz</option>
                                    <option value="Jeep">Jeep</option>
                                    <option value="Ram">Ram</option>
                                    <option value="Subaru">Subaru</option>
                                    <option value="Volvo">Volvo</option>
                                    <option value="Land Rover">Land Rover</option>
                                    <option value="Jaguar">Jaguar</option>
                                    <option value="Porsche">Porsche</option>
                                    <option value="Mini">Mini</option>
                                    <option value="Fiat">Fiat</option>
                                    <option value="Peugeot">Peugeot</option>
                                    <option value="Renault">Renault</option>
                                    <option value="Citroën">Citroën</option>
                                    <option value="Seat">Seat</option>
                                    <option value="Suzuki">Suzuki</option>
                                    <option value="Mitsubishi">Mitsubishi</option>
                                    <option value="Chrysler">Chrysler</option>
                                    <option value="Dodge">Dodge</option>
                                    <option value="Buick">Buick</option>
                                    <option value="Cadillac">Cadillac</option>
                                    <option value="GMC">GMC</option>
                                    <option value="Lincoln">Lincoln</option>
                                    <option value="Acura">Acura</option>
                                    <option value="Infiniti">Infiniti</option>
                                    <option value="Lexus">Lexus</option>
                                    <option value="Alfa Romeo">Alfa Romeo</option>
                                    <option value="Ferrari">Ferrari</option>
                                    <option value="Maserati">Maserati</option>
                                    <option value="Bentley">Bentley</option>
                                    <option value="Rolls-Royce">Rolls-Royce</option>
                                    <option value="Tesla">Tesla</option>
                                    <option value="Bugatti">Bugatti</option>
                                    <option value="McLaren">McLaren</option>
                                    <option value="Lotus">Lotus</option>
                                    <option value="Maybach">Maybach</option>
                                    <option value="Koenigsegg">Koenigsegg</option>
                                    <option value="Pagani">Pagani</option>
                                    <option value="Genesis">Genesis</option>
                                    <option value="Rivian">Rivian</option>
                                    <option value="Lucid">Lucid</option>
                                    <option value="Polestar">Polestar</option>
                                    <option value="Rivian">Rivian</option>
                                    <option value="Lucid">Lucid</option>
                                    <option value="Polestar">Polestar</option>
                                    <option value="Rivian">Rivian</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="modelo" class="col-md-3 form-label">Modelo</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" id="modelo" name="modelo">
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="ano" class="col-md-3 form-label">Año</label>
                            <div class="col-md-9">
                                <input type="number" class="form-control" min="1900" max="2099" step="1" id="ano" name="nano" value="2016" />

                            </div>

                        </div>

                        <div class="mb-3 row">
                            <label for="matricula" class="col-md-3 form-label">Placa</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" id="matricula" name="matricula">
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