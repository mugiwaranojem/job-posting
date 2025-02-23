# job-posting
Job Posting App

## Prerequisite
- Docker 2.4 (or latest)
- Docker Compose 1.27.4 (or latest, usually included in docker insall setup)
- Composer 2.0 (or latest)
- Git
- PHP 7.4 or higher
- Mysql Client (Workbench or DBeaver)
- Postman (Optional)

## Stacks
- Laravel
- Docker
- docker-compose
- VueJs
- Boostrap
- Mysql
- PHP 8.2


## Description
The app is build using docker mainly to containerize Laravel & DB,  
Frontend on the otherhand is a separate setup where it can run on host machine and it calls API endpoint laravel,  
In this architecture it is independent working for BE and FE, so different team can work on different stack without too much dependent on each other  
Laravel app solely purpose is for API endpoint using Eloquent Resource API to easily manipulate data being passed to client  
Service Pattern is demonstrated on this codebase were all logic reside in it, 
improvements would be to add a Repository layer were all data manipulation will handled here but the design is all good for simplicity for simple app  

### Setup the APP
1. clone repo
```
git clone https://github.com/mugiwaranojem/job-posting.git
docker-compose up
```
2. Setup BE
In separate terminal  
```
cd api
composer install
cp .env.example .env

# .env file should contain the follwing details
APP_URL=http://localhost:8000
DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=api_db
DB_USERNAME=root
DB_PASSWORD=root

# Update default moderator email
To test approval of job post update env param
```
MODERATOR_EMAIL=YOUR_EMAIL
```

# in new window terminal, setup laravel app
docker exec -it job_posting_web php artisan key:generate
docker exec -it job_posting_web php artisan migrate
docker exec -it job_posting_web php artisan jobs:sync
```
2. Setup FE
```
cd website
npm install
npm run dev
```
3. Test the APP
Open in broswer http://localhost:5173/ or replace what ever port is being dispalyed in run dev in my case its :5173


### API Doc
```
# Import to PostMan
./api/api.postman_collection.json
```

### References
- https://laravel.com/docs/11.x/eloquent-resources#resource-collections  
- https://laravel.com/docs/11.x/notifications#formatting-mail-messages  
- https://vuejs.org/guide/quick-start.html  
- https://getbootstrap.com/docs/5.3/getting-started  
- https://www.tiny.cloud/docs/tinymce/5/vue/  

