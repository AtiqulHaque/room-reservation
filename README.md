[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](https://opensource.org/licenses/MIT)

**Purpose of this project**

its a very tiny little booking system or you can say it  starter project of laravel. if any one initialize a backend API
for any project he can use it. I try to flow all the best practise in this project.
Such as 
1. Service repository pattern.
2. JWT token Authentication.
3. Api Documentation.
4. Docker and Docker compose file.
5. Postman Collection.
6  Unite Test.


**Internal diagram**
![booking_system.png](https://eastceylon.com/images/2021/04/14/booking_system.png)


**Instruction**

If you have installed docker and docker compose  in your pc
then just goto the project root folder then run this command

./lunch

Also you can create by Docker command
 
 docker-compose up -d

Without docker you can install this project by this 
 
php artisan migrate --seed


***Run any composer command***

docker-compose exec app composer list

***Run any command***

docker-compose exec php artisan _____


***Publish Documentation***

docker-compose exec app php artisan l5-swagger:generate

<a href="https://ibb.co/hfvQdKN"><img src="https://i.ibb.co/4dxvSjL/booking-system-doc.png" alt="booking-system-doc" border="0"></a>




