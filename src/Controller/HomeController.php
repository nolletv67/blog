<?php
/**
 * Created by PhpStorm.
 * User: nollet
 * Date: 06/11/18
 * Time: 16:24
 */
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    /**
     * @Route("/home")
     */
    public function index()
    {
        return $this->render("home.html.twig");
    }
}
