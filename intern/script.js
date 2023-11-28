document.addEventListener("DOMContentLoaded", function() {
    const importButton = document.getElementById("importButton");
    importButton.addEventListener("click", importQuestions);
});

function importQuestions() {
    const csvForm = document.getElementById("csvForm");
    const formData = new FormData(csvForm);

    fetch("import.php", {
        method: "POST",
        body: formData,
    })
    .then(response => response.text())
    .then(message => {
        document.getElementById("message").textContent = message;
    })
    .catch(error => {
        console.error("Error:", error);
    });
}
