<?php 
require 'db.php';
if (session_status() === PHP_SESSION_NONE) session_start();

if(!isset($_SESSION['user_id'])) { 
    header('Location: login.php'); 
    exit; 
}

// ✅ Manejo con POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $service = $_POST['service'] ?? null;
    $date    = $_POST['date'] ?? null;
    $time    = $_POST['time'] ?? null;
    $notes   = $_POST['notes'] ?? null;

    // 🔎 Validaciones
    $errors = [];
    $validServices = ['Corte de Cabello','Arreglo de Barba','Corte+Barba'];

    if (!in_array($service, $validServices)) {
        $errors[] = 'Servicio inválido';
    }
    if (!$date || !$time) {
        $errors[] = 'Fecha y hora requeridas';
    }

    // ✅ Si todo es correcto -> Guardar
    if (empty($errors)) {
        $stmt = $pdo->prepare(
            'INSERT INTO reservations (user_id, service, date, time, notes) 
             VALUES (?, ?, ?, ?, ?)'
        );
        $stmt->execute([$user_id, $service, $date, $time, $notes]);

        $_SESSION['flash'] = 'Reserva creada correctamente';
        header('Location: my_reservations.php');
        exit;
    } else {
        $_SESSION['errors'] = $errors;
        header('Location: index.php');
        exit;
    }
} else {
    // ✅ Si intentan GET u otro método: mostramos parámetros normales esperados
    header('Content-Type: application/json');
    echo json_encode([
        "error" => true,
        "message" => "Método no permitido. Usa POST.",
        "params" => [
            "service" => "Corte de Cabello | Arreglo de Barba | Corte+Barba",
            "date"    => "YYYY-MM-DD",
            "time"    => "HH:MM",
            "notes"   => "Texto opcional"
        ],
        "example" => [
            "service" => "Corte de Cabello",
            "date"    => "2025-09-10",
            "time"    => "15:30",
            "notes"   => "Cliente nuevo"
        ]
    ]);
    exit;
}
