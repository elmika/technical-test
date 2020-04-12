<?php


namespace App\Controller;

use App\Application\ListUsersService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserController extends AbstractController
{
    /**
     * @Route("/users", methods={"GET"}, )
     */
    public function listUsers(Request $request)
    {
        // read csv file
        $csvLocation = $this->getParameter('app.user_list_csv_location');
        $userList = new ListUsersService($csvLocation);
        // apply filters
        $filters = $request->query->all();
        $userList->applyFilters($filters);

        // respond as json
        return new JsonResponse(["items" => $userList->asArray()]);
    }
}