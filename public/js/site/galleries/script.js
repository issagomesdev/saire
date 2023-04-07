
var index = 0;

const addGalleriesItems = galleries.map(function(gallery){

    const array = [];

    for (let i = 0; i < (gallery.photos).length; i++) {

        index++
        const id = index;
        const data_id = gallery.id;
        const title = gallery.title;
        const description = gallery.description;
        const date = gallery.date;
        const categories = gallery.categories;
        const photo = gallery.photos[i];
        const items = {id, data_id, title, description, date, categories, photo}
        array.push(items);       
    }

    return array
});

const galleriesItems = [].concat(...addGalleriesItems);
const galleriesContent = document.querySelector(".galleries");

const items_in_gallery = galleriesItems.map(function(item){

    const item_in_gallery = document.createElement("div");
    item_in_gallery.classList.add("item-in-gallery");
    const itemImagen = document.createElement("img")
    itemImagen.src = item.photo;
    item_in_gallery.append(itemImagen);

    item_in_gallery.addEventListener("click", () => {
        display(item)
    });

    return item_in_gallery
});

galleriesContent.append(...items_in_gallery);

const display_imagen = document.querySelector(".display-imagen");

var itemcurrent = {};

function display(item) {
    itemcurrent = item;
    const imagen = document.querySelector(".display-imagen img");
    imagen.src = item.photo;
    const title = document.querySelector("#title p");
    title.innerHTML = `${item.title}`;
    const description = document.querySelector("#description p");
    description.innerHTML = `${item.description}`;
    const date = document.querySelector("#date p");
    date.innerHTML = `${item.date}`;
    const categories = document.querySelector(".categories-items");
    const items_in_categories = item.categories.map(function(category){

        const p = document.createElement("p");
        p.innerHTML = category;

        return p
    });
    const clearCategories = document.querySelectorAll(".categories-items p");
    clearCategories.forEach(element => element.remove());
    categories.append(...items_in_categories);
    display_imagen.setAttribute("visible", "true");
}

const closeModal = document.querySelector(".close");

closeModal.addEventListener("click", () => {
    display_imagen.setAttribute("visible", "false");
});


const openDetails = document.querySelector(".open-details");
const details = document.querySelector(".details-item");

openDetails.addEventListener("click", () => {

    if(details.getAttribute("visible") == "false"){
        details.setAttribute("visible", "true");
    } else {
        details.setAttribute("visible", "false");
    }

});

const previous_image = document.querySelector("#previous");

previous_image.addEventListener("click", () => {
    if(itemcurrent.id == 1){
        const current = galleriesItems.filter(item => item.id == galleriesItems.length);
        display(current[0]);
    } else {
        const current = galleriesItems.filter(item => item.id == (itemcurrent.id - 1));
        display(current[0]);
    }
});

const next_image = document.querySelector("#next");

next_image.addEventListener("click", () => {
    if(itemcurrent.id == galleriesItems.length){
        const current = galleriesItems.filter(item => item.id == 1);
        display(current[0]);
    } else {
        const current = galleriesItems.filter(item => item.id == (itemcurrent.id + 1));
        display(current[0]);
    }
   
});