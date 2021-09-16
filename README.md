
 ### **Instruction**

If you have installed docker and docker compose  in your pc
then after clone the project just goto the project root folder then run this command

./setup

Enter your root password 

After complete installation

<br>

***Frontend Browse :  http://localhost:3033***

***Backend Browse :  http://localhost:8000/api***

***Database Browse :  http://localhost:8085***

***Database Credentials :  System= PostgresSQL, Server=database,  username=postgres,  password=secret*** 

<br>
<br>


For check Backend API check Postman collection

- Room_Reservation.postman_collection.json
- Room-reservation-dev.postman_environment.json



Also you can create by Docker command
 
 - docker-compose up -d --build

Without docker you can install this project by this 
 
- php composer install

- php artisan migrate --seed


***Run booking command***

- docker-compose exec app php artisan book:rooms

***Run Unit Test***

./run-unit-test

***Publish Documentation***

- docker-compose exec app php artisan l5-swagger:generate

***Run Lint***

- composer phplint

***Run Phpcs***

- composer phpcs

***Run Phpcbf***

- composer phpcbf

<br>
<br>

***For Backend API check Postman collection***

- Room_Reservation.postman_collection.json
- Room-reservation-dev.postman_environment.json

