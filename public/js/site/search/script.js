// publications
function loadPublications(p, s, imageDefault) {
  
  showSpinner('publications');
  $.ajax({
  url: '/pesquisa/publications',
  type: 'GET',
  data: { page: p, search: s },
  success: function(response) {  
   console.log("pub", response);
      
    // content
    const content = $('.items-content#publications');

    function info(message){
      const infocontent = $('<div>').addClass('info-content');
      const infocontent_p = $('<p>').html(message);
      content.css('overflow', 'hidden');
      content.empty();
      content.append(infocontent);
      infocontent.append(infocontent_p);
    }

    if(response.data.length > 0){

          const items = $.map(response.data.reverse(), function(item) {
          
          const cardcontainer = $('<div>').addClass('card-container');
          const cardimage = $('<img>').addClass('card-image');
          if (item.photos.length == 0) {
            cardimage.attr('src', `${imageDefault}`);
          } else {
            cardimage.attr('src', `${item.photos[0].url}`);
          }
          
          const cardcontent = $('<div>').addClass('card-content');
          const maincontent = $('<div>').addClass('main-content');
          const maincontent_h1 = $('<h1>');
          const maincontent_a = $('<a>').html(`${item.title}`);
          const maincontent_p = $('<p>').html(`${(he.decode(item.text)).slice(0, 170 - 5) + "..."}`);
          const flexrow = $('<div>').addClass('flex-row');
          const coinbase = $('<div>').addClass('coin-base');
          const coinbase_h2 = $('<h2>').html(`${he.decode(`<a href="/noticias/${(item.title).replace(/\s+/g, '_')}"> Ler Mais </a>`)}`);
          const timeleft = $('<div>').addClass('time-left');
          const timeleft_smallimage = $('<img>').addClass('small-image');
          timeleft_smallimage.attr('src', "https://i.postimg.cc/prpyV4mH/clock-selection-no-bg.png");
          const timeleft_p = $('<p>').html(`${item.created_at}`);
          const cardattribute = $('<div>').addClass('card-attribute');
          const cardtags = $('<div>').addClass('card-tags');
          const cardtags_p = $.map(item.categories, function(category) {

            const p = $('<p>').html(`${category.title}`);

            return p;

          });
        
          cardcontainer.append(cardcontent);
          cardcontent.append(cardimage);
          cardcontent.append(maincontent);
          maincontent.append(maincontent_h1);
          maincontent_h1.append(maincontent_a);
          maincontent.append(maincontent_p);
          maincontent.append(flexrow);
          flexrow.append(coinbase);
          coinbase.append(coinbase_h2);
          flexrow.append(timeleft);
          timeleft.append(timeleft_smallimage);
          timeleft.append(timeleft_p);
          cardcontainer.append(cardattribute);
          cardattribute.append(cardtags);
          cardtags.append(cardtags_p);

          return cardcontainer;

          });

        
        content.empty();
        content.append(...items);

        // page
        
        const next = response.current_page == response.last_page? 0 :
        (response.last_page - response.current_page) >= 3? 3 : 
        (response.last_page - response.current_page);

        const previus =  response.current_page == 1? 0 :
        (response.current_page - 1) >= 3? 3 : 
        (response.current_page - 1);

        const currentPage = response.current_page
        const lastPage = response.last_page
        const nextPages = []
        const previusPages = []

        for(let i = (response.current_page + 1); i <= (response.current_page + next); i++) {
          nextPages.push([i]);
        }

        for(let i = (response.current_page - 1); i >= (response.current_page - previus); i--) {
          previusPages.push([i]);
        }

      const pagination = $('.pagination#publications');
      const pagesnext = $('<div>').addClass('pages');
      
      pagination.empty();
      pagination.append(pagesnext);

      const nextPaginations = $.map(nextPages, function(page) {
      const pages = $('<div>').addClass('page');
      pages.on('click', function() {
        loadPublications(page[0], s, imageDefault);
      });
      const pageInPages = $('<a>').html(page);
      // pageInPages.attr('href', url + '/?page=' + page);
      pages.append(pageInPages);

      return pages;
      });

      pagesnext.append(...nextPaginations);

      if (next != 0) {
      const pagelast = $('<div>').addClass('page').addClass('page-control');
      pagelast.on('click', function() {
        loadPublications(lastPage, s, imageDefault);
      });
      const pageInPagelast = $('<a>').html('<i class="fa-solid fa-caret-right"></i><i class="fa-solid fa-caret-right"></i>');
      // pageInPagelast.attr('href', url + '/?page=' + lastPage);
      pagelast.append(pageInPagelast);
      pagesnext.append(pagelast);
      }

      const pagecurrent = $('<div>').addClass('pages');
      pagination.append(pagecurrent);

      if (currentPage - 1 != 0) {
      const pageprevius = $('<div>').addClass('page').addClass('page-control');
      pageprevius.on('click', function() {
        loadPublications(currentPage - 1, s, imageDefault);
      });
      const pageInPageprevius = $('<a>').html('<i class="fa-solid fa-caret-left"></i>');
      // pageInPageprevius.attr('href', url + '/?page=' + (currentPage - 1));
      pagecurrent.append(pageprevius);
      pageprevius.append(pageInPageprevius);
      }

      const pages = $('<div>').addClass('page').addClass('active');
      pages.on('click', function() {
        loadPublications(currentPage, s, imageDefault);
      });
      const pageInPages = $('<a>').html(currentPage);
      // pageInPages.attr('href', url + '/?page=' + currentPage);
      pagecurrent.append(pages);
      pages.append(pageInPages);

      if (currentPage != lastPage) {
      const pagenext = $('<div>').addClass('page').addClass('page-control');
      pagenext.on('click', function() {
        loadPublications(parseInt(currentPage) + 1, s, imageDefault);
      });
      const pageInPagenext = $('<a>').html('<i class="fa-solid fa-caret-right"></i>');
      // pageInPagenext.attr('href', url + '/?page=' + (parseInt(currentPage) + 1));
      pagecurrent.append(pagenext);
      pagenext.append(pageInPagenext);
      }

      const pagesprevius = $('<div>').addClass('pages');
      pagination.append(pagesprevius);

      const previusPaginations = $.map(previusPages.reverse(), function(page) {
      const pages = $('<div>').addClass('page');
      pages.on('click', function() {
        loadPublications(page[0], s, imageDefault);
      });
      const pageInPages = $('<a>').html(page);
      // pageInPages.attr('href', url + '/?page=' + page);
      pages.append(pageInPages);

      return pages;
      });

      if (currentPage != 1) {
      const pagefirst = $('<div>').addClass('page').addClass('page-control');
      pagefirst.on('click', function() {
        loadPublications(1, s, imageDefault);
      });
      const pageInPagefirst = $('<a>').html('<i class="fa-solid fa-caret-left"></i><i class="fa-solid fa-caret-left"></i>');
      // pageInPagefirst.attr('href', url + '/?page=' + 1);
      pagefirst.append(pageInPagefirst);
      pagesprevius.append(pagefirst);
      }

      pagesprevius.append(...previusPaginations);
  
    } else {
      info('Desculpe, mas não encontramos resultados para a sua busca. Por favor, tente novamente com palavras diferentes ou revise os termos utilizados.');
    }
    hideSpinner('publications');
  },
  error: function(xhr) {
      info('Desculpe, ocorreu um erro e não foi possível exibir os resultados da busca. Por favor, tente novamente ou entre em contato com o suporte para obter assistência.');
      hideSpinner('publications');
    console.log(xhr.responseText);
  }
  });
}

