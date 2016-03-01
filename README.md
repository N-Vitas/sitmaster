
Yii 2 Advanced Project Template
===============================

Реализация создания сервиса helpdesc [sitmaster.kz](http://sitmaster.kz) творческой группы "Совершенство информационных технологий"

Для реализации проэкта используется framework Yii 2

СТРУКТУРА ПРОЕКТА
-------------------

```
api
    components/  
    config/                        
    modules/             
    controllers/     
    runtime/ 
    web/
common
    config/              
    mail/       
    models/     
console
    config/              
    controllers/
    migrations/          
    models/     
    runtime/    
backend
    assets/     
    config/              
    controllers/
    models/     
    runtime/    
    views/      
    web/        
frontend
    assets/     
    config/              
    controllers/
    models/     
    runtime/    
    views/      
    web/        
    widgets/    
vendor/         
environments/   
tests           
    codeception/
```
=======
# sitmaster
Репозоторий проэкта сервиса техподдержки

## Установка

### Через git clone

* Склонируйте репозиторий и установите все зависимости Composer

```shell
git clone git@github.com:N-Vitas/sitmaster.git newproject
cd newproject
composer install
```

## Инициализируйте окружение
```
./init
```

## Авто-настройка
```shell
./yii setup
```
```
Enter project name (new):  shinyalmaty // название проекта
Enter URL (new.local):     shiny.nik   // домен проекта на локальной машине (будут созданы 3 символьные ссылки на папку выше f.sh3.nik,  b.sh3.nik и sh3.nik )
Mysql host (localhost):   [localhost]
Mysql user (root):        [root]
Mysql password:           123
Mysql DB:                 shiny // база будет создана, если не существует.

Create DB 'shiny'? (yes|no) [no]:yes
Project setting:
{
    "name": "shinyalmaty",
    "url": "shiny.nik"
}
DB setting:
{
    "host": "localhost",
    "user": "root",
    "pwd": "123",
    "dbname": "shiny"
}
All right? (yes|no) [no]:yes
Fine! Let's go further

Create params...   Done!
Create symlinks...   Done!

Set DB params...   Done!
Migration Done!

 Done!

Init repository...

 Done!

Create repository on gitlab...
Done!

Pushing to gitlab...

```

## Ручная настройка
* Установите доступы к Базе Данных в файле `common\config\main-local.php`
* Запустите миграции приложения


```shell
./yii migrate/up --migrationPath=@yii/rbac/migrations
./yii migrate/up --migrationPath=@vendor/dektrium/yii2-user/migrations
./yii migrate/up --migrationPath=@funson86/setting/migrations
./yii migrate/up
```