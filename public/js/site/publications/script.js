const publicationscontent = document.querySelector('.publications-content');


const publicationItems = publications.map(function(publication) {

    const publicationItem = document.createElement("div");
    publicationItem.classList.add("publication-item");
    
    const publicationsImg = document.createElement("div");
    publicationsImg.classList.add("publication-img");
    (publication.photos).length == 0? 
    publicationsImg.style.backgroundImage = "url('" + imageDefault + "')" :  
    publicationsImg.style.backgroundImage = "url('" + publication.photos[0] + "')";
    publicationItem.append(publicationsImg);

    const publicationsContent = document.createElement("div");
    publicationsContent.classList.add("publication-content");
    publicationItem.append(publicationsContent);

    const publicationsTitle = document.createElement("div");
    publicationsTitle.classList.add("publication-content-title");
    const publicationsTitleP = document.createElement("p");
    publicationsTitleP.innerHTML = publication.title;
    publicationsContent.append(publicationsTitle);
    publicationsTitle.append(publicationsTitleP);

    const publicationsText = document.createElement("div");
    publicationsText.classList.add("publication-content-text");
    const publicationsTextP = document.createElement("p");
    publicationsTextP.innerHTML = (he.decode(publication.text)).slice(0, 180 - 10) + "... " + he.decode(`<a href="/noticias/${(publication.title).replace(/\s+/g, '_')}"> Ler Mais </a>`);
    publicationsTextP.innerHTML += ''
    publicationsContent.append(publicationsText);
    publicationsText.append(publicationsTextP);

    const publicationsCategories = document.createElement("div");
    publicationsCategories.classList.add("publication-content-categories");

    const categories = publication.categories.map(function(categorie) {

        const publicationcategorie = document.createElement("p");
        publicationcategorie.innerHTML = categorie;


        return publicationcategorie;
    });

    publicationsCategories.append(...categories);
    publicationsContent.append(publicationsCategories);

    const publicationsDate = document.createElement("div");
    publicationsDate.classList.add("publication-content-date");
    publicationsDate.innerHTML = "Publicado em " + publication.date
    publicationItem.append(publicationsDate);
    
    return publicationItem;
  });

  publicationscontent.append(...publicationItems);