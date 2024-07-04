<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once 'Database.php';

// Función para generar un token simple (en una implementación real, usa JWT)
function generateToken($username) {
    return base64_encode($username . ':' . time());
}

// Recibir datos POST
$data = json_decode(file_get_contents("php://input"));

if(!empty($data->username) && !empty($data->password)) {
    $username = $data->username;
    $password = $data->password;

    // En una implementación real, verifica las credenciales contra la base de datos
    // y usa password_verify() para comparar contraseñas hasheadas
    if($username == $_ENV['DB_USERNAME'] && $password == $_ENV['DB_PASSWORD']) {
        $token = generateToken($username);

        // Respuesta exitosa
        http_response_code(200);
        echo json_encode(array(
            "message" => "Login successful",
            "token" => $token
        ));
    } else {
        // Login fallido
        http_response_code(401);
        echo json_encode(array("message" => "Login failed"));
    }
} else {
    // Datos incompletos
    http_response_code(400);
    echo json_encode(array("message" => "Incomplete data"));
}
?>