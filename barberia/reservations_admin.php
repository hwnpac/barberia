<?php
require 'db.php';
if (session_status() === PHP_SESSION_NONE) session_start();

// ⚠️ Aquí puedes poner un control de acceso extra (ejemplo: rol admin).
// if(!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true){
//     header('Location: index.php'); exit;
// }

require 'templates/header.php';

// Consultar todas las reservas con datos del usuario
$sql = "SELECT r.id, r.service, r.date, r.time, r.notes, r.created_at,
               u.name, u.email
        FROM reservations r
        INNER JOIN users u ON r.user_id = u.id
        ORDER BY r.date DESC, r.time DESC";

$stmt = $pdo->query($sql);
$reservas = $stmt->fetchAll();

// Mensajes flash
if(isset($_SESSION['flash'])) {
    echo '<p class="flash">'.htmlspecialchars($_SESSION['flash']).'</p>';
    unset($_SESSION['flash']);
}
?>

<h2>Panel de Reservas (Admin)</h2>

<?php if(!$reservas): ?>
    <p>No hay reservas registradas.</p>
<?php else: ?>
    <table class="reservas">
        <tr>
            <th>ID</th>
            <th>Cliente</th>
            <th>Email</th>
            <th>Servicio</th>
            <th>Fecha</th>
            <th>Hora</th>
            <th>Notas</th>
            <th>Creada en</th>
        </tr>
        <?php foreach($reservas as $r): ?>
            <tr>
                <td><?= htmlspecialchars($r['id']) ?></td>
                <td><?= htmlspecialchars($r['name'] ?? 'Sin nombre') ?></td>
                <td><?= htmlspecialchars($r['email']) ?></td>
                <td><?= htmlspecialchars($r['service']) ?></td>
                <td><?= htmlspecialchars($r['date']) ?></td>
                <td><?= htmlspecialchars($r['time']) ?></td>
                <td><?= htmlspecialchars($r['notes'] ?? '') ?></td>
                <td><?= htmlspecialchars($r['created_at']) ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php endif; ?>

<?php require 'templates/footer.php'; ?>
