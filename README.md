# Dados-abertos-da-camara

Projeto: Consumo da API Dados Abertos da Câmara dos Deputados

Integrantes:

- Isadora Rodrigues Serafim
- Isaac Aparecido da Cunha
- Saulo Pereira da Silva

Explicação:

Este projeto é uma página PHP que consome dados da API Dados Abertos da Câmara dos Deputados.

O código utiliza cURL para fazer três requisições:

Buscar deputados:
Acessa o link `https://dadosabertos.camara.leg.br/api/v2/deputados?itens=513` para listar todos os deputados federais.

Buscar gastos:
Para cada deputado, acessa `https://dadosabertos.camara.leg.br/api/v2/deputados/{id}/despesas` para buscar o último gasto registrado.

Buscar votações:
Também para cada deputado, busca `https://dadosabertos.camara.leg.br/api/v2/deputados/{id}/votacoes` para mostrar as votações mais recentes.

Os dados retornados em formato JSON são convertidos para arrays PHP usando json_decode(). Depois, no HTML, eles são exibidos de forma organizada:

- Foto do deputado
- Nome, Partido e Estado (UF)
- Último gasto declarado
- Últimas votações (com descrição, tipo de voto e data)

Se não conseguir carregar os dados, aparece uma mensagem de erro na tela.

Tecnologias Usadas:

- PHP (linguagem principal)
- cURL (para fazer requisições HTTP)
- HTML (estrutura da página)

Instruções de Execução 
--------------------------------
1 - Na página inicial do repositório acesse a aba Files e baixe o repositório Dados-aberturas-da-camara em formato zip.
--------------------------------
2 - Na sua máquina, extraia o arquivo em formato zip.
--------------------------------
3 - Mova o arquivo extraído para a pasta localizada em (Disco Local C:Xampp/htdocs).
--------------------------------
4 - Feito isso, abra o painel Xampp e ligue o Apache e o MySQL.
--------------------------------
5 - No navegador digite http://localhost/Dados-abertos-da-camara-main/Dados-abertos-da-camara-main/ para acessar a API com as informações requisitadas.
--------------------------------
#Observação: Caso entrar apenas no http://localhost/Dados-abertos-da-camara-main/ vai aparecer dois links "Parent directory" e "Dados-abertos-da-camara", acesse o segundo link.

Caso tudo esteja correto, a página vai carregar os dados diretamente da API da Câmara dos Deputados.

