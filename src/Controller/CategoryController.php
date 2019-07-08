<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    /**
     * @param Request $request
     * @Route("/category", name="category_add")
     * @IsGranted("ROLE_ADMIN")
     * @return Response
     */
    public function add(Request $request) : Response
    {
        $form = $this->createForm(CategoryType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $category = $form->getData();

            $manager = $this->getDoctrine()->getManager();

            $manager->persist($category);

            $manager->flush();

            $this->addFlash('success', 'Category added !');
        }

        return $this->render('category/add.html.twig', [
            'form' => $form->createView(),
        ]);

    }
}
