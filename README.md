IT Hardware Management
========================

Installation:
--------------
1. Clone repository.
2. Run composer.
3. Set up database parameters.
4. Go to http://127.0.0.1:8000/api/doc/ for api instructions


Additional information:
---------------------------
1. You can load data fixtures - just type: app/console doctrine:fixtures:load
2. Examples requests:
    - curl -i -H "Accept: application/json" http://127.0.0.1:8000/api/v1/categories -> list categories
    - curl -i -H "Accept: application/json" -H "Content-Type: application/json" \
        -d '{"name":"Acer", "serial":"AZ-123", "available":true, "category":48}' \
        http://127.0.0.1:8000/api/v1/hardwares -> add new hardware

