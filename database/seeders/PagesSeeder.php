<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;

class PagesSeeder extends Seeder
{
    /**
     * Conteúdo institucional real do site original da Prefeitura de Sairé
     * (extraído de database/db/base.sql), recriado aqui para que o seeder
     * também restaure as páginas usadas pelo menu de navegação.
     */
    public function run()
    {
        Page::insert([
            [
                'id' => 1,
                'title' => 'Município',
                'content' => '<h2 style="text-align:center;"><span class="text-huge" style="font-family:Georgia, serif;"><strong>Sairé - PE</strong></span></h2><p>&nbsp;Sairé é uma simpática <span style="font-family:Arial, Helvetica, sans-serif;">cidade</span>, <span style="font-family:Arial, Helvetica, sans-serif;">localizada</span> na região do agreste central de Pernambuco, a cerca de 115 km do Recife. O acesso é simples e r ápido pela BR232 até a cidade de Bezerros, e de lá, seguindo pela PE 103, até o trevo onde está o portal de entrada, no quilômetro 10. Numa viagem tranquila e apreciável, o viajante leva menos de uma hora e meia para chegar até o centro da pacata e hospitaleira urbe com pouco mais de dez mil habitantes e descobrir os segredos e surpresas da vida interiorana.</p><p style="text-align:justify;">O cartão de visita oferecido pela cidade é o clima aconchegante com temperaturas variáveis de acordo com a época do ano. Os 663 metros acima do nível do mar, os brejos de altitude e pluviosidade acima da média proporcionam não apenas sensações prazerosas, nas quatro estações do ano, mas também muitas oportunidades econômicas.</p><p style="text-align:justify;">A propósito, no verão, ventos húmidos e refrescantes propiciam agradáveis dias para as mais diferentes atividades e aventuras, sendo as noites atravessadas por brisas amenas e suaves. Já no inverno, frios leves e suportáveis tornam o clima gostoso para reuniões familiares, boas conversas e noites de sono sossegadas.</p><p style="text-align:justify;">Igrejas tocando sinos, ruas antigas, casarões do início do século XX, praças repletas de pessoas jogando conversa fora, encenam cenário bucólicos e temporalidades distintas. O turista é convidado a caminhar no parque, visitar o museu, assistir a uma partida de futebol no estádio municipal ou tomar um lanche se deliciando com as guloseimas caseiras. À noite, pode assistir à missa, frequentar o culto evangélico ou simplesmente esquecer o tempo num restaurante com os amigos, saboreando a culinária local.</p><p style="text-align:justify;">Fundado em 23 de dezembro de 1963 com uma área de 195,457 km², o município congrega, em seu território, sítios, chácaras, ranchos, fazendas, hotéis-fazendas e diversos empreendimentos rurais ligados a atividades agros pastoris que podem ser encontrados canto a canto. A esse respeito, chama atenção a área que atravessa a BR232 até o distrito de Insurreição, na divisa com Gravatá, na qual se instalam indústrias, casas comerciais e condomínios residenciais de alto padrão.</p><p style="text-align:justify;">As áreas rurais são bastante exploradas e fomentam o eco turismo. Os visitantes se deleitam com o clima da serra, o verde farto em várias tonalidades das paisagens e os pomares cheios de frutas cítricas da região. Passeios, caminhadas, cavalgadas, trilhas, banho de açude, banho de bica e até esportes radicais são atrativos que seduzem todos aqueles que conhecem a “terra da laranja” como é popularmente chamada a cidade por seus moradores orgulhosos e felizes por ali residirem.</p><p style="text-align:justify;">A tradição fala mais alto quando se observam as manifestações culturais dos saireenses.</p><p style="text-align:justify;">A festa, em honra ao padroeiro São Miguel Arcanjo, é sem dúvida o ritual religioso mais antigo, porém desde meados dos anos 80, a Festa da Laranja se destacou como a maior festa de rua entre as cidades do agreste. O mês Mariano, por sua vez, é outra tradição carregada de simbolismo e devoção, no qual os católicos realizam celebrações, quermesses, leilões e queimas de fogos de artifício, durante praticamente os trinta e um dias do mês de maio, tanto na cidade como na zona rural. Os noiteiros religiosos prestigiam às famílias, instituições e profissões. A noite dos motoristas, no dia 31, é o ponto culminante das celebrações.</p><p style="text-align:justify;">Os festejos de junho, em homenagem aos santos católicos, constituem outro momento singular da cultura da cidade e envolve o sagrado e o profano em rituais diversificados, sendo o festival do Buscapé aquele que atrai centenas de curiosos para verem o artefato pirotécnico com as faixas de fogo luminosos rasgando os ares pra lá e pra cá, num movimento que mistura beleza e adrenalina. As noites juninas são animadas, também, com muito forró, quadrilhas, comidas típicas e apresentações culturais de toda natureza.</p><p style="text-align:justify;">Por fim, durante o ano inteiro o calendário cívico-cultural da cidade destaca eventos como o espetáculo da Paixão de Cristo, o desfile de Sete de Setembro, a Caminhada do Forró e muitas outras manifestações que movimentam a cena cultural saireense. Além disso, artesãos, poetas, cordelista, repentistas, violeiros, declamadores, cantores populares e artistas em geral dão vida e alegria ao cotidiano local expressando seu talento e suas inspirações.</p>',
                'created_at' => '2023-03-04 18:34:05',
                'updated_at' => '2023-03-05 04:32:58',
                'deleted_at' => null,
            ],
            [
                'id' => 3,
                'title' => 'Secretarias',
                'content' => '<h2><span class="text-huge">SECRETARIAS</span></h2><p><strong>Administração e planejamento</strong></p><p><strong>ATRIBUIÇÕES</strong></p><p>À Secretaria de Administração e planejamento é subordinada diretamente ao Chefe do Executivo do Governo Municipal, compete o planejamento, desenvolvimento e coordenação dos sistemas administrativos de gestão de pessoal, patrimônio, materiais comunicações internas, no âmbito da administração pública municipal, bem como, promover, supervisionar e avaliar a execução de planos e projetos de tecnologia da informação e promover a modernização administrativa do município e o desenvolvimento organizacional aplicados à administração pública municipal, servindo como órgão disciplinador dos sistemas de compras, licitações e contratos e de suporte para outras Secretarias.</p><p><strong>Governo</strong></p><p><strong>ATRIBUIÇÕES</strong></p><p>À Secretaria de Governo, subordinada diretamente ao Chefe do Executivo do Governo Municipal, compete a promoção e articulação direta do Executivo com os demais poderes, coordenando suas atividades políticas, cívicas e de representação entre os órgãos e entidades, articulação social, assim como realizar a coordenação da política de comunicação, inclusive digital, sendo responsável pela publicação dos atos e expedientes na imprensa oficial, além de definir medidas que assegurem o cumprimento da Constituição, leis e decretos.</p><p><strong>Desenvolvimento Econômico e Turismo</strong></p><p><strong>ATRIBUIÇÕES</strong></p><p>À Secretaria de Desenvolvimento Econômico e Turismo, é responsável por planejar e promover o desenvolvimento econômico sustentável, em articulação com o Estado, União e Sociedade Civil. Promover e apoiar ações e atividades de incentivo à ciência, tecnologia e inovação, desenvolver a política municipal de turismo, fortalecer o trade turístico municipal, promovendo e apoiando ações correlatas, garantir a eficácia dos investimentos públicos e privados, em especial aqueles considerados estratégicos para a geração de emprego e renda, planejar, desenvolver ações e programas de implantação de empreendimentos estruturadores da economia local e regional, promover políticas de microcrédito e fomento ao empreendedorismo local, pesquisar, identificar, prospectar e apoiar investimentos voltados à expansão das atividades produtivas do Município. Planejar e incentivar parcerias com a iniciativa privada, ações e programas de implantação de empreendimentos estruturadores e fomentadores da economia municipal.</p><p><strong>Agricultura e Meio Ambiente</strong></p><p><strong>ATRIBUIÇÕES</strong></p><p>Compete a Secretaria de Agricultura e Meio Ambiente, coordenar, formular, executar, avaliar e atualizar a política agrícola municipal, especialmente voltada à agricultura familiar, de acordo com as características e peculiaridades de cada região, conservação e recuperação das estradas rurais, coordenar e implementar ações relacionadas ao abastecimento, armazenamento e comercialização de insumos, gêneros alimentícios e produtos agropecuários, executando ações de abastecimento de água, assistência técnica e extensão rural, implementar programas de irrigação e executar obras, produtos e serviços tocantes a recursos hídricos relacionados com a infraestrutura rural, em articulação com órgãos e entidades estaduais e federais.</p><p><strong>Educação e Esportes</strong></p><p><strong>ATRIBUIÇÕES</strong></p><p>São atribuições da Secretaria de Educação e Esportes, garantir o acesso da população à educação básica e manter a rede pública municipal de ensino, além de promover ações articuladas com os entes estaduais e federais de educação e supervisionar instituições públicas da rede municipal de educação, de elaborar, implantar e acompanhar políticas educacionais voltadas para a melhoria da qualidade do ensino, modernização pedagógica e da capacitação do quadro técnico da educação municipal, desenvolver políticas de ampliação do acesso à educação integral e formular, implementar, acompanhar e avaliar as políticas municipais de educação, bem como, desenvolver política e executar ações de promoção de esporte e lazer no município.</p><p><strong>Infraestrutura e Serviços Urbanos</strong></p><p><strong>ATRIBUIÇÕES</strong></p><p>Compete a Secretaria de Infraestrutura e serviços Urbanos, formular, aprovar, gerir, normatizar e fiscalizar a execução de programas, projetos e sistemas relativos à execução de obras e serviços de engenharia de infraestrutura urbana, orientar e gerir a execução de programas e projetos para a construção, manutenção e reforma de edifícios e equipamentos da Administração Pública Municipal, fiscalização destes projetos e de programas e obras realizados em parceria com o governo federal e estadual ou com instituições privadas ou do terceiro setor, prestar assistência direta ao prefeito, no desempenho de suas atribuições, planejar, projetar, orçar, coordenar, executar e fiscalizar as obras públicas do Governo Municipal, executar obras de saneamento básico, promover os serviços de reposição, construção, conservação e pavimentação das vias públicas, executar as obras e/ou reparos solicitados pelas demais Secretarias, em articulação com seus setores específicos de prédios e equipamentos, promover a execução de desenhos das obras projetadas, mapas e gráficos necessários aos serviços, elaborar as especificações dos materiais a serem aplicados na execução das obras projetadas, tendo em vista o tipo de acabamento da obra.</p><p><strong>Saúde</strong></p><p><strong>ATRIBUIÇÕES</strong></p><p>Compete a Secretaria de Saúde, planejar, desenvolver e executar a política de atendimento integral das necessidades de saúde da população. Desenvolver políticas de fortalecimento ao sistema de atendimento especializado e complementação da rede hospitalar e ambulatorial do município, bem como exercer as atividades de fortalecimento da rede de atenção básica e psicossocial, coordenar e acompanhar o processo de municipalização do Sistema Único de Saúde (SUS) e planejar, desenvolver e executar a política sanitária municipal implementando ações e programas de vigilância ambiental, epidemiológica, sanitária e de vacinação.&nbsp;</p><p><strong>Ação Social e Cidadania</strong></p><p><strong>ATRIBUIÇÕES</strong></p><p>Compete a Secretaria de Ação Social e Cidadania, articular, planejar, coordenar, controlar, propor e executar as atividades das políticas públicas para as áreas de direitos humanos, cidadania e qualidade de vida, inclusive a gestão de equipamentos públicos com tais finalidades, visando o desenvolvimento social do município e garantia dos direitos fundamentais da pessoa, planejar e executar ações de promoção da redução da vulnerabilidade social, em especial das crianças e adolescentes, dos jovens, idosos, das pessoas com deficiência, da comunidade LGBT e das comunidades tradicionais, no combate à desigualdade étnico-racial, social e humana, a gestão de programas habitacionais para atendimentos de pessoas em estado de vulnerabilidade, inclusive em articulação com outras esferas de governo, promover atividades correlatas para redução da desigualdade social no Município.</p><p><strong>Finanças e Orçamento</strong></p><p><strong>ATRIBUIÇÕES</strong></p><p>À Secretaria de Finanças e Orçamento, compete o planejamento, desenvolvimento e acompanhamento de ações que visem o desenvolvimento territorial, econômico, social e de inovação do município, bem como coordenar o processo de planejamento municipal e a descentralização das ações por meio da gestão estratégica, territorial e participativa no planejamento, aprimorando o modelo de gestão municipal e a captação de recursos para projetos estratégicos, promover e apoiar o desenvolvimento científico-técnico em gestão pública dos servidores municipais.</p>',
                'created_at' => '2023-03-05 01:28:31',
                'updated_at' => '2023-03-05 04:32:19',
                'deleted_at' => null,
            ],
        ]);

        $this->createGovernoMunicipalPage();
    }

