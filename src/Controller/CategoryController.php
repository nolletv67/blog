<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Category;
use App\Form\CategoryType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CategoryController extends AbstractController
{
    /**
     */
    public function index()
    {
        return $this->render('category/index.html.twig', [
            'controller_name' => 'CategoryController',
        ]);
    }

    /**
     * @param Request $request
     * @route("/category", name="category_add")
     * @return Response
     */
    public function add(Request $request) :Response
    {
        $category = new Category();
        $addCategory = $this->createForm(CategoryType::class, $category);
        $addCategory->handleRequest($request);

        if ($addCategory->isSubmitted() && $addCategory->isValid()){
            $categoryEntity = $this->getDoctrine()->getManager();
            $categoryEntity->persist($category);
            $categoryEntity->flush();
            return $this->redirectToRoute('category_add');
        }

        return $this->render('category/add.html.twig', ['add'=>$addCategory->createView()]);
    }

    /**
     * @param string $category
     * @route("/category", name="blog_show_category")
     * @return Response A response instance
     */
    public function showByCategory(string $category) :Response
    {
        $category = preg_replace('/-/', ' ', ucwords(trim(strip_tags($category)), "-"));
        $category = $this->getDoctrine()->getRepository(Category::class)->findOneByName($category);
        $articles = $this->getDoctrine()->getRepository(Article::class)->findByCategory($category, ['id'=>'DESC'], 3);
        if (!$articles) {
            throw $this->createNotFoundException('No articles in '.$category.' category.');
        }
        return $this->render('blog/category.html.twig', ['articles' => $articles, 'category'=>$category]);
    }

    /**
     * @route("/category/{id}", name="category_detail")
     */
    public function show(Category $category) :Response
    {
        return $this->render('category/category.html.twig', ['category' => $category]);
    }

}


