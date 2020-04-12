<?php


namespace App\Controller;

use App\Application\ListUsersService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

class UserController
{
    /**
     * @Route("/users", methods={"GET"}, )
     */
    public function listUsers(Request $request)
    {
        // read csv file
        $csvLocation = "https://wallbox.s3-eu-west-1.amazonaws.com/img/test/users.csv";
        $userList = new ListUsersService($csvLocation);
        // apply filters
        $filters = $request->query->all();
        $userList->applyFilters($filters);

        // respond as json
        return new JsonResponse(["items" => $userList->asArray()]);
    }
}