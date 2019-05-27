<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Category;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class BlogController
 * @package App\Controller
 * @Route("/blog", name="blog_")
 */
class BlogController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index()
    {
        $articles = $this->getDoctrine()->getRepository(Article::class)->findAll();

        if (!$articles) {
            throw $this->createNotFoundException(
                'No article found in article\'s table.'
            );
        }
        foreach ($articles as $article) {
            $article->url = preg_replace('/ /', '-', strtolower($article->getTitle()));
        }

        return $this->render('blog/add.html.twig', ['articles' => $articles]);
    }


    /**
     * Getting a article with a formatted slug for title
     *
     * @param string $slug The slugger
     *
     * @Route("/{slug<^[a-z0-9-]+$>}",
     *     defaults={"slug" = null},
     *     name="show")
     *  @return Response A response instance
     */
    public function show(?string $slug) : Response
    {
        if (!$slug) {
            throw $this
                ->createNotFoundException('No slug has been sent to find an article in article\'s table.');
        }

        $slug = preg_replace(
            '/-/',
            ' ', ucwords(trim(strip_tags($slug)), "-")
        );

        $article = $this->getDoctrine()
            ->getRepository(Article::class)
            ->findOneBy(['title' => mb_strtolower($slug)]);

        if (!$article) {
            throw $this->createNotFoundException(
                'No article with '.$slug.' title, found in article\'s table.'
            );
        }

        $category = $article->getCategory();



        return $this->render(
            'blog/show.html.twig',
            [
                'article' => $article,
                'slug' => $slug,
                'category' => $category,
            ]
        );
    }

    /**
     * @param Category $category
     * @Route("/category/{name}", name="show_category")
     * @return Response
     */
    public function showByCategory(Category $category) : Response
    {
        if (!$category) {
            throw $this
                ->createNotFoundException('No name has been sent to find an category in category\'s table.');
        }
//
//        $category = $this->getDoctrine()
//            ->getRepository(Category::class)
//            ->findOneBy(['name' => mb_strtolower($categoryName)]);
//
//        if (!$category) {
//            throw $this->createNotFoundException(
//                'No category with ' . $categoryName . ' name, found in category\'s table.'
//            );
//        }
//
//        $articles = $this->getDoctrine()
//            ->getRepository(Article::class)
//            ->findBy(['category' => $category], ['id' => 'DESC'], 3);
//
//        if (!$articles) {
//            throw $this->createNotFoundException(
//                'No article with '.$categoryName.' name found'
//            );
//        }

        $articles = $category->getArticles();

        foreach ($articles as $article) {
            $article->url = preg_replace('/ /', '-', strtolower($article->getTitle()));
        }

        return $this->render('blog/category.html.twig', [
            'articles' => $articles,
            'category' => $category
        ]);

    }
}
