# Environment setup

### Run Docker container

In prod (Disclaimer: server is not configured for prod yet)
````
docker build -t "registration-exercise" .

docker run --rm -p 8000:80 --name=simple_person "registration-exercise"
```` 

In dev
````
make rebuild
````


Run tests

```` 
make tests
```` 

Review and fix identation

```` 
make sniff
````

```` 
make clean
````  

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
    - User is implemented as an Immutable object, and contains only user information: name, surname, email and country.
    - Value objects: id, emails, country codes, etc.
    - UserRegistration is the root Agregate. 
    - We proposed a logic of dealing with non registered users and possible posterior registration.
    - UserRegistrationCollection is a list of UserRegistration and contains logic for filtering and ordering.
    - A Repository interface is defined in the Domain, implemented in the Infrastucture layer, used in the Application layer and underlying objects are instanciated in the Controller.
    - Criteria is used to apply modifying logic of the collection of registration. At the moment, it only contains logic for filtering.
    - Introduced DTOs in Infrastructure.
    - Controller in Infrastructure folder.
    
- Project:
    - Testing: Use mockery to mock infrastructure objects in domain object unit testing.
    - Testing: Functional testing checks filtering functionalities against a local file (which is a trade-off integration test).
    - Testing: Using Mother design pattern to create objects needed for testing.
    - Docker container is set up to run in development environment (it runs the dev server from the command line)
    - Code identation review and fix made available (needs php installed locally).

- Further possible steps:    
    - Introduce acceptance tests with Behat    
    - Move ordering logic into Criteria.
    - Exception handling: Define app (&domain) specific exceptions
    - Docker setup: Set up proper nginx server to work with Symfony.           
    - Introduce caching strategy to retrieve csv (retrieve header with HEAD request and see if newer version has been published)
    - Fork and see how we can use Tactician to introduce CQRS.