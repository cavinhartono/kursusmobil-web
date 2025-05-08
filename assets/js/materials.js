document.getElementById("uploadForm").addEventListener("submit", function (e) {
  e.preventDefault();

  const formData = new FormData(this);

  fetch("../../courses/materials/upload.php", {
    method: "POST",
    body: formData,
  })
    .then((response) => response.json())
    .then((result) => {
      document.getElementById("uploadStatus").innerText = result.message;
    })
    .catch((error) => {
      document.getElementById("uploadStatus").innerText = "Upload error";
      console.error(error);
    });
});
