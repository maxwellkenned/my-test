# **Projeto back-end my-test**

#### Passos para instalar o projeto:
 
##### 1. Clone o projeto:
    git clone https://github.com/maxwellkenned/my-test.git

##### 2. Instale as dependências:
    composer install

##### 3. Configure as informações do banco de dados:
    acesse o seguinte arquivo para configurar as valiaveis de acesso ao banco:
    config/packages/parameters.yaml
                                                  
##### 4. Crie o Banco de dados:
    php bin/console doctrine:database:create
    
##### 5. Criar as tabelas no banco:
    php bin/console doctrine:migrations:migrate

#### Passos para executar o projeto:
    php bin/cosole server:run
