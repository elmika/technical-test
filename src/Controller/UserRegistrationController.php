<?php


namespace App\Controller;

use App\Application\ListUserRegistrationsService;
use App\Application\ListUserRegistrationsServiceRefactored;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserRegistrationController extends AbstractController
{
    /**
     * @Route("/users", methods={"GET"}, )
     */
    public function listUsers(Request $request)
    {
        // read csv file
        $csvLocation = $this->getParameter('app.user_list_csv_location');
        $userList = new ListUserRegistrationsService($csvLocation);
        // apply filters
        $filters = $request->query->all();
        $userList->query($filters);

        // respond as json
        return new JsonResponse(["items" => $userList->asArray()]);
    }
}
