Тестовое задание
1. Написать парсер курсов с BestChange.
Реализовать загрузку архива курсов с BestChange по адресу http://api.bestchange.ru/info.zip. Курсы находятся в файле bm_rates.dat.
Файл состоит из набора строк по типу “117;89;454;66.82258603;1;123638.43;0.2506;1”, где первое число - идентификатор отправляемой валюты, второе – идентификатор получаемой валюты, четвёртое – курс отправления, пятое – курс получения.
Необходимо найти максимально выгодный курс для каждой пары валют, то есть курс того обменника, который стоит на первом месте на каждой валютной пары в BestChange.

К примеру, на скриншоте выбрана валютная пара Bitcoin -> Zcash. Соответственно нужно выбирать курс обменника FixedFloat. Все выгодные курсы записывать в БД.
2. Написать REST API для получения выгодных курсов.
Реализовать два метода:
GET /courses – получение массива всех курсов с фильтрацией
Возможные фильтры:
• Отправляемая валюта
• Получаемая валюта
GET /course/$send_currency/$recive_currency, где: $send_currency – отправляемая валюта, $recive_currency – получаемая валюта.
Все запросы должны подписываться токеном Bearer.

Тестовое задание должно быть выполнено c использованием фреймворка Laravel.
На выходе должны получить:
1. Git-репозиторий либо архив с кодом программы
2. Скриншот структуры базы данных и заполненных таблиц


## Run application

1. Copying the **env** configuration file :
    ```sh
    cp .env.example .env
    ```
   **Enter own configs...!!!!!** Don`t forget set TOKEN_SERVICE


2. Build php-apache application :
    ```sh
    docker-compose build
    docker-compose up
    docker-compose exec -T "$(CONTAINER_NAME)" composer install --optimize-autoloader --no-interaction --ansi --no-suggest
    docker-compose exec "$(CONTAINER_NAME)" php artisan key:gen
    docker-compose exec "$(CONTAINER_NAME)" php artisan migrate:fresh --seed
    docker-compose exec "$(CONTAINER_NAME)" php artisan storage:link
    ```
3. Run console command for import :
    ```sh
   docker-compose exec "$(CONTAINER_NAME)" php artisan app:import-best-rates
    ```

4. Endpoints :
    *  /courses - get list( allowed request arg: 'from' && 'to')
    *  /courses/{send_currency}/{receive_currency} - get best currency
    *  /courses/refreshRate - refresh best currency

5. Stop and clear services
    ```sh
    make down
    ```
##  Скриншот структуры базы данных и заполненных таблиц
![Screenshot from 2023-06-14 17-36-12.png](..%2F..%2FPictures%2FScreenshot%20from%202023-06-14%2017-36-12.png)
