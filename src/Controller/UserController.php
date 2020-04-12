<?php


namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

class UserController
{
    /**
     * @Route("/users", methods={"GET"}, )
     */
    public function listUsers()
    {
        // read csv file - UserCsvService (Application Service)?
        $usersArray = array_map('str_getcsv', file("https://wallbox.s3-eu-west-1.amazonaws.com/img/test/users.csv"));
        $headers = ["id", "name", "surname", "email", "country", "createdAt", "activatedAt", "chargerID"];
        array_walk($usersArray, function(&$a) use ($headers, $usersArray) {
            $a = array_combine($headers, $a);
        });

        // order by client name and surname

        // filtered

        // respond as json
        return new JsonResponse(["items" => $usersArray]);
    }
}