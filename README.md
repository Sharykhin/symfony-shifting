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

4. Install project dependencies:
```bash
docker-compose exec invoicer-php composer install
```

5. Open browser on [http://localhost:8000](http://localhost:8000) to check whether
everything works as expected.
