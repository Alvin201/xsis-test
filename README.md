#step
IMPORTANT: .env.example rename to .env
1. create database in phpmyadmin -> test_xsis
2. change DB_DATABASE = test_xsis filename .env
3. php artisan jwt:secret -> yes
4. php artisan migrate
5. php artisan serve
6 open url http://localhost:8000/api
