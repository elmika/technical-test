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

(pending)
We will use openapi format to describe our endpoint.



# Project explanation

- Cache management (pending): if we do a request for the csv file asking only for the headers we can see the last time it has been updated. This can be used to set up a strategy of caching the file in our local system.

- Application Service: all the logic is in this service.

- DDD (pending):
    - UserList should be an entity.
    - User should be an Entity. Value objects may be used as attributes, especially emails and country codes.
    - We need to define a repository interface, and implement it in the infrastucture layer with the logic of retrieving the data from the public csv file.