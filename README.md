
**Instruction**

If you have installed docker and docker compose  in your pc
then just goto the project root folder then run this command

./lunch

Also you can create by Docker command
 
 docker-compose up --build

Without docker you can install this project by this 
 
php artisan migrate --seed


***Run any composer command***

docker-compose exec app composer list

***Run any command***

docker-compose exec php artisan _____


***Publish Documentation***

docker-compose exec app php artisan l5-swagger:generate
