<?php


namespace TestOrg\Infrastructure\Controller;

use App\Infrastructure\UserRegistrationCollectionMarshaller;
use TestOrg\Application\Service\ListUserRegistrations;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use TestOrg\Domain\UserRegistrationCriteria;

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
