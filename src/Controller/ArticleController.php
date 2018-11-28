<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{
    /**
     * @Route("/articles", name="articles")
     * @param CategoryRepository $categoryRepository
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(CategoryRepository $categoryRepository)
    {
        $categories = $categoryRepository->findAll();
        foreach ($categories as $key => $category) {
            $categories[$key] = $category->getArticles();
        }
        return $this->render('article/index.html.twig', ['categories' => $categories]);
    }

    /**
     * @param Request $request
     * @return Response
     * @Route("/article/new", name="article_new")
     */
    public function add(Request $request) :Response
    {
        $article = new Article();
        $addArticle = $this->createForm(ArticleType::class, $article);
        $addArticle->handleRequest($request);

        if ($addArticle->isSubmitted() && $addArticle->isValid()) {
            $articleEntity = $this->getDoctrine()->getManager();
            $articleEntity->persist($article);
            $articleEntity->flush();

            return $this->redirectToRoute('blog_list');
        }
        return $this->render('article/add.html.twig', ['add'=>$addArticle->createView()]);
    }
}