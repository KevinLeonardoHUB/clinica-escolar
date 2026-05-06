# Clínica Escolar

Projeto de uma clínica escolar desenvolvido com **PHP**, **MySQL**, **HTML**, **CSS** e **JavaScript**.

O sistema permite que alunos se registem, façam login, marquem consultas, cancelem consultas e recebam confirmação por email.

## Funcionalidades

- Registro de alunos
- Login e logout
- Verificação de email
- Marcação de consultas
- Cancelamento de consultas
- Listagem das consultas do aluno
- Geração de horários disponíveis
- Envio de emails com PHPMailer
- Páginas informativas sobre a clínica

## Tecnologias usadas

- PHP
- MySQL
- HTML
- CSS
- JavaScript
- PHPMailer
- XAMPP

## Estrutura do projeto

```txt
clinica-escolar/
├── clinica_escolar/
│   ├── api/
│   ├── css/
│   ├── imagens/
│   ├── javascript/
│   ├── lib/
│   ├── index.php
│   ├── login.php
│   ├── registro.php
│   ├── contactos.php
│   ├── minhas_consultas.php
│   ├── pagina_consultas.php
│   └── sobre.php
├── database/
│   └── codigo_mysql.sql
├── .env.example
├── .gitignore
└── README.md
```

## Como executar localmente

1. Instalar o XAMPP.
2. Copiar a pasta `clinica_escolar` para dentro da pasta `htdocs` do XAMPP.
3. Iniciar o **Apache** e o **MySQL** no painel do XAMPP.
4. Abrir o phpMyAdmin.
5. Importar o arquivo:

```txt
database/codigo_mysql.sql
```

6. Aceder ao site pelo navegador:

```txt
http://localhost/clinica_escolar/
```

## Configuração da base de dados

Por padrão, o projeto usa a configuração comum do XAMPP:

```php
$host = 'localhost';
$dbname = 'clinica_escolar';
$user = 'root';
$pass = '';
```

Esses valores estão no arquivo:

```txt
clinica_escolar/api/db.php
```

Em hospedagem online, configure as variáveis de ambiente:

```txt
DB_HOST
DB_NAME
DB_USER
DB_PASS
```

## Configuração de email

O projeto usa PHPMailer para enviar emails. Por segurança, a senha do email não deve ficar escrita diretamente no código.

Use as variáveis de ambiente abaixo:

```txt
SMTP_HOST
SMTP_PORT
SMTP_USER
SMTP_PASS
SMTP_FROM
SMTP_FROM_NAME
```

Existe um arquivo de exemplo chamado:

```txt
.env.example
```

Copie esse arquivo, ajuste os valores e configure no seu ambiente local ou na hospedagem.

## Observação importante

Este projeto **não funciona no GitHub Pages**, porque o GitHub Pages só executa sites estáticos com HTML, CSS e JavaScript.

Como este projeto usa **PHP** e **MySQL**, o GitHub deve ser usado para guardar e apresentar o código. Para colocar o site online funcionando, é necessário usar uma hospedagem com suporte a PHP e MySQL.

## Autor

Quévin Tavares
