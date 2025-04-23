const header = document.querySelector("#header");
window.addEventListener("scroll", () => {
  return this.scrollY >= 15
    ? header.classList.add("scroller")
    : header.classList.remove("scroller");
});
