Projeto Devsbook da B7Web modificado por Renan Cunha.

## Instalação
- Você pode clonar este repositório OU baixar o .zip

- Ao descompactar, é necessário rodar **composer** e o **npm** para instalar as
dependências do projeto, então certifique-se de que tem esses gerenciadores
de pacote instalados.

- Para isso, navegue até a pasta do projeto pelo *prompt/terminal* e execute:
> composer install

> npm install

- Para utilizar o **docker-compose**, execute:
> docker-compose up -d
- E então siga as instruções de Post Install do arquivo docker-compose.yml.

## Configuração
- Copie o arquivo **.env.example** e cole como **.env** e então insira todas
as credenciais e configurações necessárias.

- Dê permissão de escrita para a pasta **logs** (caso não exista, crie-a) para
que os logs possam ser registrados.
> chmod -R 777 logs

- Se estiver utilizando o docker-compose, execute:
> docker container inspect mysql-devsbook
e então procure o endereço ip do mysql para setar no DB_HOST do arquivo **.env**

- Todos os arquivos da aplicação estão dentro da pasta *src*.

- As alterações nos arquivos javascript devem ser feitas na pasta
*js* dentro de *src* e, em seguida, executar o comando
> npx webpack --mode=production
para que sejam compilados para a pasta public.
- Caso não queira setar o comando mais de uma vez, basta executar
> npx webpack --mode=production --watch
para que o webpack compile automaticamente todas as alterações.

## Uso
- Para o uso com docker-compose, o nginx já está configurado para
usar a pasta public como root.

- Caso seja configurado manualmente, você deve acessar a pasta *public* do projeto.
O ideal é criar um ***alias*** específico no servidor que direcione diretamente
para a pasta *public*.

## Modelo de MODEL
```php
<?php
namespace src\models;
use \core\Model;

class Usuario extends Model {

}
```