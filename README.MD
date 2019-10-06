# **Projeto back-end my-test**

#### Passos para instalar o projeto:
 
##### 1. Clone o projeto:
    git clone https://github.com/maxwellkenned/my-test.git

##### 2. Configure as informações do banco de dados:
    Acesse o seguinte arquivo para configurar as variaveis de acesso ao banco de dados:
    config/packages/parameters.yaml.dist


##### 3. Instale as dependências:
    composer install
                                                  
##### 4. Crie o Banco de dados:
    php bin/console doctrine:database:create
    
##### 5. Criar as tabelas no banco:
    php bin/console doctrine:migrations:migrate

#### Passos para executar o projeto:
    php bin/cosole server:run
