<?php include_once(VIEWS . 'layouts/head.php'); ?>
<?php include_once(VIEWS . 'layouts/slidebar.php'); ?>

<body>
    <div class="container p-3">
        <div class="container-fluid d-flex justify-content-around">
            <h2 class="h3">Bienvenidos a nuestro pequeño Crud </h2>
            <button class="btn btn-primary btn-sm " data-bs-toggle="modal" data-bs-target="#staticBackdrop">Registrar</button>
        </div>
        <div class="card mt-3">
            <div class="card-header">
                Registros de los usuarios
            </div>
            <div class="card-body">
                <table class="table text-center" id="table-users" name="table-users">
                    <thead>
                        <tr>
                            <th scope="col">ROL</th>
                            <th scope="col">DESCRIPCIÓN</th>
                            <th scope="col">Apellidos</th>
                            <th scope="col">Email</th>
                            <th scope="col" class="">Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="tb-body" class="text-center">
                    </tbody>
                </table>
            </div>
            <div class="card-footer text-muted">
                Footer
            </div>
        </div>
        <?php require_once(VIEWS . 'user/create.php'); ?>
        <?php require_once(VIEWS . 'user/show.php'); ?>
        <?php require_once(VIEWS . 'user/edit.php'); ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="text/javascript">
        $(document).ready(function() {

            showList();
            register();
            showRegister();
            edit();
            deleteRegister();
        });


        //Lista
        function showList() {
            const table = $.ajax({
                url: "<?= URL ?>page/list",
                cache: false,
                method: "GET",
                success: function(data) {
                    // console.log(data);
                    $("#table-users > tbody").empty();
                    const datos = JSON.parse(data);
                    for (let index = 0; index < datos.length; index++) {
                        // console.log(datos[index].nombre);
                        let dom = '<tr><td>' + datos[index].rol + '</td>';
                        dom += '<td>' + datos[index].denominacion + '</td>';
                        dom += '<td>' + datos[index].apellidos + '</td>';
                        dom += '<td>' + datos[index].email + '</td>';
                        dom += '<td class="d-flex gap-2 justify-content-between">' +
                            '<a href="javascript: void(0)" id="btn-view" name="btn-view" class="btn btn-success w-100 modal-show-users"  data-original-title="Show"  data-id=" ' + datos[index].id + '">Ver' + '</a>' +
                            '<a href="javascript: void(0)" id="btn-edit" name="btn-edit" class="btn btn-warning w-100 editUser"  data-original-title="Edit" data-id="' + datos[index].id + '">Editar' + '</button>' +
                            '<a href="javascript: void(0)" id="btn-delete" name="btn-delete" class="btn btn-danger w-100 deleteUser" data-original-title="Delete" data-id="' + datos[index].id + '">Eliminar' + '</a>' +
                            '</td></tr>';
                        $('#tb-body').append(dom);

                    }


                }
            });
            return false;
        }

        //Registro
        function register() {
            $("#frm-register").on('submit', function(e) {
                e.preventDefault();
                const formData = new FormData(this);
                $.ajax({
                    url: "<?= URL ?>page/store",
                    method: "POST",
                    data: formData,
                    cache: false,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        let res = JSON.parse(response);
                        if (res.status === 200) {
                            $("#frm-register")[0].reset();
                            $('#staticBackdrop').modal('hide');
                            showList();
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: 'Acabas de registrar un usuario',
                                showConfirmButton: false,
                                timer: 1500
                            })
                        }
                    }
                });
                return false;
            });

        }

        //showRegister
        function showRegister() {
            $("#table-users").on('click', '.modal-show-users', function(e) {
                const idUser = $(this).data('id');
                $.ajax({
                    url: "<?= URL ?>page/show",
                    type: "POST",
                    cache: false,
                    data: {
                        id: idUser
                    },
                    success: function(response) {
                        const data = JSON.parse(response);
                        $("#nombreShow").val(data.nombre);
                        $("#apellidosShow").val(data.nombre);
                        $("#emailShow").val(data.nombre);
                    },
                    error: function(xhr) {
                        alert('Hubo un error al solicitar los datos');
                    },
                    complete: function() {
                        $("#modalusershow").modal('show');
                    }
                });
            });
        }
        //delete
        function deleteRegister() {
            $("#table-users").on('click', '.deleteUser', function(e) {
                const id = $(this).data('id');
                Swal.fire({
                    title: 'Esta seguro de esta accion?',
                    text: "Recuerde que esto es irreversible!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si, deseo eliminarlo!'
                }).then((result) => {
                    if (result.isConfirmed) {

                        $.ajax({
                            url: "<?= URL ?>page/destroy",
                            type: "POST",
                            data: {
                                id: id
                            },
                            cache: false,
                            success: function(response) {
                                if (response) {
                                    showList();
                                }
                            }
                        })
                        Swal.fire(
                            'Eliminado!',
                            'Acabas de eliminar un registro.',
                            'success'
                        )
                    }
                })
            });
        }
        //editform
        function edit() {
            $("#table-users").on('click', '.editUser', function(e) {
                const idEdit = $(this).data('id');
                $.ajax({
                    url: "<?= URL ?>page/show",
                    'type': "POST",
                    cache: false,
                    data: {
                        id: idEdit
                    },
                    success: function(response) {
                        const data = JSON.parse(response);
                        $("#nombreEdit").val(data.nombre);
                        $("#apellidosEdit").val(data.apellidos);
                        $("#emailEdit").val(data.email);
                        update(idEdit);                        
                    },
                    complete: function() {
                        $("#editUserModal").modal('show');
                    }

                });
                return false;
            });
        }
        //save changes
        function update(id) {

            $("#frm-edit").on('submit', function(e) {
                e.preventDefault();
                // const formData = new FormData(this);
                Swal.fire({
                    title: 'Quieres guardar los cambios?',
                    showDenyButton: true,
                    showCancelButton: true,
                    confirmButtonText: 'Guardar',
                    denyButtonText: `No guardar`,
                }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "<?= URL ?>page/update",
                            type: "POST",
                            cache: false,
                            data: {
                                id: id,
                                nombre: $("#nombreEdit").val(),
                                apellidos: $("#apellidosEdit").val(),
                                email: $("#emailEdit").val()
                            },
                            success: function(response) {
                                $("#editUserModal").modal('hide');
                                showList();                                
                            }
                        });
                        Swal.fire('Cambios realizado!', '', 'success')
                    } else if (result.isDenied) {
                        $("#editUserModal").modal('hide');
                        Swal.fire('Cambios no realizados', '', 'success')
                    }
                })

            });
        }
    </script>
</body>
<?php include_once(VIEWS . 'layouts/footer.php'); ?>