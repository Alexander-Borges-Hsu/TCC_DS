# TCC_DS  
Repositório para o Desenvolvimento do TCC - Técnico em Desenvolvimento de Sistemas
  Passos fundamentais para a inicialização da aplicação
  - Clonar o repostório em C:\xampp\php
  - Entrar na pasta projetoTCC pelo CMD - C:\xampp\php\TCC_DS\ProjetoTCC>
  - Instalar o composer com - composer install (Arquivo php.ini tem que estar com a linha "extension=zip" sem o ";"
  - Instalar o npm com - npm install (Tem que ter o node.js instalado)
  - Rodar o npm com - npm run build
  - Criar um novo arquivo .env com - copy .env.example .env
  - Descomentar as linhas sobre database do novo arquivo .env e mudar a linha DB_CONNECTION para mysql
  - Verificar se nas variáveis de ambiente PATH contém a referencia do php do xampp com - C:\xampp\php - caso tenha outro php sendo referenciado pode dar conflitos
  - Gerar uma chave com - php artisan key:generate
  - Ligar o banco e rodar as migrações com - php artisan migrate
