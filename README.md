# Projeto RhSystem

### Objetivo do Projeto
O projeto RhSystem visa criar uma aplicação web para gerenciar informações de funcionários, incluindo o cadastro, visualização e análise de dados. Ele oferece funcionalidades como inserção de novos funcionários, atualização da tabela de funcionários, remoção de dados da tabela e geração de gráficos para análise da distribuição etária dos funcionários. *É uma aplicação bem básica solicitada como teste de conhecimento para uma vaga de emprego.*

## Tecnologias Utilizadas
- HTML: Linguagem de marcação para estruturar o conteúdo da página web.
- CSS (Bootstrap): Framework CSS para estilizar e tornar a interface mais atraente e responsiva.
- JavaScript: Linguagem de programação para adicionar interatividade e dinamismo à aplicação.
- PHP: Linguagem de programação para lidar com a lógica de negócios do lado do servidor, como conexão com o banco de dados e manipulação de dados.
- MySQL: Banco de dados relacional utilizado para armazenar informações dos funcionários.
- XHR (XMLHttpRequest): Objeto JavaScript usado para fazer requisições HTTP assíncronas ao servidor, permitindo atualizações dinâmicas de conteúdo sem recarregar a página.
- GD Library: Biblioteca em PHP para criar gráficos dinâmicos e gerar imagens, utilizada para criar os gráficos de distribuição etária dos funcionários.
Como Funciona

### Cadastro de Funcionários: 
Os funcionários podem ser inseridos no banco de dados através de um formulário onde são informados o nome, sobrenome, idade, data de admissão, área e salário do funcionário.

### Atualização da Tabela de Funcionários: 
Ao clicar no botão "Atualizar Tabela", os dados dos funcionários cadastrados no banco de dados são recuperados e exibidos em uma tabela na página.

### Remoção de Dados da Tabela: 
O botão "Apagar tabela" permite remover todos os dados da tabela de funcionários no banco de dados. E ocultar o gráfico.

### Geração de Gráficos: 
Ao clicar no botão "Atualizar Tabela", um gráfico de distribuição etária dos funcionários é gerado dinamicamente utilizando a GD Library do PHP. O gráfico é exibido na página como uma imagem, mostrando a quantidade de funcionários em cada faixa etária.

## Scripts do Banco de Dados
Antes de iniciar o projeto RhSystem, certifique-se de executar os scripts fornecidos em "Scripts BD.txt" para criar o banco de dados necessário. Os scripts incluem a criação das tabelas e a definição das relações necessárias para armazenar os dados dos funcionários.

# Execução do Projeto 
## Para iniciar o projeto RhSystem, siga estas etapas:

### Configuração do Servidor Apache: 
Certifique-se de que o servidor Apache esteja instalado e em execução na sua máquina. Você pode usar soluções como XAMPP, WAMP ou MAMP para configurar um ambiente de desenvolvimento local.

### Configuração da Extensão GD: 
Verifique se a extensão GD está habilitada no PHP. Isso é necessário para que o projeto possa gerar gráficos dinâmicos. Você pode habilitar a extensão GD descomentando a linha extension=gd no arquivo php.ini e reiniciando o servidor Apache.

### Execução do Projeto: 
Coloque todos os arquivos do projeto dentro do diretório do servidor web. Certifique-se de que o servidor Apache esteja em execução e acesse o projeto através do seu navegador web, digitando o endereço correspondente (por exemplo, http://localhost/RhSystem).
