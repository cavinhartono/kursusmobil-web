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
