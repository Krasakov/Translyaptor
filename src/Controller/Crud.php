<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class Crud
{
    /**
     * @Route(path="text/create", methods={"GET","POST"}, name="create")
     * @param Request $request
     */
    public function create(Request $request)
    {

    }
}