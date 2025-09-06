<?php
require 'db.php';
if (session_status() === PHP_SESSION_NONE) session_start();
if(!isset($_SESSION['user_id'])){ header('Location: login.php'); exit; }
require 'templates/header.php';

// Consultar reservas
$stm = $pdo->prepare('SELECT * FROM reservations WHERE user_id = ? ORDER BY date, time');
$stm->execute([$_SESSION['user_id']]);
$reservas = $stm->fetchAll();

// Mensajes flash y errores
if(isset($_SESSION['flash'])) {
    echo '<p class="flash">'.htmlspecialchars($_SESSION['flash']).'</p>';
    unset($_SESSION['flash']);
}
if(isset($_SESSION['errors'])) {
    foreach($_SESSION['errors'] as $e) {
        echo '<p class="errors">'.htmlspecialchars($e).'</p>';
    }
    unset($_SESSION['errors']);
}
?>

<h2>Mis Reservas</h2>

<?php if(!$reservas): ?>
    <p>No tienes reservas.</p>
<?php else: ?>
    <table class="reservas">
        <tr>
            <th>Servicio</th>
            <th>Fecha</th>
            <th>Hora</th>
            <th>Notas</th>
        </tr>
        <?php foreach($reservas as $r): ?>
            <tr>
                <td><?= htmlspecialchars($r['service']) ?></td>
                <td><?= htmlspecialchars($r['date']) ?></td>
                <td><?= htmlspecialchars($r['time']) ?></td>
                <td><?= htmlspecialchars($r['notes'] ?? '') ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php endif; ?>

<?php require 'templates/footer.php'; ?>
