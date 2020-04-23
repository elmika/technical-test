<?php


namespace App\Controller;

use App\Application\ListUserRegistrationsService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserRegistrationController extends AbstractController
{
    /**
     * @Route("/users", methods={"GET"}, )
     */
    public function listUsers(Request $request, ListUserRegistrationsService $userRegistrationsList)
    {
        $filters = $request->query->all();
        $collection = $userRegistrationsList->query($filters);

        // respond as json
        return new JsonResponse(["items" => $collection->asArray()]);
    }
}
