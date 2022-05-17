let container = document.querySelector(".dropdown-container").children;
var dropdown = document.querySelector("dropdown-btn");
for (let i = 0; i < container.length; i++) {
  if (container[i].getAttribute("class").includes("active")) {
    dropdown.classList.add("active");
    break;
  }
}
