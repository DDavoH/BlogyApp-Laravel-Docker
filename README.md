# BlogyApp-Laravel-Docker

Pasos para instalar:

## Construir contenedores
docker-compose up -d --build

## Ver y acceder al contenedor del proyecto laravel
docker ps        
docker exec -it c081a9397e04 sh        

## Dentro del contenedor ejecutar los siguientes comandos
composer update   
php artisan migrate

## Copiar el contenido de .env.example en .env

## Listo!, cualquier duda contactenme: davoh.dev@gmail.com