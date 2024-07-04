<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo de Ventas de Juegos de Atari</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
    <div class="container">
        <h1 class="my-4">Catálogo de Ventas de Juegos de<img src="assets/img/logoatari.png" alt="Atari Logo" style="height: 150px; float: right;"></h1>
        <button id="addItem" class="btn btn-success mb-4">Agregar Nuevo Título</button>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Título</th>
                    <th>Lanzamiento</th>
                    <th>Descripción</th>
                    <th>Precio</th>
                    <th>Categoría</th>
                    <th>IMG</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody id="catalogueBody">
                <!-- Items will be populated here -->
            </tbody>
        </table>
    </div>

    <!-- Modal de autenticación -->
    <div class="modal fade" id="authModal" tabindex="-1" role="dialog" aria-labelledby="authModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="authModalLabel">Autenticación</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="authForm">
                        <div class="form-group">
                            <label for="username">Usuario (user)</label>
                            <input type="text" class="form-control" id="username" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Contraseña (123)</label>
                            <input type="password" class="form-control" id="password" required>
                        </div>
                        <button type="submit" class="btn btn-primary" style="width: 120px;">Aceptar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            let itemIdToDelete;

            function fetchItems() {
                $.get('includes/read.php', function(data) {
                    console.log('Datos recibidos:', data);  // Log de depuración

                    if (data.items) {
                        const items = data.items;
                        let rows = '';
                        items.forEach(item => {
                            rows += `
                                <tr>
                                    <td>${item.id}</td>
                                    <td>${item.title}</td>
                                    <td>${item.year}</td>
                                    <td>${item.description}</td>
                                    <td>$${item.price}</td>
                                    <td>${item.category_name}</td>
                                    <td><img src="${item.image_url}" style="width: 300px; height: 300px;" alt="${item.title}"></td>
                                    <td>
                                        <button class="btn btn-primary editItem" data-id="${item.id}">Editar</button>
                                        <button class="btn btn-danger deleteItem" data-id="${item.id}">Eliminar</button>
                                    </td>
                                </tr>
                            `;
                        });
                        $('#catalogueBody').html(rows);
                    } else {
                        console.error('No items found in response');
                    }
                }).fail(function(jqXHR, textStatus, errorThrown) {
                    console.error('Error al cargar los items:', textStatus, errorThrown);  // Log de depuración
                });
            }

            fetchItems();

            $('#addItem').click(function() {
                // Redirect to login page before adding item
                window.location.href = 'includes/login.php?action=add';
            });

            $(document).on('click', '.editItem', function() {
                const id = $(this).data('id');
                // Redirect to login page before editing item
                window.location.href = 'includes/login.php?action=edit&id=' + id;
            });

            $(document).on('click', '.deleteItem', function() {
                itemIdToDelete = $(this).data('id');
                $('#authModal').modal('show');
            });

            $('#authForm').submit(function(e) {
                e.preventDefault();
                const username = $('#username').val();
                const password = $('#password').val();

                $.post('includes/login.php', { username: username, password: password }, function(data) {
                    if (data.success) {
                        $('#authModal').modal('hide');
                        if (confirm('¿Estás seguro de que deseas eliminar este ítem?')) {
                            $.ajax({
                                url: 'includes/delete.php',
                                type: 'POST',
                                data: JSON.stringify({ id: itemIdToDelete }),
                                success: function(result) {
                                    fetchItems();
                                }
                            });
                        }
                    } else {
                        alert('Autenticación fallida');
                    }
                }, 'json');
            });
        });
    </script>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>