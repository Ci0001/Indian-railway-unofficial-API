# Indian Railway Unofficial API
A RESTful API using [Slim PHP micro-framework](https://www.slimframework.com) to get simple yet handy details about trains, stations, seat availability and much more.


[![License](https://img.shields.io/packagist/l/dingo/api.svg?style=flat-square)](LICENSE)

## DISCLAIMER
  This API is in no way related to IRCTC or any other backened entity of Indian Railway. It's just a pastime project i did to test my understanding of REST Architecture.
## Requirements
- Composer.
- PHP >= 8.1
##  DEPENDENCIES:
- [slim/slim](https://github.com/slimphp/Slim): Slim is a PHP micro framework that helps you quickly write simple yet powerful web applications and APIs.
- [slim/psr7](https://github.com/slimphp/Slim-Psr7): PSR-7 implementation for use with Slim 4.
- [pimple/pimple](https://github.com/silexphp/Pimple): A small PHP dependency injection container.
- [vlucas/phpdotenv](https://github.com/vlucas/phpdotenv): Loads environment variables from `.env` to `getenv()`, `$_ENV` and `$_SERVER` automagically.
## Installation & Run. 
#### 1.  Clone or Download this project
```bash
   git clone https://github.com/Ci0001/Indian-railway-unofficial-API.git
```
#### 2.  Install Dependencies
```bash
   composer install
```
#### 3.  Change Directory to public and serve
```bash
   cd public

   php -S localhost:8181
   # API Endpoint : http://localhost:8181
```

## Structure
```

├── assets                     
├── composer.json
├── composer.lock
├── public
│   └── index.php                
└── src
    ├── App
    │   ├── App.php
    │   ├── Container.php
    │   ├── Cors.php              
    │   ├── CustomResponse.php
    │   ├── Database.php
    │   ├── DotEnv.php
    │   ├── ErrorHandler.php
    │   ├── Middlewares.php
    │   ├── NotFound.php
    │   ├── Repositories.php
    │   ├── ResponseFactory.php
    │   ├── Routes.php
    │   └── Services.php
    └── Controller
        ├── Home.php
        └── Train.php

```

## API

#### /v1/stations 
* Desc: `Get list of stations in json format`
* Type: `GET`

#### /v1/trains/{number}/schedule 
* Desc: `Get train schedule by train number`
* Type: `GET`
* Params: `number`=>train number

#### /v1/trains/reservation-chart/train-composition
* Desc: `Retrieves reservation chart details based on train no, journey date and boarding station`
* Type: `POST`
* Params: `jrnyDate`=> train number \
           `boardingStation`=> boarding station\
            `train_no`=> train number

#### /v1/trains
* Desc: `Retrieves trains between stations`
* Type: `POST`
* Params: `src`=> source station \
           `dest`=> destination station\
            `date`=> journey date


## License

This package is licensed under the [BSD 3-Clause license](http://opensource.org/licenses/BSD-3-Clause).