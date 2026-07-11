if(publication_imagens.length > 0) {
const imagensOfPublication = document.querySelector(".publication-imagens");
const imagenOfPublication = document.querySelector(".publication-imagen a");
Skeleton.clear(imagenOfPublication);
Skeleton.clear(imagensOfPublication);
const imagen_in_publication = document.createElement("img");
Skeleton.setImage(imagen_in_publication, publication_imagens[0], 'src');
imagenOfPublication.append(imagen_in_publication);

const imagens_in_publication = publication_imagens.map(function(publication){

    const imageninpublication = document.createElement("div");
    imageninpublication.classList.add("imagens-in-publication")
    const imagen = document.createElement("img");
    Skeleton.setImage(imagen, publication, 'src');
    imageninpublication.append(imagen);

    imageninpublication.addEventListener("click", () => {
        imagen_in_publication.src = publication
    })

    return imageninpublication
});

imagensOfPublication.append(...imagens_in_publication)
}