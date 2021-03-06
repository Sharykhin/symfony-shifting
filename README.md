Customer Invoices Aggregator:
-----------------------------

Service provides aggregated information about
customer expenses based on their invoices and
specifies how to save some money.


#### Requirements:

[Docker](https://www.docker.com/)

#### Usage:
1. After installing docker pleae ensure that `docker-compose` is also available:
```bash
docker-compose version
```

2. Build all services:
```bash
docker-compose build
```

3. Up and run all containers:
```bash
docker-compose up
```

When it run, it will automatically run installing composer dependencies, so for 
the first time it may take a couple of minutes.

4. Open a browser on [http://localhost:8000/ping](http://localhost:8000/ping) to check whether
everything works as expected.

#### PHPUnit Code Coverage

To see phpunit code coverage open browser on [http://localhost:8005](http://localhost:8005)

#### MailDev Dashboard

In development mode MailDev is in use for sending mails. Dashboard is available by 
the following link [http://localhost:1080](http://localhost:1080)


#### RabbitMQ Dashboard

By default RabbitMQ is in use for a queue engine. Dashboard is available by the 
 following link [http://localhost:8080](http://localhost:8080), credentials: *guest*/*guest*
 
#### Endpoints Usage:
There are three predefined query parameters:
- *_locale* - `en|ru`, `en` by default set the locale of request
- *_debug* - `true|false`, `false` by default. If it is true response will contain
    `_debug` field with all sql queries
- *_mode* - `dev|prod`, `dev` by default. Switches environment mode. So you can check 
some behaviour like on production mode.