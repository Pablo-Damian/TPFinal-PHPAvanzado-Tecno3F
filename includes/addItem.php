<?php
session_start();
if (!isset($_SESSION['loggedin']) || !$_SESSION['loggedin']) {
  header('Location: login.php?action=add');
  exit;
}

// Procesar la adición del nuevo ítem aquí
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Agregar nuevo ítem</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../assets/css/styles.css">
</head>
<body>
  <div class="container">
    <h1 class="my-4">Agregar nuevo ítem</h1>
    <form id="addItemForm">
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
      <button type="submit" class="btn btn-success">Agregar</button>
    </form>
  </div>

  <script>
    document.getElementById('addItemForm').addEventListener('submit', function(e) {
      e.preventDefault();
      const formData = new FormData(this);
      fetch('../includes/create.php', {
        method: 'POST',
        body: JSON.stringify(Object.fromEntries(formData)),
        headers: {
          'Content-Type': 'application/json'
        }
      })
      .then(response => response.json())
      .then(data => {
        if (data.message === 'Item was created.') {
          window.location.href = '../index.php';
        } else {
          alert('No se pudo agregar el ítem');
        }
      }).catch(error => {
        console.error('Error al agregar el ítem:', error);
      });
    });
  </script>
</body>
</html>