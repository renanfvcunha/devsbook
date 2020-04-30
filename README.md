## Instalação
Você pode clonar este repositório OU baixar o .zip

Ao descompactar, é necessário rodar **composer** e o **npm** pra instalar as dependências e gerar o *autoload* do projeto.

Vá até a pasta do projeto, pelo *prompt/terminal* e execute:
> composer install
> npm install

Para utilizar o **docker-compose** é só rodar o comando:
> docker-compose up -d
E então seguir as instruções de Post Install.

Depois é só aguardar.

## Configuração
Copie o arquivo **.env.example** e cole como **.env** e então insira todas
as credenciais e configurações necessárias.
Todos os arquivos da aplicação estão dentro da pasta *src*.

## Uso
Para o uso com docker-compose, o nginx já está configurado para
usar a pasta public como root.

Caso seja configurado manualmente, você deve acessar a pasta *public* do projeto.
O ideal é criar um ***alias*** específico no servidor que direcione diretamente para a pasta *public*.

## Modelo de MODEL
```php
<?php
namespace src\models;
use \core\Model;

class Usuario extends Model {

}
```