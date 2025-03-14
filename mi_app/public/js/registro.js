document.getElementById("registroForm").addEventListener("submit", function (e) {
    e.preventDefault();

    const formData = new FormData(this);

    fetch("../backend/registro.php", {
        method: "POST",
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === "success") {
            alert("✅ " + data.message);
            document.getElementById("registroForm").reset();
        } else {
            alert("❌ " + data.message);
        }
    })
    .catch(error => console.error("Error:", error));
});
