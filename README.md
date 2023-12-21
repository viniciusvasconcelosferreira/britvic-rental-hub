# Britvic Rental Hub

## Descrição

O Britvic Rental Hub é um sistema desenvolvido para proporcionar uma gestão eficiente de uma locadora de veículos.
Permite listar, criar, editar e remover usuários, assim como veículos. Além disso, possibilita a criação, edição e
remoção de reservas de veículos. O sistema garante que um veículo esteja reservado para apenas um usuário por vez,
enquanto um usuário pode reservar diversos carros simultaneamente.

## Objetivo

Este projeto visa criar uma solução robusta para a gestão de locadoras de veículos, abordando os desafios específicos de
reserva, edição de usuários e veículos. Ao desenvolver o Britvic Rental Hub, estará sendo avaliado a capacidade dos
candidatos a Analista Web da Britvic Brasil em lidar com requisitos complexos, aplicar boas práticas de desenvolvimento
e demonstrar proficiência técnica em tecnologias como Laravel, Bootstrap e Vue.js.

**Aspectos a serem avaliados:**

- Capacidade de implementar funcionalidades completas de um sistema web.
- Adoção de boas práticas de programação e padrões de design.
- Habilidade em validar e armazenar dados de forma segura e eficiente.
- Uso adequado de tecnologias front-end e back-end.
- Implementação de lógica de negócios para garantir consistência e integridade dos dados.

## Tecnologias Utilizadas

- PHP 8+
- Laravel 10+
- Bootstrap 5+
- Vue 3+
- MySQL

## Especificações Técnicas

- Armazenamento de nome e CPF dos usuários, data de inserção no banco de dados.
- Armazenamento do modelo, marca, ano e placa do veículo.
- Armazenamento das reservas realizadas.
- Validação de todos os dados inseridos no sistema.
- Evento que registra no log do Laravel a id do usuário e a id do veículo reservado.
- Job programado para execução duas vezes ao dia, sem lógica no método handle.
- Migrações das tabelas do sistema no repositório.
- Adoção do padrão MVC.
- Tratamento adequado de erros.
- Utilização do Laravel Mix para compilação de dependências.
- Utilização do Bootstrap para construção do front-end.

## Pré-requisitos

- PHP 8
- Composer
- Node.js
- NPM ou Yarn

## Instalação e Execução

1. Clone este repositório:
   ```bash
   git clone https://github.com/seu-usuario/britvic-rental-hub.git
   ```

2. Acesse o diretório do projeto:
   ```bash
   cd britvic-rental-hub
   ```

3. Instale as dependências do Laravel:
   ```bash
   composer install
   ```

4. Copie o arquivo de configuração `.env`:
   ```bash
   cp .env.example .env
   ```

5. Configure o arquivo `.env` com suas informações de banco de dados.

6. Gere a chave de aplicativo:
   ```bash
   php artisan key:generate
   ```

7. Instale as dependências do NPM ou Yarn:
   ```bash
   npm install
   # ou
   yarn
   ```

8. Compile os assets usando o Laravel Mix:
   ```bash
   npm run dev
   # ou
   yarn dev
   ```

9. Execute as migrações para criar as tabelas necessárias no banco de dados:
   ```bash
   php artisan migrate
   ```

10. Inicie o servidor Laravel:
    ```bash
    php artisan serve
    ```

11. Acesse o sistema pelo navegador: [http://localhost:8000](http://localhost:8000)

## Licença

Este projeto é licenciado sob a [Licença MIT](LICENSE).
