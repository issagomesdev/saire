const dropMenu = document.querySelector('.drop-menu');
const nav = document.querySelector('.nav');

dropMenu.addEventListener("click", () => {
  if(nav.getAttribute("active") == "false") {
    nav.setAttribute("active", "true");
    document.querySelector('.drop-menu i').classList.remove("fa-caret-down");
    document.querySelector('.drop-menu i').classList.add("fa-caret-up");
  } else {
    nav.setAttribute("active", "false");
    document.querySelector('.drop-menu i').classList.remove("fa-caret-up");
    document.querySelector('.drop-menu i').classList.add("fa-caret-down");   
  }

})

const parentMenu = document.querySelector('.parent-menu');
const childMenu = document.querySelector('.child-menu');

if(parentMenu){
  parentMenu.addEventListener("click", () => {
    if(childMenu.getAttribute("active") === "true") {
      childMenu.setAttribute("active", "false");
      document.querySelector('.parent-menu i').classList.remove("fa-caret-up");
      document.querySelector('.parent-menu i').classList.add("fa-caret-down");
    } else {   
      childMenu.setAttribute("active", "true");
      document.querySelector('.parent-menu i').classList.remove("fa-caret-down");
      document.querySelector('.parent-menu i').classList.add("fa-caret-up");
    }
  })
}