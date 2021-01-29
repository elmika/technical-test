<?php


namespace App\Domain;

/**
 * It seems that you are using Criteria pattern with repo, but looking at the implementation you are not. I guess that
 * the use case and the stack are not suitable for that kind of implementation. I think you will find best benefits of
 * the Criteria pattern when you use it along with repositories, instead of collections.
 *
 * You will have some object that converts your Criteria to DoctrinCriteria (for example), and that is can be easily
 * applied, because doctrine itself uses the same patterns to query the database. The only difference is that Doctrine
 * criteria are 100% different from yours.
 *
 * It helps managing queries creating a powerful abstraction for that.
 */
interface ListUserRegistrationRepository
{
    public function query(UserRegistrationCriteria $criteria): UserRegistrationCollection;
}
