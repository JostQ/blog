<?php

namespace App\Controller;

use App\Entity\Tag;
use App\Form\TagType;
use App\Repository\TagRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/tag", name="tag_")
 */
class TagController extends AbstractController
{
    /**
     * @Route("/", name="index", methods={"GET"})
     */
    public function index(TagRepository $tagRepository) : Response
    {
        return $this->render('tag/index.html.twig', [
            'tags' => $tagRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="new", methods={"GET", "POST"})
     */
    public function new(Request $request) : Response
    {
        $form = $this->createForm(TagType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $tag = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($tag);
            $em->flush();
            return $this->redirectToRoute('tag_show', ['name' => $tag->getName()]);
        }

        return $this->render('tag/new.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/{name}", name="show", methods={"GET"})
     */
    public function show(Tag $tag) : Response
    {
        return $this->render('tag/show.html.twig', [
            'tag' => $tag
        ]);
    }

    /**
     * @Route("/{name}", name="delete", methods={"DELETE"})
     */
    public function delete(Request $request, Tag $tag) : Response
    {
        if ($this->isCsrfTokenValid('delete'.$tag->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($tag);
            $entityManager->flush();
        }

        return $this->redirectToRoute('tag_index');
    }

}
