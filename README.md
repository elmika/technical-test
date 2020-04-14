El sistema de gestión de usuarios almacena la información en un archivo CSV dinámico ​users.csv​ actualizado cada 24 horas. La información está estructurada en las siguientes columnas:

- Identificador de la estancia (columna 0)
- Nombre del cliente (columna 1)
- Apellido del cliente (columna 2)
- Email (columna 3)
- Código ISO2 del país de residencia (columna 4)
- Fecha de creación del usuario (columna 5)
- Fecha de activación del usuario (columna 6)
- Código del cargador (columna 7)

# Environment setup

### Run local server

````
php -S 127.0.0.1:8000 -t public
```` 

Run tests

./bin/phpunit

Code coverage - pending.

### List users found in csv file:

````
curl http://localhost:8000/users
````
Apply some filters: Activation length
````
curl "http://localhost:8000/users?activation_length=25"
````

Apply some filters: Countries
````
curl "http://localhost:8000/users?countries=US"

curl "http://localhost:8000/users?countries=JP,RU"
````

Apply some filters: Both
````
curl "http://localhost:8000/users?activation_length=25&countries=FR,ES"
````



### API documentation

Published on Swagger Hub: https://app.swaggerhub.com/apis/elmika/technical-test/1.0.0



# Project explanation

- Cache management (pending): if we do a request for the csv file asking only for the headers we can see the last time it has been updated. This can be used to set up a strategy of caching the file in our local system.

- Application Service: all the logic is in this service.

- DDD:
    - UserList should be an entity.
    - User is implemented as Value object, but should probably be an Entity (you may have to update email)
    - Value objects may be used as attributes, especially for emails and country codes.
    - Repository interface defined in the Domain. Implemented in the infrastucture layer with the logic of retrieving the data from the public csv file.
    - Criteria only contains logic for filtering. Could also do ordering.
    
- Exception handling - pending