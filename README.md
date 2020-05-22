# Environment setup

### Run Docker container

In prod (Disclaimer: server is not configured for prod yet)
````
docker build -t "registration-exercise" .

docker run --rm -p 8000:80 --name=simple_person "registration-exercise"
```` 

In dev
````
docker-compose rebuild
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
    - UserRegistration is the root Agregate. 
    - We proposed a logic of dealing with non registered users and possible posterior registration.
    - UserRegistrationCollection is a list of UserRegistration and contains logic for filtering and ordering.
    - A Repository interface is defined in the Domain, implemented in the Infrastucture layer, used in the Application layer and instanciated in the Controller.
    - Criteria is used to apply modifying logic of the collection of registration. At the moment, it only contains logic for filtering.
    - Introduced DTOs in Infrastructure.

- Project:
    - Testing: Use mockery to mock infrastructure objects in domain object unit testing.
    - Testing: Functional testing checks filtering functionalities against a local file (which is a trade-off integration test).
    - Testing: Using Mother design pattern to create objects needed for testing.
    - Docker container is set up to run in development environment (it runs the dev server from the command line)
    - Code identation review and fix made available (needs php installed locally).

- Further possible steps:
    - Value objects could be introduced as attributes, especially for emails and country codes.
    - Introduce caching strategy to retrieve csv (retrieve header with HEAD request and see if newer version has been published)
    - Move ordering logic into Criteria.
    - Define app (&domain) specific exceptions, introduce corresponding exception handling
    - Set up proper nginx server in the Docker container. Configure to run with symfony.           
    - Introduce acceptance tests with Behat
    - Move controllers in Infrastructure folder