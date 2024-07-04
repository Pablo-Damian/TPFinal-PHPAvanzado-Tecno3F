<?php
session_start();
$action = isset($_GET['action']) ? $_GET['action'] : '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($username == $_ENV['DB_USERNAME'] && $password == $_ENV['DB_PASSWORD']) {
        $_SESSION['loggedin'] = true;

        if ($action == 'add') {
            header('Location: addItem.php');
        } elseif ($action == 'edit') {
            $id = $_POST['id'];
            header('Location: editItem.php?id=' . $id);
        } else {
            echo json_encode(['success' => true]);
            exit;
        }
    } else {
        if ($action == 'add' || $action == 'edit') {
            $error = 'Usuario o contraseña incorrectos';
        } else {
            echo json_encode(['success' => false]);
            exit;
        }
    }
}

if ($action == 'add' || $action == 'edit') {
    ?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
        <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="../assets/css/styles.css">
    </head>
    <body>
        <div class="container">
            <h1 class="my-4">Login</h1>
            <?php if (isset($error)): ?>
                <div class="alert alert-danger"><?php echo $error; ?></div>
            <?php endif; ?>
            <form method="post" action="login.php?action=<?php echo $action; ?>">
                <div class="form-group">
                    <label for="username">Usuario (user)</label>
                    <input type="text" name="username" id="username" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="password">Contraseña (123)</label>
                    <input type="password" name="password" id="password" class="form-control" required>
                </div>
                <?php if ($action == 'edit'): ?>
                    <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">
                <?php endif; ?>
                <button type="submit" class="btn btn-primary">Login</button>
            </form>
        </div>
    </body>
    </html>

    <?php
}
?>