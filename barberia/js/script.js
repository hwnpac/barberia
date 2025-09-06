function loadContent(page) {
    const xhr = new XMLHttpRequest();
    xhr.open("GET", page, true);
    xhr.onload = function() {
        if (this.status === 200) {
            document.getElementById("dynamic-content").innerHTML = this.responseText;
        } else {
            document.getElementById("dynamic-content").innerHTML = "<p>Error al cargar el contenido.</p>";
        }
    };
    xhr.send();
}
