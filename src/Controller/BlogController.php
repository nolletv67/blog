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
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class BlogController extends AbstractController
{
    /**
     * Show all row from article's entity
     *
     * @Route("/", name="blog_index")
     * @return Response A response instance
     */
    public function index() :Response
    {
        $articles = $this->getDoctrine()
            ->getRepository(Article::class)
            ->findAll();

        if (!$articles) {
            throw $this->createNotFoundException('No article found in article\'s table.');
        }

        return $this->render('blog/index.html.twig', ['articles' => $articles]);
    }

    /**
     * @param string $category
     * @Route("/category/{category}", name="blog_show_category")
     * @return Response
     */
    public function showByCategory(string $category) :Response
    {
        $category = $this->getDoctrine()->getRepository(Category::class)->findOneByName($category);
        $articles = $this->getDoctrine()->getRepository(Article::class)->findByCategory(['category' => $category->getId()], ['id'=>'DESC'], 3);

        return $this->render('blog/category.html.twig', ['articles' => $articles, 'category'=>$category]);
    }
}








