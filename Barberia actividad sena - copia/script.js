document.addEventListener('DOMContentLoaded', () => {
    // Manejar clics en botones con data-target
    const buttons = document.querySelectorAll('button[data-target]');
    buttons.forEach(button => {
        button.addEventListener('click', (event) => {
            const targetPage = event.currentTarget.dataset.target;
            if (targetPage) {
                window.location.href = targetPage; // Redirige a la página
            }
        })
    });

    // Manejar clics en los feature-item (las tarjetas de servicios)
    const featureItems = document.querySelectorAll('.feature-item');
    featureItems.forEach(item => {
        item.addEventListener('click', (event) => {
            // Asegúrate de que el clic no fue en un botón dentro del item, para evitar doble redirección
            if (!event.target.closest('button')) {
                const targetPage = event.currentTarget.dataset.target;
                if (targetPage) {
                    window.location.href = targetPage; // Redirige a la página
                }
            };
        });
    });

    // Opcional: Desplazamiento suave para el enlace de contacto en el header
    const contactLink = document.querySelector('a[href="#contacto"]');
    if (contactLink) {
        contactLink.addEventListener('click', (event) => {
            event.preventDefault(); // Previene el salto instantáneo
            const targetId = event.currentTarget.getAttribute('href').substring(1);
            const targetElement = document.getElementById(targetId);
            if (targetElement) {
                targetElement.scrollIntoView({
                    behavior: 'smooth'
                });
            }
        });
    }
});