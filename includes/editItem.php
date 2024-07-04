<?php
session_start();
if (!isset($_SESSION['loggedin']) || !$_SESSION['loggedin']) {
  header('Location: login.php?action=edit&id=' . $_GET['id']);
  exit;
}

$id = $_GET['id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Editar ítem</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../assets/css/styles.css">
</head>
<body>
  <div class="container">
    <h1 class="my-4">Editar ítem</h1>
    <form id="editItemForm">
      <input type="hidden" name="id" id="item_id" value="<?php echo $id; ?>">
      <div class="form-group">
        <label for="title">Título</label>
        <input type="text" name="title" id="title" class="form-control" required>
      </div>
      <div class="form-group">
        <label for="year">Año lanzamiento</label>
        <input type="number" name="year" id="year" class="form-control" required>
      </div>
      <div class="form-group">
        <label for="description">Descripción</label>
        <textarea name="description" id="description" class="form-control" required></textarea>
      </div>
      <div class="form-group">
        <label for="price">Precio</label>
        <input type="number" step="0.01" name="price" id="price" class="form-control" required>
      </div>
      <div class="form-group">
        <label for="category_id">Categoría</label>
        <select name="category_id" id="category_id" class="form-control" required>
          <option value="1">Acción</option>
          <option value="2">Aventura</option>
          <option value="3">Deportes</option>
          <option value="4">Estrategia</option>
          <option value="5">Naves</option>
          <option value="6">Lucha</option>
        </select>
      </div>
      <div class="form-group">
        <label for="image_url">URL de la Imagen</label>
        <input type="text" name="image_url" id="image_url" class="form-control">
      </div>
      <button type="submit" class="btn btn-primary">Guardar cambios</button>
    </form>
  </div>

  <script>
    document.getElementById('editItemForm').addEventListener('submit', function(e) {
      e.preventDefault();
      const formData = new FormData(this);
      fetch('../includes/update.php', {
        method: 'POST',
        body: JSON.stringify(Object.fromEntries(formData)),
        headers: {
          'Content-Type': 'application/json'
        }
      })
      .then(response => response.json())
      .then(data => {
        if (data.message === 'Item was updated.') {
          window.location.href = '../index.php';
        } else {
          alert('No se pudo actualizar el ítem');
        }
      }).catch(error => {
        console.error('Error al actualizar el ítem:', error);
      });
    });

    // Load item details into the form
    fetch(`../includes/read.php?id=<?php echo $id; ?>`)
    .then(response => response.json())
    .then(data => {
      const item = data.items[0];
      document.getElementById('title').value = item.title;
      document.getElementById('year').value = item.year;
      document.getElementById('description').value = item.description;
      document.getElementById('price').value = item.price;
      document.getElementById('category_id').value = item.category_id;
      document.getElementById('image_url').value = item.image_url;
    });
  </script>
</body>
</html>