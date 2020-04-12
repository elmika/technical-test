<?php


namespace App\Application;


class ListUsersService
{
    const HEADERS = ["id", "name", "surname", "email", "country", "createdAt", "activatedAt", "chargerID"];
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

        $headers = self::HEADERS;
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
        if(array_key_exists('countries', $filters)){
            $this->applyCountriesFilter($filters['countries']);
        }

        if(array_key_exists('activation_length', $filters)){
            $this->applyActivationLengthFilter($filters['activation_length']);
        }
    }

    private function applyCountriesFilter($filter)
    {
        $countriesFilter = explode(",", $filter);
        foreach($this->list as $key=>$element)
        {
            if(! in_array($element['country'], $countriesFilter))
            {
                unset($this->list[$key]);
            }
        }
        $this->list = array_values($this->list);
    }

    private function applyActivationLengthFilter($maxDays)
    {
        foreach($this->list as $key=>$element)
        {
            $dateFrom = new \DateTimeImmutable($element['activatedAt']);
            $dateTo = new \DateTimeImmutable($element['createdAt']);

            $diffDays = $dateTo->diff($dateFrom)->format('%a');
            if((int)$diffDays < $maxDays)
            {
                unset($this->list[$key]);
            }
        }
        $this->list = array_values($this->list);
    }

    public function asArray()
    {
        return $this->list;
    }



}