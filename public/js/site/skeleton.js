/**
 * Helper compartilhado de Skeleton Loading para o site público.
 * Sem dependencia de jQuery (a maioria das paginas nao usa).
 */
window.Skeleton = (function () {
    /**
     * Remove o conteudo skeleton (ou qualquer conteudo anterior) de um
     * container antes de montar os cards reais. Nenhum script do site
     * limpava o container antes de "append" — sem isso, o skeleton
     * ficaria "preso" ao lado do conteudo real para sempre.
     */
    function clear(container) {
        if (container) {
            container.innerHTML = '';
        }
    }

    /**
     * Mantem o shimmer ate a imagem real terminar de carregar.
     *
     * mode='src' (<img>): escuta o evento "load" do PROPRIO elemento
     * depois de atribuir o src — nao usa um Image() de pre-carga
     * separado aqui, porque entre o preload terminar e o navegador
     * buscar a mesma URL de novo para o elemento real existe uma folga
     * (sob rede lenta/limitada isso deixava uma janela sem shimmer e
     * sem imagem, tela em branco).
     *
     * mode='background': background-image nao tem evento "load" nativo,
     * entao o pre-carregamento via Image() e a unica forma de saber
     * quando aplicar — mas so troca o CSS depois que a imagem ja esta
     * no cache do navegador, entao a segunda "busca" (pelo background)
     * e instantanea.
     *
     * @param {HTMLElement} el elemento que vai receber a imagem
     * @param {string} url
     * @param {'src'|'background'} mode
     */
    function setImage(el, url, mode) {
        if (!el || !url) {
            return;
        }

        mode = mode || 'src';
        el.classList.add('skeleton-image-loading');

        function clearShimmer() {
            el.classList.remove('skeleton-image-loading');
        }

        if (mode === 'background') {
            const loader = new Image();
            loader.onload = function () {
                el.style.backgroundImage = "url('" + url + "')";
                clearShimmer();
            };
            loader.onerror = clearShimmer;
            loader.src = url;
        } else {
            el.addEventListener('load', clearShimmer, { once: true });
            el.addEventListener('error', clearShimmer, { once: true });
            el.src = url;
        }
    }

    /**
     * Constroi um card skeleton igual ao componente Blade
     * <x-skeleton.card variant="search-result" /> — usado pela pagina de
     * busca, que monta os resultados via AJAX puro (sem Blade no
     * momento da resposta).
     */
    function searchResultCard() {
        const card = document.createElement('div');
        card.className = 'skeleton-card';
        card.style.cssText = 'width:100%;display:flex;flex-direction:row;gap:1em;padding:1em;';

        const image = document.createElement('span');
        image.className = 'skeleton';
        image.style.cssText = 'display:block;width:40%;height:10em;';

        const body = document.createElement('div');
        body.style.cssText = 'flex:1;display:flex;flex-direction:column;gap:0.5em;';

        const title = document.createElement('span');
        title.className = 'skeleton skeleton-title';

        const text = document.createElement('div');
        [1, 2].forEach(function () {
            const line = document.createElement('span');
            line.className = 'skeleton skeleton--text';
            text.appendChild(line);
        });

        const tags = document.createElement('div');
        tags.style.cssText = 'display:flex;gap:6px;margin-top:auto;';
        [['4em'], ['3em']].forEach(function (size) {
            const pill = document.createElement('span');
            pill.className = 'skeleton skeleton--pill';
            pill.style.cssText = 'width:' + size[0] + ';height:1.4em;';
            tags.appendChild(pill);
        });

        body.append(title, text, tags);
        card.append(image, body);

        return card;
    }

    /**
     * Conteudo rico arbitrario (ex.: pagina institucional vinda do
     * editor) ja chega com <img src="..."> prontas no HTML — nao da pra
     * "adiar" o carregamento nem prever o layout. O unico tratamento
     * possivel e individual: aplicar o shimmer em cada <img> ate ela
     * proria disparar "load" (ou ja estar em cache, via img.complete).
     */
    function watchImages(root) {
        (root || document).querySelectorAll('img').forEach(function (img) {
            const clear = function () {
                img.classList.remove('skeleton-image-loading');
            };

            if (img.complete) {
                // Ja pode ter vindo com a classe aplicada direto no HTML
                // (evita o "salto" de layout entre o servidor renderizar
                // sem skeleton e o JS aplicar o shimmer um instante
                // depois) -- se a imagem ja estava em cache, so limpa.
                clear();
                return;
            }

            img.classList.add('skeleton-image-loading');
            img.addEventListener('load', clear);
            img.addEventListener('error', clear);
        });
    }

    return { clear, setImage, searchResultCard, watchImages };
})();
