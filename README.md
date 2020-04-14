# Environment setup

### Run local server

````
php -S 127.0.0.1:8000 -t public
```` 

Run tests

./bin/phpunit

### Examples

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

- DDD structure:    
    - User is implemented as Value object, and contains only user information: name, surname, email and country.
    - UserRegistration is an entity identified by the filed Id. We proposed a logic of dealing with non registered users and possible posterior registration, even if this is out of the scope of this excercise.
    - UserRegistrationCollection is a list of UserRegistration and contains logic for filtering and ordering.
    - A Repository interface is defined in the Domain, implemented in the Infrastucture layer, used in the Application layer and instanciated in the Controller.
    - Criteria is used to apply modifying logic of the collection of registration. At the moment, it only contains logic for filtering.
- Further possible steps:
    - Value objects could be introduced as attributes, especially for emails and country codes.
    - Introduce caching strategy to retrive csv (retrieve header with HEAD request and see if newer version has been published)
    - Introduce ordering logic in Criteria.
    - Define app specific exceptions, introduce corresponding exception handling