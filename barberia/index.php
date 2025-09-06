<?php 
require 'db.php';
require 'templates/header.php';

// ✅ Manejo de parámetros normales (GET y POST)
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['view'])) {
        $view = $_GET['view'];
        if ($view === "promos") {
            include "promos.php";
            exit;
        } elseif ($view === "cortes") {
            include "cortes.php";
            exit;
        }
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Aquí procesarías datos de formularios si lo necesitas
    // Ejemplo: guardar reservas con AJAX en el futuro
}
?>

<section class="hero">
    <h1>Bienvenido a Barbería</h1>
    <p>Promoción: Corte + Arreglo de Barba 20% OFF</p>

    <!-- 📌 Botones de Promociones y Cortes (solo estos, en azul 3D) -->
    <div class="hero-buttons">
        <button class="btn-3d" onclick="loadContent('promos.php')">Ver Promociones</button>
        <button class="btn-3d" onclick="loadContent('cortes.php')">Ver Cortes</button>
    </div>
</section>

<!-- 📌 Contenedor dinámico para AJAX -->
<section id="dynamic-content" class="dynamic-section"></section>

<section class="services">
    <h2>Servicios</h2>
    <ul>
        <li>Corte de Cabello</li>
        <li>Arreglo de Barba</li>
        <li>Corte+Barba</li>
    </ul>
</section>

<section class="reserve-form">
    <h2>Reservar</h2>
    <?php if(!isset($_SESSION['user_id'])): ?>
        <p>Debes <a href="login.php">iniciar sesión</a> para reservar.</p>
    <?php else: ?>
        <form id="reserveForm" action="reserve.php" method="post">
            <label>Servicio
                <select name="service" required>
                    <option value="Corte de Cabello">Corte de Cabello</option>
                    <option value="Arreglo de Barba">Arreglo de Barba</option>
                    <option value="Corte+Barba">Corte+Barba</option>
                </select>
            </label>
            <label>Fecha: <input type="date" name="date" required></label>
            <label>Hora: <input type="time" name="time" required></label>
            <label>Notas: <textarea name="notes"></textarea></label>
            <button type="submit">Reservar</button>
        </form>
    <?php endif; ?>
</section>

<?php require 'templates/footer.php'; ?>

<!-- 📌 Script AJAX -->
<script>
function loadContent(page) {
    fetch(page)
        .then(response => response.text())
        .then(data => {
            document.getElementById("dynamic-content").innerHTML = data;
            window.scrollTo({ top: document.getElementById("dynamic-content").offsetTop, behavior: "smooth" });
        })
        .catch(error => {
            document.getElementById("dynamic-content").innerHTML = "<p style='color:red;'>Error al cargar el contenido.</p>";
            console.error("Error:", error);
        });
}
</script>


