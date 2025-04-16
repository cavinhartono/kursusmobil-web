document.getElementById("searchInput").addEventListener("keyup", () => {
  const rows = document.querySelectorAll("#dataTable tbody tr");
  const keyword = this.value.toLowerCase();

  rows.forEach((row) => {
    const cells = Array.from(row.getElementsByTagName("td"));
    const match = cells.some((td) =>
      td.textContent.toLowerCase().includes(keyword)
    );
    row.style.display = match ? "" : "none";
  });
});

function openModal(id) {
  document.getElementById(id).style.display = "block";
}

function closeModal(id) {
  document.getElementById(id).style.display = "none";
}

window.onclick = function (event) {
  document.querySelectorAll(".modal").forEach((modal) => {
    if (event.target == modal) {
      modal.style.display = "none";
    }
  });
};

function toggleDropdown() {
  var dropdownContent = document.getElementById("dropdown-content");
  dropdownContent.style.display =
    dropdownContent.style.display === "block" ? "none" : "block";
}

function toggleSidebar() {
  var sidebar = document.querySelector(".sidebar");
  var content = document.querySelector(".content");
  sidebar.classList.toggle("collapsed");
  content.classList.toggle("collapsed");
}
