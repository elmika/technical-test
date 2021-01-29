<?php


namespace App\Infrastructure\Controller;

use App\Infrastructure\UserRegistrationCollectionMarshaller;
use App\Application\Service\ListUserRegistrations;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Domain\UserRegistrationCriteria;

/**
 * In entry points, like this controller, or CLI, I use to do only the following:
 * 1. retrieve the request plain data
 * 2. apply an optional first validation (just for UX reasons -> send feedback with all params errors at a time)
 * 3. encapsulate plain data in a DTO and pass it to the application layer
 * 4. return result if needed
 *
 * Application layer will be responsible of translate plain data received with a DTO, into domain objects.
 *
 * In this case, this will imply to not instantiate the *Criteria, instead create a ListUserRegistrationsQuery (my DTO)
 * with some plain data, and then invoke $userRegistrationsList->query($userRegistrationsListQuery);
 *
 * Then, ListUserRegistrations will instantiate the *Criteria as needed and orchestrate any application or domain
 * service it might need.
 *
 * I like giving the controller the responsibility of formatting the response for the client, similarly as you do.
 *
 * Nice reading (and awesome graphics) about DDD, CQRS, hexagonal and so on:
 * https://herbertograca.com/2017/11/16/explicit-architecture-01-ddd-hexagonal-onion-clean-cqrs-how-i-put-it-all-together/
 */
class UserRegistrationController extends AbstractController
{
    /**
     * @Route("/users", methods={"GET"}, )
     */
    public function listUsers(Request $request, ListUserRegistrations $userRegistrationsList)
    {
        $filters = new UserRegistrationCriteria($request->query->all());
        $collection = $userRegistrationsList->query($filters);

        // respond as json
        return new JsonResponse(
            UserRegistrationCollectionMarshaller::toArray($collection)
        );
    }
}
