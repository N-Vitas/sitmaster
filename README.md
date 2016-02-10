
Yii 2 Advanced Project Template
===============================

Реализация создания сервиса helpdesc [sitmaster.kz](http://sitmaster.kz) творческой группы "Совершенство информационных технологий"

Для реализации проэкта используется framework Yii 2

СТРУКТУРА ПРОЭКТА
-------------------

```
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