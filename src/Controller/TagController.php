<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Tag;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


class TagController extends AbstractController
{
    /**
     * @param $name
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/tag/{name}", name="tag_show_article")
     *
     */

    public function showByTag($name)
    {
        $name = preg_replace('/-/', '', ucwords(trim(strip_tags($name), "-")));

        $tagArticles = $this->getDoctrine()->getRepository(Tag::class)->findOneByName($name)->getArticles();

        return $this->render('tag/index.html.twig', ['tagArticles' => $tagArticles]);
    }
}
