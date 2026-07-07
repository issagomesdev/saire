<?php

namespace Database\Seeders\Support;

/**
 * Catálogo de tópicos usados por PublicationsSeeder/GalleriesSeeder para
 * gerar notícias realistas. Cada tópico é consumido por
 * NewsContentGenerator (título + corpo) e por MediaCatalog (tema de foto).
 *
 * 'categories' referencia os títulos exatos criados por CategoriesSeeder.
 * 'season' restringe o mês (sazonalidade real: São João em junho, etc.);
 * null = qualquer mês. 'years' restringe o ano (usado só para Covid-19).
 * 'gallery_worthy' marca tópicos que tipicamente também geram uma galeria
 * correspondente (ver LinkedGalleryRegistry).
 */
class MunicipalTopics
{
    public static function all(): array
    {
        return [
            // ------------------------------------------------------------
            // SAÚDE
            // ------------------------------------------------------------
            [
                'key' => 'vacinacao_gripe',
                'categories' => ['Vacinação', 'Saúde', 'Campanhas'],
                'media_theme' => MediaCatalog::THEME_VACINACAO,
                'gallery_worthy' => true,
                'season' => [3, 4, 5],
                'weight' => 3,
                'titles' => [
                    'Prefeitura inicia campanha de vacinação contra a gripe em {neighborhood}',
                    'Campanha contra a influenza chega às unidades de saúde de {neighborhood}',
                    'Vacinação contra a gripe é ampliada para toda a população a partir desta semana',
                    'Postos de saúde aplicam doses contra influenza durante todo o mês',
                ],
                'intro_templates' => [
                    'A Secretaria Municipal de Saúde deu início nesta semana à campanha de vacinação contra a influenza, com atendimento nas unidades básicas de saúde de {neighborhood} e em pontos volantes espalhados pela cidade.',
                    'Começou a campanha municipal de combate à gripe, que deve imunizar milhares de moradores nas próximas semanas nas unidades de saúde do município.',
                ],
                'facts' => [
                    'prioridade para idosos, gestantes e crianças menores de 5 anos',
                    'aplicação de {number} doses previstas para esta etapa',
                    'atendimento em horário estendido às quartas-feiras',
                    'equipes volantes em escolas e igrejas de {neighborhood}',
                    'parceria com o governo estadual para reposição do estoque de vacinas',
                    'apoio de agentes comunitários de saúde na busca ativa de faltosos',
                ],
                'list_label' => 'Confira os principais pontos de vacinação disponíveis nesta campanha:',
                'quote_roles' => ['Secretária Municipal de Saúde', 'coordenador de imunização'],
            ],
            [
                'key' => 'vacinacao_infantil',
                'categories' => ['Vacinação', 'Saúde', 'Criança e Adolescente'],
                'media_theme' => MediaCatalog::THEME_VACINACAO,
                'gallery_worthy' => false,
                'season' => null,
                'weight' => 2,
                'titles' => [
                    'Multivacinação atualiza caderneta de crianças e adolescentes',
                    'Prefeitura promove Dia D de vacinação infantil neste sábado',
                    '{neighborhood} recebe mutirão de atualização vacinal para crianças',
                ],
                'intro_templates' => [
                    'A Prefeitura realizou mais uma etapa da campanha de multivacinação, voltada à atualização da caderneta de vacinação de crianças e adolescentes em atraso com o calendário nacional.',
                    'Pais e responsáveis levaram crianças e adolescentes aos postos de saúde de {neighborhood} durante o mutirão de vacinação promovido pela Secretaria de Saúde.',
                ],
                'facts' => [
                    'checagem gratuita da caderneta de vacinação',
                    'disponibilidade de todos os imunizantes do calendário básico',
                    'atendimento sem necessidade de agendamento prévio',
                    'parceria com as escolas municipais para identificar crianças em atraso',
                    'orientação nutricional oferecida no mesmo espaço',
                ],
                'quote_roles' => ['enfermeira responsável pela sala de vacina', 'Secretária Municipal de Saúde'],
            ],
            [
                'key' => 'combate_dengue',
                'categories' => ['Combate à Dengue', 'Saúde', 'Meio Ambiente'],
                'media_theme' => MediaCatalog::THEME_SAUDE,
                'gallery_worthy' => false,
                'season' => [1, 2, 3, 4, 11, 12],
                'weight' => 3,
                'titles' => [
                    'Prefeitura intensifica combate ao Aedes aegypti em {neighborhood}',
                    'Mutirão contra a dengue percorre bairros da cidade nesta semana',
                    'Casos de dengue motivam força-tarefa em {neighborhood}',
                    'Agentes de endemias reforçam vistorias após aumento de focos do mosquito',
                ],
                'intro_templates' => [
                    'Diante do aumento no número de focos do Aedes aegypti, a Prefeitura reforçou as ações de combate à dengue em {neighborhood}, com visitas casa a casa e mutirões de limpeza.',
                    'A Secretaria de Saúde, em parceria com a Vigilância Ambiental, iniciou uma força-tarefa contra a dengue, a chikungunya e a zika em pontos considerados críticos da cidade.',
                ],
                'facts' => [
                    'visita a {number} imóveis durante a força-tarefa',
                    'recolhimento de materiais que acumulam água parada',
                    'aplicação de larvicida em pontos estratégicos',
                    'orientação porta a porta sobre prevenção',
                    'reforço no monitoramento de terrenos baldios',
                    'divulgação do boletim epidemiológico atualizado',
                ],
                'quote_roles' => ['coordenador de vigilância ambiental', 'Secretária Municipal de Saúde'],
            ],
            [
                'key' => 'inauguracao_ubs',
                'categories' => ['Saúde', 'Infraestrutura', 'Obras'],
                'media_theme' => MediaCatalog::THEME_SAUDE,
                'gallery_worthy' => true,
                'season' => null,
                'weight' => 2,
                'titles' => [
                    'Prefeitura inaugura nova Unidade Básica de Saúde em {neighborhood}',
                    'Moradores de {neighborhood} ganham nova UBS totalmente equipada',
                    'Nova unidade de saúde amplia atendimento à população de {neighborhood}',
                ],
                'intro_templates' => [
                    'A Prefeitura entregou à população de {neighborhood} uma nova Unidade Básica de Saúde, equipada para ampliar o atendimento médico e odontológico na região.',
                    'Foi inaugurada nesta semana a nova UBS de {neighborhood}, obra aguardada há anos pelos moradores da região.',
                ],
                'facts' => [
                    'consultórios médicos e odontológicos climatizados',
                    'sala de vacina e farmácia básica no mesmo prédio',
                    'investimento de {money} em obras e equipamentos',
                    'capacidade para {number} atendimentos por mês',
                    'contratação de novos profissionais de saúde para a unidade',
                    'acessibilidade completa para pessoas com deficiência',
                ],
                'quote_roles' => ['Secretária Municipal de Saúde', 'prefeito'],
            ],
            [
                'key' => 'campanha_outubro_rosa',
                'categories' => ['Saúde', 'Campanhas', 'Mulher'],
                'media_theme' => MediaCatalog::THEME_SAUDE,
                'gallery_worthy' => false,
                'season' => [10],
                'weight' => 2,
                'titles' => [
                    'Outubro Rosa: Prefeitura amplia exames preventivos para mulheres',
                    'Campanha Outubro Rosa oferece mamografias gratuitas em {neighborhood}',
                    'Ação do Outubro Rosa reforça prevenção ao câncer de mama',
                ],
                'intro_templates' => [
                    'Como parte das ações do Outubro Rosa, a Secretaria de Saúde ampliou a oferta de exames preventivos contra o câncer de mama nas unidades de saúde do município.',
                    'A Prefeitura lançou a programação do Outubro Rosa, com palestras, rodas de conversa e mutirões de exames voltados à saúde da mulher.',
                ],
                'facts' => [
                    'agendamento facilitado de mamografias',
                    'rodas de conversa sobre autoexame e diagnóstico precoce',
                    'parceria com laboratórios da rede estadual',
                    'iluminação rosa em prédios públicos durante o mês',
                    'atendimento psicológico para pacientes em tratamento',
                ],
                'quote_roles' => ['Secretária Municipal de Saúde', 'coordenadora da saúde da mulher'],
            ],
            [
                'key' => 'campanha_novembro_azul',
                'categories' => ['Saúde', 'Campanhas'],
                'media_theme' => MediaCatalog::THEME_SAUDE,
                'gallery_worthy' => false,
                'season' => [11],
                'weight' => 1,
                'titles' => [
                    'Novembro Azul: exames de próstata gratuitos em {neighborhood}',
                    'Prefeitura reforça prevenção ao câncer de próstata no Novembro Azul',
                ],
                'intro_templates' => [
                    'A Secretaria de Saúde iniciou a programação do Novembro Azul, com exames gratuitos e palestras sobre a prevenção ao câncer de próstata.',
                ],
                'facts' => [
                    'exames de PSA disponíveis nas unidades de saúde',
                    'palestras em empresas e associações de bairro',
                    'parceria com o hospital regional para exames complementares',
                    'iluminação azul em prédios públicos',
                ],
                'quote_roles' => ['Secretário Municipal de Saúde', 'médico urologista'],
            ],
            [
                'key' => 'campanha_maio_amarelo',
                'categories' => ['Saúde', 'Campanhas', 'Trânsito'],
                'media_theme' => MediaCatalog::THEME_SAUDE,
                'gallery_worthy' => false,
                'season' => [5],
                'weight' => 1,
                'titles' => [
                    'Maio Amarelo: Prefeitura promove ações de conscientização no trânsito',
                    'Campanha Maio Amarelo alerta motoristas e pedestres de {neighborhood}',
                ],
                'intro_templates' => [
                    'A Prefeitura, por meio da Secretaria de Trânsito, iniciou as ações do Maio Amarelo, mês dedicado à conscientização sobre segurança viária.',
                ],
                'facts' => [
                    'blitz educativa em pontos de maior fluxo',
                    'distribuição de material informativo aos motoristas',
                    'palestras em escolas sobre segurança no trânsito',
                    'reforço na sinalização de vias de {neighborhood}',
                ],
                'quote_roles' => ['coordenador de trânsito', 'Secretário de Mobilidade Urbana'],
            ],
            [
                'key' => 'campanha_setembro_amarelo',
                'categories' => ['Saúde', 'Campanhas'],
                'media_theme' => MediaCatalog::THEME_SAUDE,
                'gallery_worthy' => false,
                'season' => [9],
                'weight' => 1,
                'titles' => [
                    'Setembro Amarelo: Prefeitura reforça rede de apoio à saúde mental',
                    'Campanha de valorização da vida chega às escolas de {neighborhood}',
                ],
                'intro_templates' => [
                    'A Prefeitura deu início à programação do Setembro Amarelo, com atividades voltadas à prevenção ao suicídio e à valorização da vida.',
                ],
                'facts' => [
                    'rodas de conversa com psicólogos da rede municipal',
                    'capacitação de professores para identificar sinais de alerta',
                    'ampliação do atendimento no Centro de Atenção Psicossocial',
                    'divulgação dos canais de apoio emocional disponíveis 24 horas',
                ],
                'quote_roles' => ['coordenadora de saúde mental', 'Secretária Municipal de Saúde'],
            ],
            [
                'key' => 'boletim_epidemiologico',
                'categories' => ['Boletins Epidemiológicos', 'Saúde', 'Transparência'],
                'media_theme' => MediaCatalog::THEME_SAUDE,
                'gallery_worthy' => false,
                'season' => null,
                'weight' => 1,
                'titles' => [
                    'Prefeitura divulga novo boletim epidemiológico',
                    'Boletim semanal traz atualização de casos de dengue e influenza',
                ],
                'intro_templates' => [
                    'A Secretaria Municipal de Saúde divulgou o boletim epidemiológico mais recente, com dados atualizados sobre a circulação de doenças no município.',
                ],
                'facts' => [
                    'comparação com o mesmo período do ano anterior',
                    'detalhamento por bairro dos casos confirmados',
                    'orientações de prevenção reforçadas pela equipe técnica',
                    'canal de denúncia de focos disponível pelo telefone da Vigilância',
                ],
                'quote_roles' => ['coordenador de vigilância epidemiológica'],
            ],
            [
                'key' => 'covid_reforco',
                'categories' => ['Vacinação', 'Saúde', 'Campanhas'],
                'media_theme' => MediaCatalog::THEME_VACINACAO,
                'gallery_worthy' => false,
                'season' => null,
                'years' => [2023],
                'weight' => 1,
                'titles' => [
                    'Prefeitura aplica dose de reforço contra a Covid-19 em grupos prioritários',
                    'Nova etapa da vacinação contra Covid-19 é liberada para idosos',
                ],
                'intro_templates' => [
                    'A Secretaria de Saúde liberou uma nova etapa da vacinação contra a Covid-19, com foco em idosos e pessoas com comorbidades.',
                ],
                'facts' => [
                    'aplicação da dose bivalente nas unidades de saúde',
                    'apresentação da caderneta de vacinação obrigatória',
                    'atendimento prioritário para acamados em domicílio',
                    'reforço da campanha entre profissionais de saúde',
                ],
                'quote_roles' => ['Secretária Municipal de Saúde'],
            ],

            // ------------------------------------------------------------
            // EDUCAÇÃO
            // ------------------------------------------------------------
            [
                'key' => 'entrega_kits_escolares',
                'categories' => ['Educação'],
                'media_theme' => MediaCatalog::THEME_EDUCACAO,
                'gallery_worthy' => true,
                'season' => [1, 2],
                'weight' => 2,
                'titles' => [
                    'Prefeitura entrega kits escolares para início do ano letivo',
                    'Estudantes da rede municipal recebem material escolar novo',
                    '{school} recebe kits e uniformes para o novo ano letivo',
                ],
                'intro_templates' => [
                    'Com a proximidade do início do ano letivo, a Prefeitura iniciou a entrega de kits escolares para todos os alunos da rede municipal de ensino.',
                    'Alunos da rede municipal já podem retirar os kits escolares distribuídos pela Secretaria de Educação para o novo ano letivo.',
                ],
                'facts' => [
                    'distribuição de mais de {number} kits completos',
                    'itens que incluem cadernos, lápis e material de apoio pedagógico',
                    'entrega também de uniformes para todos os estudantes',
                    'investimento de {money} na compra do material',
                    'kits adaptados para alunos da educação especial',
                ],
                'quote_roles' => ['Secretária Municipal de Educação', 'diretora escolar'],
            ],
            [
                'key' => 'entrega_fardamentos',
                'categories' => ['Educação'],
                'media_theme' => MediaCatalog::THEME_EDUCACAO,
                'gallery_worthy' => false,
                'season' => [1, 2],
                'weight' => 1,
                'titles' => [
                    'Rede municipal de ensino recebe novos uniformes escolares',
                    '{school} celebra chegada dos novos fardamentos',
                ],
                'intro_templates' => [
                    'A Secretaria de Educação concluiu a entrega de uniformes escolares para os alunos matriculados na rede municipal.',
                ],
                'facts' => [
                    'peças confeccionadas por costureiras da região',
                    'tecido de maior durabilidade escolhido após consulta aos pais',
                    'entrega organizada por turma para evitar aglomeração',
                    'uniformes completos incluindo agasalho para o inverno',
                ],
                'quote_roles' => ['Secretária Municipal de Educação'],
            ],
            [
                'key' => 'reforma_escola',
                'categories' => ['Educação', 'Obras', 'Infraestrutura'],
                'media_theme' => MediaCatalog::THEME_EDUCACAO,
                'gallery_worthy' => true,
                'season' => null,
                'weight' => 2,
                'titles' => [
                    'Prefeitura conclui reforma da {school}',
                    '{school} ganha nova quadra e salas climatizadas',
                    'Obra de revitalização da {school} é entregue à comunidade',
                ],
                'intro_templates' => [
                    'A Prefeitura entregou a reforma completa da {school}, beneficiando centenas de estudantes da rede municipal.',
                    'Após meses de obras, a {school} recebeu reforma estrutural que inclui novas salas de aula e área de convivência.',
                ],
                'facts' => [
                    'construção de {number} novas salas de aula',
                    'climatização de todos os ambientes pedagógicos',
                    'reforma da quadra poliesportiva',
                    'acessibilidade com rampas e banheiros adaptados',
                    'investimento de {money} em recursos próprios e convênios',
                    'nova biblioteca e sala de informática',
                ],
                'quote_roles' => ['Secretária Municipal de Educação', 'diretora escolar', 'prefeito'],
            ],
            [
                'key' => 'apresentacao_escolar',
                'categories' => ['Educação', 'Cultura', 'Eventos'],
                'media_theme' => MediaCatalog::THEME_EDUCACAO,
                'gallery_worthy' => true,
                'season' => null,
                'weight' => 1,
                'titles' => [
                    'Alunos da rede municipal encantam público em mostra cultural',
                    '{school} realiza apresentação de encerramento do semestre',
                    'Mostra pedagógica reúne famílias na {school}',
                ],
                'intro_templates' => [
                    'A {school} promoveu uma apresentação cultural que reuniu alunos, professores e familiares em um dia de celebração da aprendizagem.',
                ],
                'facts' => [
                    'apresentações de dança, teatro e música',
                    'exposição de trabalhos manuais produzidos em sala',
                    'participação de mais de {number} alunos no evento',
                    'homenagem aos professores da unidade',
                ],
                'quote_roles' => ['diretora escolar', 'coordenadora pedagógica'],
            ],
            [
                'key' => 'curso_profissionalizante',
                'categories' => ['Capacitação', 'Empreendedorismo', 'Juventude'],
                'media_theme' => MediaCatalog::THEME_EDUCACAO,
                'gallery_worthy' => false,
                'season' => null,
                'weight' => 1,
                'titles' => [
                    'Prefeitura abre inscrições para cursos profissionalizantes gratuitos',
                    'Jovens concluem curso de qualificação profissional',
                    'Novas turmas de capacitação começam em {neighborhood}',
                ],
                'intro_templates' => [
                    'A Prefeitura, em parceria com instituições de ensino profissionalizante, abriu novas turmas de qualificação gratuita para moradores.',
                ],
                'facts' => [
                    'cursos de informática, culinária e corte e costura',
                    'vagas prioritárias para beneficiários de programas sociais',
                    'certificação reconhecida ao final do curso',
                    'parceria com o Sistema S para ampliar a oferta',
                ],
                'quote_roles' => ['Secretário de Desenvolvimento Econômico', 'coordenadora de capacitação'],
            ],

            // ------------------------------------------------------------
            // INFRAESTRUTURA / OBRAS
            // ------------------------------------------------------------
            [
                'key' => 'pavimentacao',
                'categories' => ['Infraestrutura', 'Obras', 'Mobilidade Urbana'],
                'media_theme' => MediaCatalog::THEME_OBRAS_INFRAESTRUTURA,
                'gallery_worthy' => false,
                'season' => null,
                'weight' => 3,
                'titles' => [
                    'Prefeitura conclui pavimentação da Rua {street}',
                    'Moradores da {neighborhood} comemoram ruas recém-pavimentadas',
                    'Obra de pavimentação chega à {neighborhood} após anos de espera',
                    'Asfaltamento da Rua {street} beneficia centenas de famílias',
                ],
                'intro_templates' => [
                    'A Prefeitura concluiu mais uma etapa do programa de pavimentação, desta vez contemplando a Rua {street}, no bairro {neighborhood}.',
                    'Moradores da {neighborhood} já podem circular pela Rua {street} totalmente pavimentada, uma reivindicação antiga da comunidade.',
                ],
                'facts' => [
                    'pavimentação de {number} metros de extensão',
                    'aplicação de massa asfáltica de alta durabilidade',
                    'construção de meio-fio e sarjetas para escoamento de água',
                    'redução do acúmulo de poeira e lama nas chuvas',
                    'investimento de {money} em recursos próprios',
                    'sinalização horizontal e vertical instalada em seguida',
                ],
                'quote_roles' => ['Secretário de Obras e Infraestrutura', 'morador da rua', 'prefeito'],
            ],
            [
                'key' => 'tapa_buraco',
                'categories' => ['Infraestrutura', 'Obras'],
                'media_theme' => MediaCatalog::THEME_OBRAS_INFRAESTRUTURA,
                'gallery_worthy' => false,
                'season' => null,
                'weight' => 2,
                'titles' => [
                    'Operação tapa-buraco chega à {neighborhood} nesta semana',
                    'Prefeitura intensifica operação tapa-buraco após período de chuvas',
                    'Equipes municipais recuperam vias danificadas em {neighborhood}',
                ],
                'intro_templates' => [
                    'A Secretaria de Obras iniciou uma nova etapa da operação tapa-buraco, priorizando vias com maior fluxo de veículos em {neighborhood}.',
                ],
                'facts' => [
                    'recuperação de mais de {number} pontos críticos',
                    'uso de massa asfáltica a quente para maior durabilidade',
                    'atendimento às solicitações registradas pelo canal de ouvidoria',
                    'equipes atuando em regime de mutirão aos finais de semana',
                ],
                'quote_roles' => ['Secretário de Obras e Infraestrutura'],
            ],
            [
                'key' => 'iluminacao_led',
                'categories' => ['Iluminação Pública', 'Infraestrutura'],
                'media_theme' => MediaCatalog::THEME_OBRAS_INFRAESTRUTURA,
                'gallery_worthy' => false,
                'season' => null,
                'weight' => 1,
                'titles' => [
                    'Prefeitura conclui troca de lâmpadas por LED em {neighborhood}',
                    'Iluminação de LED chega a mais um bairro da cidade',
                    'Praças de {neighborhood} recebem nova iluminação',
                ],
                'intro_templates' => [
                    'A Prefeitura concluiu a substituição da iluminação convencional por lâmpadas de LED em ruas e praças de {neighborhood}.',
                ],
                'facts' => [
                    'troca de {number} pontos de iluminação',
                    'redução estimada de {percentage}% no consumo de energia',
                    'aumento da sensação de segurança relatado pelos moradores',
                    'manutenção facilitada com maior vida útil das lâmpadas',
                ],
                'quote_roles' => ['Secretário de Obras e Infraestrutura', 'moradora do bairro'],
            ],
            [
                'key' => 'recuperacao_estradas_rurais',
                'categories' => ['Infraestrutura', 'Agricultura', 'Desenvolvimento Rural'],
                'media_theme' => MediaCatalog::THEME_OBRAS_INFRAESTRUTURA,
                'gallery_worthy' => false,
                'season' => null,
                'weight' => 2,
                'titles' => [
                    'Prefeitura recupera estradas vicinais na zona rural',
                    'Máquinas municipais recuperam acesso a comunidades rurais',
                    'Produtores rurais comemoram recuperação de estradas',
                ],
                'intro_templates' => [
                    'A Prefeitura concluiu a recuperação de estradas vicinais que dão acesso a comunidades rurais, facilitando o escoamento da produção agrícola.',
                ],
                'facts' => [
                    'patrolamento de {number} quilômetros de estradas',
                    'instalação de bueiros para escoamento de água da chuva',
                    'facilita o transporte escolar de estudantes da zona rural',
                    'apoio direto aos pequenos produtores da região',
                ],
                'quote_roles' => ['Secretário de Agricultura', 'produtor rural'],
            ],
            [
                'key' => 'inauguracao_praca',
                'categories' => ['Infraestrutura', 'Obras', 'Eventos'],
                'media_theme' => MediaCatalog::THEME_CIVICO_ADMINISTRATIVO,
                'gallery_worthy' => true,
                'season' => null,
                'weight' => 2,
                'titles' => [
                    'Prefeitura inaugura nova praça em {neighborhood}',
                    '{neighborhood} ganha novo espaço de lazer e convivência',
                    'Praça revitalizada é entregue à população de {neighborhood}',
                ],
                'intro_templates' => [
                    'A Prefeitura entregou à comunidade de {neighborhood} uma nova praça, com área de lazer, playground e academia ao ar livre.',
                ],
                'facts' => [
                    'instalação de playground e academia ao ar livre',
                    'plantio de árvores nativas para arborização',
                    'iluminação de LED em toda a extensão da praça',
                    'espaço para caminhada e prática de exercícios',
                    'investimento de {money} na obra',
                ],
                'quote_roles' => ['prefeito', 'Secretário de Obras e Infraestrutura'],
            ],
            [
                'key' => 'mutirao_limpeza',
                'categories' => ['Limpeza Urbana', 'Meio Ambiente'],
                'media_theme' => MediaCatalog::THEME_MEIO_AMBIENTE,
                'gallery_worthy' => true,
                'season' => null,
                'weight' => 1,
                'titles' => [
                    'Mutirão de limpeza mobiliza moradores de {neighborhood}',
                    'Prefeitura realiza força-tarefa de limpeza urbana',
                    'Ação conjunta remove entulho e lixo de terrenos baldios',
                ],
                'intro_templates' => [
                    'A Prefeitura, com apoio de voluntários, realizou um mutirão de limpeza em {neighborhood}, removendo entulho e resíduos de vias públicas.',
                ],
                'facts' => [
                    'recolhimento de {number} toneladas de resíduos',
                    'roçagem de terrenos baldios e áreas verdes',
                    'participação de agentes comunitários e voluntários',
                    'conscientização sobre descarte correto de lixo',
                ],
                'quote_roles' => ['Secretário de Serviços Urbanos'],
            ],

            // ------------------------------------------------------------
            // MEIO AMBIENTE
            // ------------------------------------------------------------
            [
                'key' => 'arborizacao',
                'categories' => ['Meio Ambiente'],
                'media_theme' => MediaCatalog::THEME_MEIO_AMBIENTE,
                'gallery_worthy' => true,
                'season' => null,
                'weight' => 1,
                'titles' => [
                    'Prefeitura planta mudas nativas em {neighborhood}',
                    'Ação de arborização urbana chega à {neighborhood}',
                    'Voluntários participam de mutirão de plantio de árvores',
                ],
                'intro_templates' => [
                    'A Secretaria de Meio Ambiente realizou uma ação de arborização urbana em {neighborhood}, com plantio de mudas nativas em praças e calçadas.',
                ],
                'facts' => [
                    'plantio de {number} mudas de espécies nativas',
                    'participação de estudantes da rede municipal',
                    'escolha de espécies adequadas à fiação urbana',
                    'compromisso de manutenção pelos próximos meses',
                ],
                'quote_roles' => ['Secretário de Meio Ambiente'],
            ],
            [
                'key' => 'limpeza_corrego',
                'categories' => ['Meio Ambiente', 'Recursos Hídricos'],
                'media_theme' => MediaCatalog::THEME_MEIO_AMBIENTE,
                'gallery_worthy' => false,
                'season' => null,
                'weight' => 1,
                'titles' => [
                    'Voluntários participam de limpeza do córrego em {neighborhood}',
                    'Prefeitura remove resíduos de curso d\'água na zona urbana',
                ],
                'intro_templates' => [
                    'Moradores e servidores municipais se uniram para retirar lixo e entulho acumulados às margens do córrego que corta {neighborhood}.',
                ],
                'facts' => [
                    'retirada de resíduos sólidos das margens',
                    'orientação sobre descarte correto de lixo',
                    'prevenção de enchentes na época de chuvas',
                    'parceria com o comitê de bacia hidrográfica',
                ],
                'quote_roles' => ['Secretário de Meio Ambiente'],
            ],
            [
                'key' => 'acao_ambiental_educativa',
                'categories' => ['Meio Ambiente', 'Educação'],
                'media_theme' => MediaCatalog::THEME_MEIO_AMBIENTE,
                'gallery_worthy' => false,
                'season' => [6],
                'weight' => 1,
                'titles' => [
                    'Semana do Meio Ambiente leva palestras às escolas municipais',
                    'Alunos participam de oficina de sustentabilidade em {school}',
                ],
                'intro_templates' => [
                    'A Prefeitura promoveu atividades da Semana do Meio Ambiente, levando palestras e oficinas de sustentabilidade às escolas da rede municipal.',
                ],
                'facts' => [
                    'oficinas de reciclagem e reaproveitamento',
                    'plantio simbólico de mudas nos pátios escolares',
                    'concurso de redação sobre preservação ambiental',
                    'parceria com a Secretaria de Educação',
                ],
                'quote_roles' => ['Secretário de Meio Ambiente', 'diretora escolar'],
            ],

            // ------------------------------------------------------------
            // ASSISTÊNCIA SOCIAL
            // ------------------------------------------------------------
            [
                'key' => 'distribuicao_cestas_basicas',
                'categories' => ['Assistência Social'],
                'media_theme' => MediaCatalog::THEME_ASSISTENCIA_SOCIAL,
                'gallery_worthy' => false,
                'season' => null,
                'weight' => 2,
                'titles' => [
                    'Prefeitura distribui cestas básicas para famílias em vulnerabilidade',
                    'Ação social entrega mais de {number} cestas básicas em {neighborhood}',
                ],
                'intro_templates' => [
                    'A Secretaria de Assistência Social realizou a entrega de cestas básicas a famílias em situação de vulnerabilidade social cadastradas no CRAS.',
                ],
                'facts' => [
                    'atendimento a {number} famílias cadastradas',
                    'parceria com doações de produtores locais',
                    'triagem feita pelos assistentes sociais do CRAS',
                    'prioridade para famílias com crianças e idosos',
                ],
                'quote_roles' => ['Secretária de Assistência Social', 'assistente social'],
            ],
            [
                'key' => 'programa_social_capacitacao',
                'categories' => ['Assistência Social', 'Capacitação', 'Empreendedorismo'],
                'media_theme' => MediaCatalog::THEME_ASSISTENCIA_SOCIAL,
                'gallery_worthy' => false,
                'season' => null,
                'weight' => 1,
                'titles' => [
                    'CRAS oferece oficinas de geração de renda em {neighborhood}',
                    'Programa social qualifica moradores para o mercado de trabalho',
                ],
                'intro_templates' => [
                    'O Centro de Referência de Assistência Social (CRAS) de {neighborhood} iniciou um novo ciclo de oficinas voltadas à geração de renda para famílias atendidas.',
                ],
                'facts' => [
                    'oficinas de artesanato e culinária',
                    'apoio na formalização de pequenos negócios (MEI)',
                    'parceria com o Sebrae para orientação empresarial',
                    'feira de exposição dos produtos ao final do curso',
                ],
                'quote_roles' => ['Secretária de Assistência Social', 'coordenadora do CRAS'],
            ],
            [
                'key' => 'entrega_titulos_terra',
                'categories' => ['Habitação', 'Assistência Social', 'Desenvolvimento Rural'],
                'media_theme' => MediaCatalog::THEME_CIVICO_ADMINISTRATIVO,
                'gallery_worthy' => true,
                'season' => null,
                'weight' => 1,
                'titles' => [
                    'Famílias recebem títulos de propriedade em cerimônia na Prefeitura',
                    'Programa de regularização fundiária beneficia moradores de {neighborhood}',
                ],
                'intro_templates' => [
                    'Dezenas de famílias receberam nesta semana os títulos definitivos de propriedade de seus imóveis, resultado do programa municipal de regularização fundiária.',
                ],
                'facts' => [
                    'regularização de {number} imóveis nesta etapa',
                    'parceria com o cartório de registro de imóveis',
                    'isenção de taxas para famílias de baixa renda',
                    'segurança jurídica para futuras negociações e heranças',
                ],
                'quote_roles' => ['prefeito', 'Secretária de Habitação'],
            ],

            // ------------------------------------------------------------
            // CULTURA / FESTIVIDADES
            // ------------------------------------------------------------
            [
                'key' => 'sao_joao',
                'categories' => ['Cultura', 'Festividades', 'Eventos'],
                'media_theme' => MediaCatalog::THEME_SAO_JOAO,
                'gallery_worthy' => true,
                'season' => [6],
                'weight' => 3,
                'titles' => [
                    'Festa de São João movimenta o Centro da cidade',
                    'Prefeitura abre programação junina com forró e quadrilhas',
                    'São João reúne milhares de pessoas na praça principal',
                    'Arraiá municipal celebra tradições nordestinas',
                ],
                'intro_templates' => [
                    'A tradicional festa de São João tomou conta da praça principal, com apresentações de quadrilhas, comidas típicas e shows de forró pé de serra.',
                    'Milhares de pessoas compareceram à abertura do São João municipal, que promete agitar a cidade durante todo o mês de junho.',
                ],
                'facts' => [
                    'apresentação de {number} quadrilhas juninas',
                    'barracas de comidas típicas organizadas por associações locais',
                    'shows de forró pé de serra durante toda a programação',
                    'decoração especial com bandeirinhas e balões',
                    'fogueira simbólica acesa pela administração municipal',
                    'concurso de melhor quadrilha com premiação',
                ],
                'quote_roles' => ['Secretário de Cultura', 'prefeito', 'integrante de quadrilha junina'],
            ],
            [
                'key' => 'carnaval',
                'categories' => ['Cultura', 'Festividades', 'Eventos'],
                'media_theme' => MediaCatalog::THEME_FESTIVIDADES_POPULARES,
                'gallery_worthy' => true,
                'season' => [2, 3],
                'weight' => 2,
                'titles' => [
                    'Bloco oficial abre o Carnaval na avenida principal',
                    'Prefeitura garante estrutura para o Carnaval de rua',
                    'Foliões lotam o Centro no primeiro dia de Carnaval',
                ],
                'intro_templates' => [
                    'O Carnaval de rua começou oficialmente com a saída do bloco organizado pela Prefeitura, reunindo foliões de todas as idades no Centro da cidade.',
                ],
                'facts' => [
                    'estrutura de banheiros químicos e pontos de apoio',
                    'reforço no policiamento e na iluminação das ruas',
                    'apresentação de blocos tradicionais da cidade',
                    'ação de conscientização sobre consumo de álcool',
                    'equipe de limpeza atuando durante toda a folia',
                ],
                'quote_roles' => ['Secretário de Cultura', 'foliã'],
            ],
            [
                'key' => 'natal_luzes',
                'categories' => ['Festividades', 'Eventos', 'Comunicação'],
                'media_theme' => MediaCatalog::THEME_FESTIVIDADES_POPULARES,
                'gallery_worthy' => true,
                'season' => [12],
                'weight' => 2,
                'titles' => [
                    'Prefeitura inaugura decoração natalina na praça central',
                    'Natal Iluminado abre programação de fim de ano',
                    'Chegada do Papai Noel emociona crianças no Centro',
                ],
                'intro_templates' => [
                    'A Prefeitura acendeu as luzes da decoração natalina na praça central, dando início à programação de Natal deste ano.',
                ],
                'facts' => [
                    'árvore de Natal com {number} metros de altura',
                    'cortejo natalino com carros alegóricos',
                    'apresentação de coral infantil da rede municipal',
                    'distribuição de brinquedos para crianças carentes',
                    'decoração especial nas principais avenidas',
                ],
                'quote_roles' => ['Secretário de Cultura', 'prefeito'],
            ],
            [
                'key' => 'ano_novo',
                'categories' => ['Festividades', 'Eventos'],
                'media_theme' => MediaCatalog::THEME_FESTIVIDADES_POPULARES,
                'gallery_worthy' => false,
                'season' => [12, 1],
                'weight' => 1,
                'titles' => [
                    'Queima de fogos marca a virada de ano na cidade',
                    'Prefeitura organiza festa de Réveillon na orla municipal',
                ],
                'intro_templates' => [
                    'A virada do ano foi celebrada com show de fogos e apresentação musical organizados pela Prefeitura, reunindo famílias na praça central.',
                ],
                'facts' => [
                    'queima de fogos de baixo ruído, respeitando animais',
                    'reforço na segurança e na limpeza pública',
                    'show musical com artistas locais',
                    'transmissão ao vivo pelas redes sociais da Prefeitura',
                ],
                'quote_roles' => ['Secretário de Cultura'],
            ],
            [
                'key' => 'semana_da_patria',
                'categories' => ['Cultura', 'Festividades', 'Eventos', 'Administração'],
                'media_theme' => MediaCatalog::THEME_CIVICO_ADMINISTRATIVO,
                'gallery_worthy' => true,
                'season' => [9],
                'weight' => 2,
                'titles' => [
                    'Desfile cívico de 7 de Setembro reúne escolas e entidades',
                    'Semana da Pátria é celebrada com desfile no Centro',
                    'Estudantes e bandas marciais participam do desfile de Independência',
                ],
                'intro_templates' => [
                    'O tradicional desfile cívico de 7 de Setembro reuniu escolas, entidades e órgãos públicos na avenida principal, celebrando a Semana da Pátria.',
                ],
                'facts' => [
                    'participação de {number} escolas municipais e estaduais',
                    'apresentação de bandas marciais e fanfarras',
                    'homenagem a servidores públicos e voluntários',
                    'presença da guarda municipal e do corpo de bombeiros',
                    'arquibancada montada para acomodar o público',
                ],
                'quote_roles' => ['prefeito', 'Secretária de Educação'],
            ],
            [
                'key' => 'festa_padroeiro',
                'categories' => ['Cultura', 'Festividades', 'Eventos'],
                'media_theme' => MediaCatalog::THEME_CULTURA_POPULAR,
                'gallery_worthy' => true,
                'season' => null,
                'weight' => 1,
                'titles' => [
                    'Festa do padroeiro reúne fiéis em procissão pelas ruas do Centro',
                    'Comunidade celebra tradicional festa religiosa da cidade',
                ],
                'intro_templates' => [
                    'A festa em homenagem ao padroeiro da cidade reuniu fiéis em procissão pelas principais ruas do Centro, seguida de missa campal e apresentações culturais.',
                ],
                'facts' => [
                    'procissão com participação de {number} fiéis',
                    'apoio da Prefeitura na infraestrutura do evento',
                    'apresentação de grupos culturais locais',
                    'barracas de comidas típicas organizadas pela paróquia',
                ],
                'quote_roles' => ['Secretário de Cultura', 'pároco da comunidade'],
            ],
            [
                'key' => 'dia_das_maes',
                'categories' => ['Festividades', 'Assistência Social'],
                'media_theme' => MediaCatalog::THEME_FESTIVIDADES_POPULARES,
                'gallery_worthy' => false,
                'season' => [5],
                'weight' => 1,
                'titles' => [
                    'Prefeitura realiza evento especial em homenagem ao Dia das Mães',
                    'CRAS promove café da manhã em celebração ao Dia das Mães',
                ],
                'intro_templates' => [
                    'A Prefeitura promoveu uma manhã especial em homenagem às mães atendidas pelos programas de assistência social do município.',
                ],
                'facts' => [
                    'café da manhã com {number} mães atendidas',
                    'sorteio de brindes doados pelo comércio local',
                    'apresentação musical em homenagem às presentes',
                    'sessão de fotos gratuita para as famílias',
                ],
                'quote_roles' => ['Secretária de Assistência Social'],
            ],
            [
                'key' => 'dia_dos_pais',
                'categories' => ['Festividades'],
                'media_theme' => MediaCatalog::THEME_FESTIVIDADES_POPULARES,
                'gallery_worthy' => false,
                'season' => [8],
                'weight' => 1,
                'titles' => [
                    'Prefeitura promove atividade especial pelo Dia dos Pais',
                    'Evento esportivo celebra o Dia dos Pais em {neighborhood}',
                ],
                'intro_templates' => [
                    'A Secretaria de Esportes organizou uma manhã de atividades recreativas em homenagem ao Dia dos Pais no complexo esportivo de {neighborhood}.',
                ],
                'facts' => [
                    'torneio recreativo de futebol entre pais e filhos',
                    'distribuição de lembranças aos participantes',
                    'apoio de voluntários na organização do evento',
                    'presença de mais de {number} famílias',
                ],
                'quote_roles' => ['Secretário de Esportes'],
            ],
            [
                'key' => 'dia_da_mulher',
                'categories' => ['Mulher', 'Festividades', 'Campanhas'],
                'media_theme' => MediaCatalog::THEME_CULTURA_POPULAR,
                'gallery_worthy' => false,
                'season' => [3],
                'weight' => 1,
                'titles' => [
                    'Prefeitura celebra o Dia Internacional da Mulher com programação especial',
                    'Semana da Mulher reúne palestras e homenagens em {neighborhood}',
                ],
                'intro_templates' => [
                    'A Prefeitura promoveu uma semana de atividades em homenagem ao Dia Internacional da Mulher, com palestras, rodas de conversa e homenagens.',
                ],
                'facts' => [
                    'palestra sobre direitos e autonomia financeira',
                    'homenagem a mulheres de destaque na comunidade',
                    'apresentação cultural com artistas locais',
                    'divulgação da rede de proteção à mulher do município',
                ],
                'quote_roles' => ['coordenadora da Casa da Mulher', 'Secretária de Assistência Social'],
            ],
            [
                'key' => 'feira_artesanato',
                'categories' => ['Cultura', 'Turismo', 'Agricultura Familiar', 'Desenvolvimento Econômico'],
                'media_theme' => MediaCatalog::THEME_CULTURA_POPULAR,
                'gallery_worthy' => true,
                'season' => null,
                'weight' => 2,
                'titles' => [
                    'Feira de artesanato movimenta economia local no Centro',
                    'Artesãos expõem produções em feira apoiada pela Prefeitura',
                    'Feira reúne dezenas de expositores de artesanato regional',
                ],
                'intro_templates' => [
                    'A Prefeitura, em parceria com associações de artesãos, promoveu mais uma edição da feira de artesanato na praça central.',
                ],
                'facts' => [
                    'participação de {number} artesãos e produtores locais',
                    'exposição de peças em cerâmica, palha e renda',
                    'apresentações culturais durante todo o evento',
                    'incentivo à economia criativa e ao turismo local',
                ],
                'quote_roles' => ['Secretário de Cultura', 'artesã local'],
            ],

            // ------------------------------------------------------------
            // ESPORTE
            // ------------------------------------------------------------
            [
                'key' => 'campeonato_municipal',
                'categories' => ['Esporte', 'Juventude'],
                'media_theme' => MediaCatalog::THEME_ESPORTE,
                'gallery_worthy' => true,
                'season' => null,
                'weight' => 2,
                'titles' => [
                    'Campeonato Municipal de Futebol tem início neste fim de semana',
                    'Final do campeonato municipal reúne torcida no estádio',
                    'Times de {neighborhood} disputam campeonato municipal',
                ],
                'intro_templates' => [
                    'Teve início o Campeonato Municipal de Futebol, reunindo times de diversos bairros em disputas que se estendem pelos próximos meses.',
                    'A final do campeonato municipal movimentou o estádio da cidade, com grande presença de torcedores.',
                ],
                'facts' => [
                    'participação de {number} equipes inscritas',
                    'arbitragem certificada pela federação estadual',
                    'premiação para os três primeiros colocados',
                    'renda revertida para materiais esportivos dos times de base',
                ],
                'quote_roles' => ['Secretário de Esportes', 'técnico de futebol'],
            ],
            [
                'key' => 'corrida_municipal',
                'categories' => ['Esporte', 'Saúde', 'Turismo'],
                'media_theme' => MediaCatalog::THEME_ESPORTE,
                'gallery_worthy' => true,
                'season' => null,
                'weight' => 1,
                'titles' => [
                    'Corrida municipal reúne atletas de várias cidades da região',
                    'Prefeitura promove corrida de rua pelo Centro histórico',
                ],
                'intro_templates' => [
                    'A corrida municipal reuniu corredores de várias idades em um percurso pelas principais ruas do Centro, incentivando a prática esportiva.',
                ],
                'facts' => [
                    'percurso de {number} quilômetros pelas ruas centrais',
                    'inscrição gratuita para moradores do município',
                    'premiação para os três primeiros de cada categoria',
                    'apoio de equipe médica durante toda a prova',
                ],
                'quote_roles' => ['Secretário de Esportes', 'atleta vencedor'],
            ],
            [
                'key' => 'evento_esportivo_inclusivo',
                'categories' => ['Esporte', 'Inclusão Social'],
                'media_theme' => MediaCatalog::THEME_ESPORTE,
                'gallery_worthy' => false,
                'season' => null,
                'weight' => 1,
                'titles' => [
                    'Torneio adaptado promove esporte inclusivo em {neighborhood}',
                    'Prefeitura apoia campeonato de esportes paralímpicos',
                ],
                'intro_templates' => [
                    'A Secretaria de Esportes apoiou um torneio adaptado, promovendo a inclusão de pessoas com deficiência por meio do esporte.',
                ],
                'facts' => [
                    'modalidades como goalball, bocha e futebol para cegos',
                    'participação de atletas de cidades vizinhas',
                    'acessibilidade garantida em toda a estrutura do evento',
                    'parceria com associações de pessoas com deficiência',
                ],
                'quote_roles' => ['Secretário de Esportes', 'atleta paralímpico'],
            ],

            // ------------------------------------------------------------
            // AGRICULTURA
            // ------------------------------------------------------------
            [
                'key' => 'feira_livre',
                'categories' => ['Agricultura', 'Abastecimento', 'Desenvolvimento Econômico'],
                'media_theme' => MediaCatalog::THEME_AGRICULTURA_FEIRA,
                'gallery_worthy' => true,
                'season' => null,
                'weight' => 2,
                'titles' => [
                    'Feira livre reúne produtores locais no Centro',
                    'Prefeitura amplia estrutura da feira livre municipal',
                    'Feira do produtor oferece alimentos frescos direto do campo',
                ],
                'intro_templates' => [
                    'A tradicional feira livre voltou a reunir dezenas de produtores rurais na praça central, oferecendo alimentos frescos direto do campo.',
                ],
                'facts' => [
                    'participação de {number} produtores cadastrados',
                    'venda de hortaliças, frutas e produtos derivados do leite',
                    'apoio da Secretaria de Agricultura na organização',
                    'preços mais acessíveis que o comércio convencional',
                ],
                'quote_roles' => ['Secretário de Agricultura', 'produtor rural'],
            ],
            [
                'key' => 'apoio_homem_campo',
                'categories' => ['Agricultura Familiar', 'Desenvolvimento Rural'],
                'media_theme' => MediaCatalog::THEME_AGRICULTURA_FEIRA,
                'gallery_worthy' => false,
                'season' => null,
                'weight' => 1,
                'titles' => [
                    'Prefeitura entrega máquinas e insumos a produtores rurais',
                    'Programa de apoio ao homem do campo beneficia dezenas de famílias',
                ],
                'intro_templates' => [
                    'A Secretaria de Agricultura entregou máquinas e insumos a produtores rurais cadastrados no programa municipal de apoio à agricultura familiar.',
                ],
                'facts' => [
                    'entrega de sementes e mudas certificadas',
                    'disponibilização de trator e implementos para uso coletivo',
                    'assistência técnica gratuita nas propriedades',
                    'parceria com o governo estadual para financiamento',
                ],
                'quote_roles' => ['Secretário de Agricultura', 'produtor rural'],
            ],

            // ------------------------------------------------------------
            // TURISMO
            // ------------------------------------------------------------
            [
                'key' => 'turismo_religioso_historico',
                'categories' => ['Turismo', 'Cultura'],
                'media_theme' => MediaCatalog::THEME_CIVICO_ADMINISTRATIVO,
                'gallery_worthy' => false,
                'season' => null,
                'weight' => 1,
                'titles' => [
                    'Prefeitura lança roteiro turístico pelo patrimônio histórico',
                    'Ação valoriza pontos turísticos e religiosos do município',
                ],
                'intro_templates' => [
                    'A Secretaria de Turismo lançou um novo roteiro guiado pelos principais pontos históricos e religiosos da cidade.',
                ],
                'facts' => [
                    'placas informativas instaladas nos pontos históricos',
                    'capacitação de guias turísticos locais',
                    'material de divulgação distribuído em pousadas e hotéis',
                    'parceria com a diocese para visitação de igrejas históricas',
                ],
                'quote_roles' => ['Secretário de Turismo'],
            ],

            // ------------------------------------------------------------
            // PROTEÇÃO ANIMAL
            // ------------------------------------------------------------
            [
                'key' => 'feira_adocao',
                'categories' => ['Proteção Animal', 'Saúde Animal', 'Eventos'],
                'media_theme' => MediaCatalog::THEME_ANIMAIS_PROTECAO,
                'gallery_worthy' => true,
                'season' => null,
                'weight' => 1,
                'titles' => [
                    'Feira de adoção de animais acontece neste sábado na praça',
                    'Dezenas de cães e gatos ganham novos lares em feira de adoção',
                ],
                'intro_templates' => [
                    'A Prefeitura promoveu mais uma feira de adoção de animais, reunindo cães e gatos resgatados em busca de um novo lar.',
                ],
                'facts' => [
                    'apresentação de {number} animais para adoção',
                    'exigência de termo de responsabilidade e visita prévia',
                    'castração gratuita incluída no processo de adoção',
                    'parceria com protetores independentes do município',
                ],
                'quote_roles' => ['coordenador de proteção animal', 'veterinária municipal'],
            ],
            [
                'key' => 'campanha_castracao',
                'categories' => ['Saúde Animal', 'Proteção Animal', 'Campanhas'],
                'media_theme' => MediaCatalog::THEME_ANIMAIS_PROTECAO,
                'gallery_worthy' => false,
                'season' => null,
                'weight' => 1,
                'titles' => [
                    'Prefeitura abre agendamento para castração gratuita de cães e gatos',
                    'Mutirão de castração chega a {neighborhood}',
                ],
                'intro_templates' => [
                    'A Secretaria de Saúde Animal abriu novo agendamento para castração gratuita de cães e gatos, com prioridade para animais de rua e famílias de baixa renda.',
                ],
                'facts' => [
                    'meta de {number} castrações nesta etapa',
                    'atendimento realizado por veterinários parceiros',
                    'controle populacional como principal objetivo da ação',
                    'agendamento pelo telefone ou presencialmente no CRAS',
                ],
                'quote_roles' => ['veterinária municipal', 'coordenador de proteção animal'],
            ],

            // ------------------------------------------------------------
            // ADMINISTRAÇÃO / CÍVICO
            // ------------------------------------------------------------
            [
                'key' => 'posse_secretario',
                'categories' => ['Administração', 'Gabinete do Prefeito'],
                'media_theme' => MediaCatalog::THEME_CIVICO_ADMINISTRATIVO,
                'gallery_worthy' => false,
                'season' => null,
                'weight' => 1,
                'titles' => [
                    'Prefeito empossa novo secretário municipal',
                    'Novo titular da pasta toma posse em cerimônia no gabinete',
                ],
                'intro_templates' => [
                    'O prefeito conduziu a cerimônia de posse do novo secretário municipal, que passa a integrar o primeiro escalão da administração.',
                ],
                'facts' => [
                    'assinatura do termo de posse em cerimônia simples',
                    'experiência prévia do novo secretário na área',
                    'compromisso com a continuidade dos projetos em andamento',
                    'presença de vereadores e demais secretários',
                ],
                'quote_roles' => ['prefeito', 'novo secretário'],
            ],
            [
                'key' => 'licitacao',
                'categories' => ['Licitações', 'Transparência', 'Finanças'],
                'media_theme' => MediaCatalog::THEME_CIVICO_ADMINISTRATIVO,
                'gallery_worthy' => false,
                'season' => null,
                'weight' => 1,
                'titles' => [
                    'Prefeitura publica edital de licitação para obras públicas',
                    'Aviso de licitação: interessados podem retirar edital na sede da Prefeitura',
                ],
                'intro_templates' => [
                    'A Prefeitura publicou edital de licitação destinado à contratação de empresas para execução de obras e serviços de interesse público.',
                ],
                'facts' => [
                    'sessão pública marcada para data divulgada no edital',
                    'documentação disponível no portal da transparência',
                    'exigências técnicas detalhadas no termo de referência',
                    'prazo de {days} dias para apresentação de propostas',
                ],
                'quote_roles' => ['presidente da comissão de licitação'],
                'closing_templates' => [
                    'O edital completo está disponível no portal da transparência e na sede da Prefeitura, em horário comercial.',
                ],
            ],
            [
                'key' => 'audiencia_publica',
                'categories' => ['Audiências Públicas', 'Transparência', 'Planejamento'],
                'media_theme' => MediaCatalog::THEME_CIVICO_ADMINISTRATIVO,
                'gallery_worthy' => false,
                'season' => null,
                'weight' => 2,
                'titles' => [
                    'Prefeitura convoca população para audiência pública do orçamento',
                    'Audiência pública debate prioridades para o próximo ano',
                    'Moradores participam de audiência sobre plano diretor',
                ],
                'intro_templates' => [
                    'A Prefeitura realizou audiência pública para apresentar e debater com a população as prioridades orçamentárias para o próximo exercício.',
                ],
                'facts' => [
                    'apresentação da proposta orçamentária por área',
                    'espaço aberto para perguntas e sugestões da população',
                    'registro em ata de todas as contribuições recebidas',
                    'transmissão ao vivo pelas redes sociais oficiais',
                ],
                'quote_roles' => ['Secretário de Planejamento', 'prefeito'],
            ],
            [
                'key' => 'prestacao_contas',
                'categories' => ['Transparência', 'Finanças', 'Administração'],
                'media_theme' => MediaCatalog::THEME_CIVICO_ADMINISTRATIVO,
                'gallery_worthy' => false,
                'season' => null,
                'weight' => 1,
                'titles' => [
                    'Prefeitura apresenta prestação de contas do quadrimestre',
                    'Relatório de gestão fiscal é divulgado à população',
                ],
                'intro_templates' => [
                    'A Prefeitura divulgou o relatório de prestação de contas referente ao quadrimestre, detalhando receitas, despesas e investimentos realizados.',
                ],
                'facts' => [
                    'detalhamento de investimentos por secretaria',
                    'cumprimento dos limites da Lei de Responsabilidade Fiscal',
                    'documento disponível no portal da transparência',
                    'apresentação em sessão na Câmara Municipal',
                ],
                'quote_roles' => ['Secretário de Finanças'],
            ],
            [
                'key' => 'decreto_municipal',
                'categories' => ['Decretos', 'Administração'],
                'media_theme' => MediaCatalog::THEME_CIVICO_ADMINISTRATIVO,
                'gallery_worthy' => false,
                'season' => null,
                'weight' => 1,
                'titles' => [
                    'Prefeitura publica novo decreto municipal',
                    'Decreto regulamenta funcionamento de serviços públicos',
                ],
                'intro_templates' => [
                    'Foi publicado nesta semana um novo decreto municipal, que passa a regulamentar procedimentos administrativos do Poder Executivo.',
                ],
                'facts' => [
                    'publicação no Diário Oficial do Município',
                    'vigência a partir da data de publicação',
                    'elaboração pela Procuradoria Jurídica municipal',
                    'alinhamento com legislação estadual e federal',
                ],
                'quote_roles' => ['procurador-geral do município'],
                'closing_templates' => [
                    'A íntegra do decreto pode ser consultada no Diário Oficial do Município e no portal da transparência.',
                ],
            ],
            [
                'key' => 'processo_seletivo',
                'categories' => ['Processo Seletivo', 'Concursos', 'Administração'],
                'media_theme' => MediaCatalog::THEME_CIVICO_ADMINISTRATIVO,
                'gallery_worthy' => false,
                'season' => null,
                'weight' => 1,
                'titles' => [
                    'Prefeitura abre processo seletivo para contratação temporária',
                    'Edital de concurso público é publicado com {number} vagas',
                ],
                'intro_templates' => [
                    'A Prefeitura publicou edital de processo seletivo simplificado para contratação temporária de profissionais em diversas áreas.',
                ],
                'facts' => [
                    'vagas distribuídas entre educação, saúde e serviços gerais',
                    'inscrições gratuitas realizadas pela internet',
                    'seleção por análise de currículo e prova de títulos',
                    'validade do processo seletivo por {days} dias',
                ],
                'quote_roles' => ['Secretário de Administração'],
            ],
            [
                'key' => 'aposentadoria_servidor',
                'categories' => ['Administração'],
                'media_theme' => MediaCatalog::THEME_CIVICO_ADMINISTRATIVO,
                'gallery_worthy' => false,
                'season' => null,
                'weight' => 1,
                'titles' => [
                    'Prefeitura homenageia servidores aposentados em cerimônia',
                    'Servidores públicos são homenageados por anos de dedicação',
                ],
                'intro_templates' => [
                    'A Prefeitura realizou cerimônia em homenagem a servidores que se aposentaram após anos de dedicação ao serviço público municipal.',
                ],
                'facts' => [
                    'entrega de placas comemorativas aos homenageados',
                    'depoimentos emocionados sobre a trajetória no serviço público',
                    'presença de familiares e colegas de trabalho',
                    'reconhecimento pela contribuição à administração municipal',
                ],
                'quote_roles' => ['prefeito', 'servidor homenageado'],
            ],
            [
                'key' => 'nota_pesar',
                'categories' => ['Notas de Pesar'],
                'media_theme' => MediaCatalog::THEME_CIVICO_ADMINISTRATIVO,
                // Notas de pesar sao textuais por natureza — o acervo nao tem
                // fotos apropriadas para uma nota de falecimento (so cenas de
                // desfile/cerimonia), entao esse topico nunca recebe fotos.
                'skip_media' => true,
                'gallery_worthy' => false,
                'season' => null,
                'weight' => 1,
                'titles' => [
                    'Prefeitura lamenta o falecimento de servidor municipal',
                    'Nota de pesar pelo falecimento de {name}',
                ],
                'intro_templates' => [
                    'A Prefeitura Municipal lamenta profundamente o falecimento de {name}, e presta solidariedade a familiares e amigos neste momento de dor.',
                ],
                'facts' => [
                    'anos de dedicação ao serviço público municipal',
                    'contribuição reconhecida pelos colegas de trabalho',
                    'decretação de luto oficial em sinal de respeito',
                    'condolências manifestadas por toda a administração',
                ],
                'quote_roles' => ['prefeito'],
                'closing_templates' => [
                    'A Prefeitura Municipal se solidariza com familiares e amigos neste momento de dor e reforça seus sentimentos de pesar.',
                ],
            ],
            [
                'key' => 'governo_digital',
                'categories' => ['Tecnologia', 'Governo Digital', 'Comunicação'],
                'media_theme' => MediaCatalog::THEME_CIVICO_ADMINISTRATIVO,
                'gallery_worthy' => false,
                'season' => null,
                'weight' => 1,
                'titles' => [
                    'Prefeitura lança novo portal de serviços digitais',
                    'Serviços públicos agora podem ser solicitados pela internet',
                ],
                'intro_templates' => [
                    'A Prefeitura lançou um novo portal digital que permite à população solicitar serviços públicos sem sair de casa.',
                ],
                'facts' => [
                    'emissão de certidões e alvarás pela internet',
                    'agendamento online de atendimentos presenciais',
                    'redução no tempo médio de espera por serviços',
                    'capacitação de servidores para o novo sistema',
                ],
                'quote_roles' => ['Secretário de Tecnologia', 'Secretário de Administração'],
            ],

            // ------------------------------------------------------------
            // SEGURANÇA / DEFESA CIVIL
            // ------------------------------------------------------------
            [
                'key' => 'entrega_viaturas',
                'categories' => ['Segurança', 'Defesa Civil', 'Administração'],
                'media_theme' => MediaCatalog::THEME_SEGURANCA_DEFESA_CIVIL,
                'gallery_worthy' => true,
                'season' => null,
                'weight' => 1,
                'titles' => [
                    'Prefeitura entrega novas viaturas à Guarda Municipal',
                    'Corpo de Bombeiros recebe nova ambulância',
                    'Frota de segurança é renovada com investimento municipal',
                ],
                'intro_templates' => [
                    'A Prefeitura entregou novos veículos à Guarda Municipal e ao Corpo de Bombeiros, reforçando a capacidade de resposta a ocorrências na cidade.',
                ],
                'facts' => [
                    'investimento de {money} na aquisição dos veículos',
                    'equipamentos de resgate e primeiros socorros incluídos',
                    'renovação de {number}% da frota de segurança',
                    'treinamento das equipes para os novos veículos',
                ],
                'quote_roles' => ['prefeito', 'comandante da Guarda Municipal'],
            ],
            [
                'key' => 'alerta_chuvas',
                'categories' => ['Defesa Civil', 'Segurança'],
                'media_theme' => MediaCatalog::THEME_SEGURANCA_DEFESA_CIVIL,
                'gallery_worthy' => false,
                'season' => [11, 12, 1, 2, 3],
                'weight' => 1,
                'titles' => [
                    'Defesa Civil emite alerta para chuvas intensas',
                    'Prefeitura orienta população sobre riscos de deslizamento',
                ],
                'intro_templates' => [
                    'A Defesa Civil municipal emitiu alerta para chuvas intensas nos próximos dias, orientando moradores de áreas de risco sobre os cuidados necessários.',
                ],
                'facts' => [
                    'monitoramento contínuo de áreas de risco',
                    'disponibilização de abrigos temporários se necessário',
                    'reforço da equipe de plantão durante o período chuvoso',
                    'canal direto de comunicação para emergências',
                ],
                'quote_roles' => ['coordenador de Defesa Civil'],
            ],
        ];
    }
}
