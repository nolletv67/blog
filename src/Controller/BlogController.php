<?php
/**
 * Created by PhpStorm.
 * User: nollet
 * Date: 11/11/18
 * Time: 12:01
 */

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Category;
use App\Form\ArticleSearchType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BlogController extends AbstractController
{
    /**
     * @param Request $request
     * @route("/form/articles", name="blog_search")
     * @return Response A response instance
     */
    public function index(Request $request): Response
    {

        $articles = $this->getDoctrine()->getRepository(Article::class)->findAll();
        if (!$articles) {
            throw $this->createNotFoundException('No article found in article\'s table.');
        }

        $form->handleRequest($request);

        $form = $this->createForm(ArticleSearchType::class, null, ['method' => Request::METHOD_GET]);

        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);

        if ($form->isSubmitted()) {
            $data = $form->getData();
        }

        return $this->render('form/search.html.twig', ['articles' => $articles, 'form' => $form->createView()]);

    }
}