
**Instruction**

If you have installed docker and docker compose  in your pc
then just goto the project root folder then run this command

./setup

Enter your root password 

After complete installation


***Frontend Browse :  http://localhost:3033***

***Backend Browse :  http://localhost:8000/api***

***Database Browse :  http://localhost:8085***

***Database Credentials :  Server=my_db,  username=root,  password=your_mysql_root_password*** 




Also you can create by Docker command
 
 docker-compose up -d --build

Without docker you can install this project by this 
 
php composer install

php artisan migrate --seed


***Run any composer command***

docker-compose exec app composer list

***Run any command***

docker-compose exec php artisan _____

***Run Unit Test***

./run-unit-test

***Publish Documentation***

docker-compose exec app php artisan l5-swagger:generate