// pages
function loadPages(p, s, imageDefault) {
  
  showSpinner('page');

  $.ajax({
  url: '/pesquisa/pages',
  type: 'GET',
  data: { page: p, search: s },
  success: function(response) {
    console.log("page", response);

    // content
    const content = $('.items-content#page');

    function info(message){
      const infocontent = $('<div>').addClass('info-content');
      const infocontent_p = $('<p>').html(message);
      content.css('overflow', 'hidden');
      content.empty();
      content.append(infocontent);
      infocontent.append(infocontent_p);
    }

    if(response.data.length > 0){
      const items = $.map(response.data.reverse(), function(item) {
      
        const cardcontainer = $('<div>').addClass('card-container');
        const cardimage = $('<img>').addClass('card-image');
        if (item.photos.length == 0) {
          cardimage.attr('src', `${imageDefault}`);
        } else {
          cardimage.attr('src', `${item.photos[0].url}`);
        }
        
        const cardcontent = $('<div>').addClass('card-content');
        const maincontent = $('<div>').addClass('main-content');
        const maincontent_h1 = $('<h1>');
        const maincontent_a = $('<a>').html(`${item.title}`);
        //const maincontent_p = $('<p>').html(`${(he.decode(item.content)).slice(0, 170 - 5) + "..."}`);
        const flexrow = $('<div>').addClass('flex-row');
        const coinbase = $('<div>').addClass('coin-base');
        const coinbase_h2 = $('<h2>').html(`${he.decode(`<a href="/pagina/${(item.title).replace(/\s+/g, '_')}"> Ler Mais </a>`)}`);
        const timeleft = $('<div>').addClass('time-left');
        const timeleft_smallimage = $('<img>').addClass('small-image');
        timeleft_smallimage.attr('src', "https://i.postimg.cc/prpyV4mH/clock-selection-no-bg.png");
        const timeleft_p = $('<p>').html(`${item.created_at}`);
      
        cardcontainer.append(cardcontent);
        cardcontent.append(cardimage);
        cardcontent.append(maincontent);
        maincontent.append(maincontent_h1);
        maincontent_h1.append(maincontent_a);
        //maincontent.append(maincontent_p);
        maincontent.append(flexrow);
        flexrow.append(coinbase);
        coinbase.append(coinbase_h2);
        flexrow.append(timeleft);
        timeleft.append(timeleft_smallimage);
        timeleft.append(timeleft_p);
  
        return cardcontainer;
  
        });
  
      
      content.empty();
      content.append(...items);
  
      // page
      
      const next = response.current_page == response.last_page? 0 :
      (response.last_page - response.current_page) >= 3? 3 : 
      (response.last_page - response.current_page);
  
      const previus =  response.current_page == 1? 0 :
      (response.current_page - 1) >= 3? 3 : 
      (response.current_page - 1);
  
      const currentPage = response.current_page
      const lastPage = response.last_page
      const nextPages = []
      const previusPages = []
  
      for(let i = (response.current_page + 1); i <= (response.current_page + next); i++) {
        nextPages.push([i]);
      }
  
      for(let i = (response.current_page - 1); i >= (response.current_page - previus); i--) {
        previusPages.push([i]);
      }
  
      const pagination = $('.pagination#page');
      const pagesnext = $('<div>').addClass('pages');
      
      pagination.empty();
      pagination.append(pagesnext);
    
      const nextPaginations = $.map(nextPages, function(page) {
      const pages = $('<div>').addClass('page');
      pages.on('click', function() {
        loadPages(page[0], s, imageDefault);
      });
      const pageInPages = $('<a>').html(page);
      // pageInPages.attr('href', url + '/?page=' + page);
      pages.append(pageInPages);
    
      return pages;
      });
    
      pagesnext.append(...nextPaginations);
    
      if (next != 0) {
      const pagelast = $('<div>').addClass('page').addClass('page-control');
      pagelast.on('click', function() {
        loadPages(lastPage, s, imageDefault);
      });
      const pageInPagelast = $('<a>').html('<i class="fa-solid fa-caret-right"></i><i class="fa-solid fa-caret-right"></i>');
      // pageInPagelast.attr('href', url + '/?page=' + lastPage);
      pagelast.append(pageInPagelast);
      pagesnext.append(pagelast);
      }
    
      const pagecurrent = $('<div>').addClass('pages');
      pagination.append(pagecurrent);
    
      if (currentPage - 1 != 0) {
      const pageprevius = $('<div>').addClass('page').addClass('page-control');
      pageprevius.on('click', function() {
        loadPages(currentPage - 1, s, imageDefault);
      });
      const pageInPageprevius = $('<a>').html('<i class="fa-solid fa-caret-left"></i>');
      // pageInPageprevius.attr('href', url + '/?page=' + (currentPage - 1));
      pagecurrent.append(pageprevius);
      pageprevius.append(pageInPageprevius);
      }
    
      const pages = $('<div>').addClass('page').addClass('active');
      pages.on('click', function() {
        loadPages(currentPage, s, imageDefault);
      });
      const pageInPages = $('<a>').html(currentPage);
      // pageInPages.attr('href', url + '/?page=' + currentPage);
      pagecurrent.append(pages);
      pages.append(pageInPages);
    
      if (currentPage != lastPage) {
      const pagenext = $('<div>').addClass('page').addClass('page-control');
      pagenext.on('click', function() {
        loadPages(parseInt(currentPage) + 1, s, imageDefault);
      });
      const pageInPagenext = $('<a>').html('<i class="fa-solid fa-caret-right"></i>');
      // pageInPagenext.attr('href', url + '/?page=' + (parseInt(currentPage) + 1));
      pagecurrent.append(pagenext);
      pagenext.append(pageInPagenext);
      }
    
      const pagesprevius = $('<div>').addClass('pages');
      pagination.append(pagesprevius);
    
      const previusPaginations = $.map(previusPages.reverse(), function(page) {
      const pages = $('<div>').addClass('page');
      pages.on('click', function() {
        loadPages(page[0], s, imageDefault);
      });
      const pageInPages = $('<a>').html(page);
      // pageInPages.attr('href', url + '/?page=' + page);
      pages.append(pageInPages);
    
      return pages;
      });
    
      if (currentPage != 1) {
      const pagefirst = $('<div>').addClass('page').addClass('page-control');
      pagefirst.on('click', function() {
        loadPages(1, s, imageDefault);
      });
      const pageInPagefirst = $('<a>').html('<i class="fa-solid fa-caret-left"></i><i class="fa-solid fa-caret-left"></i>');
      // pageInPagefirst.attr('href', url + '/?page=' + 1);
      pagefirst.append(pageInPagefirst);
      pagesprevius.append(pagefirst);
      }
    
      pagesprevius.append(...previusPaginations);
    } else {
      info('Desculpe, mas não encontramos resultados para a sua busca. Por favor, tente novamente com palavras diferentes ou revise os termos utilizados.');
    }
    hideSpinner('page');
  },
  error: function(xhr) {
    console.log(xhr.responseText);
    info('Desculpe, ocorreu um erro e não foi possível exibir os resultados da busca. Por favor, tente novamente ou entre em contato com o suporte para obter assistência.');
    hideSpinner('page');
  }
  });
}

    // display imagens event
    const display_imagen = document.querySelector(".display-imagen");
    var itemcurrent = {};

    function display(item, i) {
        itemcurrent = {
          index: i,
          item: item,
          qunt: item.photos.length
        };
        console.log(itemcurrent)
        const imagen = document.querySelector(".display-imagen img");
        imagen.src = item.photos[i].url;
        const title = document.querySelector("#title p");
        title.innerHTML = `${item.title}`;
        const description = document.querySelector("#description p");
        description.innerHTML = `${item.description}`;
        const date = document.querySelector("#date p");
        date.innerHTML = `${item.created_at}`;
        const categories = document.querySelector(".categories-items");
        const items_in_categories = item.categories.map(function(category){

            const p = document.createElement("p");
            p.innerHTML = category.title;

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

    const previous_image = document.querySelector("#previous");

    previous_image.addEventListener("click", () => {
        if(itemcurrent.index == 0){
            display(itemcurrent.item, (itemcurrent.qunt - 1));
        } else {
          display(itemcurrent.item, (itemcurrent.index - 1));
        }
    });

    const next_image = document.querySelector("#next");

    next_image.addEventListener("click", () => {
        if(itemcurrent.index == (itemcurrent.qunt - 1)){
          display(itemcurrent.item, 0);
        } else {
          display(itemcurrent.item, (itemcurrent.index + 1));
        }
      
    });

const openDetails = document.querySelector(".open-details");
const details = document.querySelector(".details-item");

openDetails.addEventListener("click", () => {
  console.log(details.getAttribute("visible"))
    details.getAttribute("visible")  === "false"?
        details.setAttribute("visible", "true") :
        details.setAttribute("visible", "false")

});

//galleries
function loadGalleries(p, s) {
  
  showSpinner('galleries');
  $.ajax({
  url: '/pesquisa/galleries',
  type: 'GET',
  data: { page: p, search: s },
  success: function(response) {  
   console.log("galle", response);
      
    // content
    const content = $('.items-content#galleries');

    // info event
    function info(message){
      const infocontent = $('<div>').addClass('info-content');
      const infocontent_p = $('<p>').html(message);
      content.css('overflow', 'hidden');
      content.empty();
      content.append(infocontent);
      infocontent.append(infocontent_p);
    }

    //load card content
    if(response.data.length > 0){

          const items = $.map(response.data.reverse(), function(item) {
          
          const cardcontainer = $('<div>').addClass('card-container');
          const cardimage = $('<img>').addClass('card-image');
          cardimage.attr('src', `${item.photos[0].url}`);

          
          const cardcontent = $('<div>').addClass('card-content');
          const maincontent = $('<div>').addClass('main-content');
          const maincontent_h1 = $('<h1>');
          const maincontent_a = $('<a>').html(`${item.title}`);
          const maincontent_p = $('<p>').html(`${(he.decode(item.description)).slice(0, 170 - 5) + "..."}`);
          const flexrow = $('<div>').addClass('flex-row');
          const coinbase = $('<div>').addClass('coin-base');
          const coinbase_h2 = $('<h2>').html(`<a> Ver Imagens </a>`);
          coinbase_h2.on('click', function() {
            display(item, 0)
            console.log(item)
          });
          const timeleft = $('<div>').addClass('time-left');
          const timeleft_smallimage = $('<img>').addClass('small-image');
          timeleft_smallimage.attr('src', "https://i.postimg.cc/prpyV4mH/clock-selection-no-bg.png");
          const timeleft_p = $('<p>').html(`${item.created_at}`);
          const cardattribute = $('<div>').addClass('card-attribute');
          const cardtags = $('<div>').addClass('card-tags');
          const cardtags_p = $.map(item.categories, function(category) {

            const p = $('<p>').html(`${category.title}`);

            return p;

          });
        
          cardcontainer.append(cardcontent);
          cardcontent.append(cardimage);
          cardcontent.append(maincontent);
          maincontent.append(maincontent_h1);
          maincontent_h1.append(maincontent_a);
          maincontent.append(maincontent_p);
          maincontent.append(flexrow);
          flexrow.append(coinbase);
          coinbase.append(coinbase_h2);
          flexrow.append(timeleft);
          timeleft.append(timeleft_smallimage);
          timeleft.append(timeleft_p);
          cardcontainer.append(cardattribute);
          cardattribute.append(cardtags);
          cardtags.append(cardtags_p);

          return cardcontainer;

          });

        
        content.empty();
        content.append(...items);

        // page
        
        const next = response.current_page == response.last_page? 0 :
        (response.last_page - response.current_page) >= 3? 3 : 
        (response.last_page - response.current_page);

        const previus =  response.current_page == 1? 0 :
        (response.current_page - 1) >= 3? 3 : 
        (response.current_page - 1);

        const currentPage = response.current_page
        const lastPage = response.last_page
        const nextPages = []
        const previusPages = []

        for(let i = (response.current_page + 1); i <= (response.current_page + next); i++) {
          nextPages.push([i]);
        }

        for(let i = (response.current_page - 1); i >= (response.current_page - previus); i--) {
          previusPages.push([i]);
        }

      const pagination = $('.pagination#galleries');
      const pagesnext = $('<div>').addClass('pages');
      
      pagination.empty();
      pagination.append(pagesnext);

      const nextPaginations = $.map(nextPages, function(page) {
      const pages = $('<div>').addClass('page');
      pages.on('click', function() {
        loadGalleries(page[0], s);
      });
      const pageInPages = $('<a>').html(page);
      // pageInPages.attr('href', url + '/?page=' + page);
      pages.append(pageInPages);

      return pages;
      });

      pagesnext.append(...nextPaginations);

      if (next != 0) {
      const pagelast = $('<div>').addClass('page').addClass('page-control');
      pagelast.on('click', function() {
        loadGalleries(lastPage, s);
      });
      const pageInPagelast = $('<a>').html('<i class="fa-solid fa-caret-right"></i><i class="fa-solid fa-caret-right"></i>');
      // pageInPagelast.attr('href', url + '/?page=' + lastPage);
      pagelast.append(pageInPagelast);
      pagesnext.append(pagelast);
      }

      const pagecurrent = $('<div>').addClass('pages');
      pagination.append(pagecurrent);

      if (currentPage - 1 != 0) {
      const pageprevius = $('<div>').addClass('page').addClass('page-control');
      pageprevius.on('click', function() {
        loadGalleries(currentPage - 1, s);
      });
      const pageInPageprevius = $('<a>').html('<i class="fa-solid fa-caret-left"></i>');
      // pageInPageprevius.attr('href', url + '/?page=' + (currentPage - 1));
      pagecurrent.append(pageprevius);
      pageprevius.append(pageInPageprevius);
      }

      const pages = $('<div>').addClass('page').addClass('active');
      pages.on('click', function() {
        loadGalleries(currentPage, s);
      });
      const pageInPages = $('<a>').html(currentPage);
      // pageInPages.attr('href', url + '/?page=' + currentPage);
      pagecurrent.append(pages);
      pages.append(pageInPages);

      if (currentPage != lastPage) {
      const pagenext = $('<div>').addClass('page').addClass('page-control');
      pagenext.on('click', function() {
        loadGalleries(parseInt(currentPage) + 1, s);
      });
      const pageInPagenext = $('<a>').html('<i class="fa-solid fa-caret-right"></i>');
      // pageInPagenext.attr('href', url + '/?page=' + (parseInt(currentPage) + 1));
      pagecurrent.append(pagenext);
      pagenext.append(pageInPagenext);
      }

      const pagesprevius = $('<div>').addClass('pages');
      pagination.append(pagesprevius);

      const previusPaginations = $.map(previusPages.reverse(), function(page) {
      const pages = $('<div>').addClass('page');
      pages.on('click', function() {
        loadGalleries(page[0], s);
      });
      const pageInPages = $('<a>').html(page);
      // pageInPages.attr('href', url + '/?page=' + page);
      pages.append(pageInPages);

      return pages;
      });

      if (currentPage != 1) {
      const pagefirst = $('<div>').addClass('page').addClass('page-control');
      pagefirst.on('click', function() {
        loadGalleries(1, s);
      });
      const pageInPagefirst = $('<a>').html('<i class="fa-solid fa-caret-left"></i><i class="fa-solid fa-caret-left"></i>');
      // pageInPagefirst.attr('href', url + '/?page=' + 1);
      pagefirst.append(pageInPagefirst);
      pagesprevius.append(pagefirst);
      }

      pagesprevius.append(...previusPaginations);
  
    } else {
      info('Desculpe, mas não encontramos resultados para a sua busca. Por favor, tente novamente com palavras diferentes ou revise os termos utilizados.');
    }
    hideSpinner('galleries');
  },
  error: function(xhr) {
      info('Desculpe, ocorreu um erro e não foi possível exibir os resultados da busca. Por favor, tente novamente ou entre em contato com o suporte para obter assistência.');
      hideSpinner('galleries');
    console.log("erro", xhr.responseText);
  }
  });
}

function showSpinner(id) {
  document.querySelector(`.spinner#${id}`).style.display = "block";
}

function hideSpinner(id) {
  document.querySelector(`.spinner#${id}`).style.display = "none";
}