    /**
     * Criada à parte (via create(), não insert()) porque precisa de uma
     * instância real do model para anexar as fotos do prefeito/vice via
     * Spatie Media Library — mesma coleção ("ck-media") usada pelo upload
     * de imagem inline do CKEditor em produção (ver MediaUploadingTrait /
     * PagesController::storeCKEditorImages).
     */
    private function createGovernoMunicipalPage(): void
    {
        // forceCreate(): 'id' não está no $fillable do model, e o
        // MenusSeeder depende de page_id=2 apontar exatamente para esta
        // página (mesmo id usado na base original).
        $page = Page::forceCreate([
            'id' => 2,
            'title' => 'Governo Municipal',
            'content' => '',
            'created_at' => '2023-03-05 01:15:03',
            'updated_at' => '2026-03-02 02:56:31',
        ]);

        $prefeitaUrl = $page->addMedia(database_path('fake_media/governo_municipal/prefeita.png'))
            ->preservingOriginal()
            ->toMediaCollection('ck-media')
            ->getUrl();

        $vicePrefeitoUrl = $page->addMedia(database_path('fake_media/governo_municipal/vice-prefeito.png'))
            ->preservingOriginal()
            ->toMediaCollection('ck-media')
            ->getUrl();

        $page->update([
            'content' => '<h2><strong>PREFEITA</strong></h2>'
                .'<p><img src="'.$prefeitaUrl.'" alt="Prefeita - Prefeitura de Sairé - PE"></p>'
                .'<p>MARIA HELENA CAVALCANTI</p>'
                .'<h2 style="text-align:right;"><strong>VICE – PREFEITO</strong></h2>'
                .'<p style="text-align:right;"><img src="'.$vicePrefeitoUrl.'" alt="Vice-Prefeito - Prefeitura de Sairé - PE"></p>'
                .'<p style="text-align:right;">ROBERTO WANDERLEY LIMA</p>',
        ]);
    }
}
