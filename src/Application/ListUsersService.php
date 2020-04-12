<?php


namespace App\Application;


class ListUsersService
{
    private $list;

    /**
     * ListUsersService constructor.
     * @param string $sourceFile location of csv file that we parse
     */
    public function __construct(string $sourceFile)
    {
        $this->read($sourceFile);
        $this->sortListByNameAndSurname();
    }

    /**
     * @param string $sourceFile
     */
    private function read(string $sourceFile)
    {
        $usersArray = array_map('str_getcsv', file($sourceFile));
        $headers = ["id", "name", "surname", "email", "country", "createdAt", "activatedAt", "chargerID"];
        array_walk($usersArray, function(&$a) use ($headers, $usersArray) {
            $a = array_combine($headers, $a);
        });

        $this->list = $usersArray;
    }

    /**
     * Order list by client name and surname
     */
    private function sortListByNameAndSurname(): void
    {
        usort($this->list, function(&$a, &$b){
            if($a["surname"] == $b["surname"]) {
                return strcmp($a["name"], $b["name"]);
            }

            return strcmp($a["surname"], $b["surname"]);
        });
    }

    public function applyFilters($filters)
    {

    }

    public function asArray()
    {
        return $this->list;
    }



}