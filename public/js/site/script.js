
// featured publications

const features = document.querySelector(".features");
const photoDots = document.createElement("div");
photoDots.classList.add("photo-dots");
features.append(photoDots);

var index = 0;

const dots = featuredPublications.map(function(publication, ind) {

  const dots = document.createElement("i");
  dots.setAttribute("active", false);
  dots.setAttribute("data-index", ind);
  dots.classList.add("fa-solid");
  dots.classList.add("fa-circle");

  if(ind == 0){
    dots.setAttribute("active", true);
  }

  dots.addEventListener("click", () => {
    index = ind;
    displayCard();
    photosDots(index);
  });

  return dots;

});

photoDots.append(...dots);

function photosDots(index) {
  const disable = document.querySelector('.photo-dots i[active="true"]')
  const enable = document.querySelector(`.photo-dots i[data-index="${index}"]`)
    if(disable) {
      disable.setAttribute("active", false);
    }
    enable.setAttribute("active", true);
}

const arrows = document.createElement("div");
arrows.classList.add("arrows");
features.append(arrows);

const arrowsPrevious = document.createElement("i");
arrowsPrevious.classList.add("fa-solid");
arrowsPrevious.classList.add("fa-square-caret-left");
arrowsPrevious.addEventListener("click", () => {
  previousCard()
});
arrows.append(arrowsPrevious);

const arrowsNext = document.createElement("i");
arrowsNext.classList.add("fa-solid");
arrowsNext.classList.add("fa-square-caret-right");
arrowsNext.addEventListener("click", () => {
  nextCard()
});
arrows.append(arrowsNext);

const photoCard = document.createElement("div"); 
photoCard.classList.add("photo-card");
features.append(photoCard);

const card = document.createElement("div");
card.classList.add("card");

const cardTitle = document.createElement("div");
cardTitle.classList.add("card-title");

const cardText = document.createElement("div");
cardText.classList.add("card-text");

card.append(cardTitle);
card.append(cardText);
photoCard.append(card);

function displayCard() {
  
  if((featuredPublications[index].photos).length == 0) {
    photoCard.style.backgroundImage = "url('" +  imageDefault + "')";
  } else {
    photoCard.style.backgroundImage = "url('" + featuredPublications[index].photos[0] + "')";
  }


  photoCard.addEventListener("click", () => {
    window.location.href = `noticias/${(featuredPublications[index].title).replace(/\s+/g, '_')}`
  })

  cardTitle.innerHTML = featuredPublications[index].title;

  if ((featuredPublications[index].text).length > 200) {
    cardText.innerHTML = (he.decode(featuredPublications[index].text)).slice(0, 180 - 10) + "...";
  } else {
    cardText.innerHTML = he.decode(featuredPublications[index].text)+ "...";
  }
  
}

function nextCard() {
  index++;
			if (index >= featuredPublications.length) {
				index = 0;
			}
      photosDots(index)
      displayCard();

}

function previousCard() {
  index--;
			if (index < 0) {
				index = featuredPublications.length - 1;
			}
      photosDots(index)
			displayCard();
}

displayCard();
setInterval(nextCard, 5000);

// Gallery

const images = document.querySelector('.images');

const imgs = galleries.map(function(gallery) {
  const photos = [];
  for(let i = 0; i < (gallery.photos).length; i++) {
    const img = document.createElement("img");
    img.src = gallery.photos[i];
    photos.push(img);
  }
  return photos;
});


images.append(...[].concat(...imgs));

// publications

const publicationsDiv = document.querySelector('.publications');

const cards = publications.map(function(publication) {
  const card = document.createElement("div");
  card.classList.add("card-publications");

  card.addEventListener("click", () => {
    window.location.href = `noticias/${(publication.title).replace(/\s+/g, '_')}`
    
  });
  

  if((publication.photos).length == 0) {
    card.style.backgroundImage = "url('" + imageDefault + "')";;  
  } else {
    card.style.backgroundImage = "url('" + publication.photos[0] + "')";
  }
  
  const content = document.createElement("div");
  content.classList.add("content-publications");
  card.append(content);

  const titleContent = document.createElement("div");
  titleContent.classList.add("title-content-publications");
  const titleContentP = document.createElement("p");
  titleContentP.innerHTML = publication.title;
  titleContent.append(titleContentP);
  content.append(titleContent);

  const textContent = document.createElement("div");
  textContent.classList.add("text-content-publications");
  const textContentP = document.createElement("p");
  if ((publication.text).length > 200) {
    textContentP.innerHTML = (he.decode(publication.text)).slice(0, 180 - 10) + "...";
  } else {
    textContentP.innerHTML = he.decode(publication.text) + "...";
  }
  textContent.append(textContentP);
  content.append(textContent)

  return card;
});

publicationsDiv.append(...cards);


