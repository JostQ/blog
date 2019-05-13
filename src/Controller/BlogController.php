<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class BlogController
 * @package App\Controller
 */
class BlogController extends AbstractController
{
    /**
     * @Route("/blog/show/{slug}",
     *     requirements={"slug"="[a-z0-9-]"},
     *     defaults={"slug"="Article Sans Titre"},
     *     name="blog_show")
     */
    public function show(string $slug)
    {
        $result = ucwords(str_replace('-', ' ', $slug));
        return $this->render('blog/show.html.twig', ['slug' => $result]);
    }
}
