<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleFormType;
use App\Repository\ArticleRepository;
use Doctrine\DBAL\Types\TextType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ArticleController extends AbstractController
{
    private $repo;
    private $em;
    public function __construct(EntityManagerInterface $em, ArticleRepository $repo)
    {
        $this->em = $em;
        $this->repo = $repo;
    }
    /**
     * @Route("/article/create", name="new_article")
     */
    public function index(Request $request): Response
    {
        $articles = new Article();

        $form = $this->createForm(ArticleFormType::class,$articles);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $article = $form->getData();
            $this->em->persist($article);
            $this->em->flush();
            
            return $this->redirectToRoute("article_all",[],Response::HTTP_SEE_OTHER);
        }
        
        if ($form->isSubmitted() && !$form->isValid()) {
            $response = new Response();
            $response->setStatusCode(Response::HTTP_UNPROCESSABLE_ENTITY);

            return $this->render('article/index.html.twig', [
                'form' => $form->createView()
            ],$response);
        }

        return $this->render('article/index.html.twig', [
            'form' => $form->createView()
        ]);
    }


    /**
     * @Route("/article/all", name="article_all")
     */
     public function all()
     {
         $articles = $this->repo->findAll();
          return $this->render('article/list.html.twig',[
              'articles' => $articles
          ]);
     }

    /**
     * @Route("/article/delete/{id}",name="delete_article")
    */
    public function delete($id)
    {
    $article = $this->repo->find($id);
    if ($article) {
        $this->em->remove($article);
        $this->em->flush();
    }
    return $this->redirectToRoute("article_all");
    }

    /**
     * @Route("/article/edit/{id}", name="article_edit")
     */
    public function edit($id, Request $request)
    {
        $article = $this->repo->find($id);
        $form_edit = $this->createForm(ArticleFormType::class, $article);
        $form_edit->handleRequest($request);
        if ($form_edit->isSubmitted() && $form_edit->isValid()) {
            $article = $form_edit->getData();

            $this->em->flush();
            return $this->redirectToRoute("article_all",[], Response::HTTP_SEE_OTHER);
        }

        if ($form_edit->isSubmitted() && !$form_edit->isValid()){
            $response = new Response();
            $response->setStatusCode(Response::HTTP_UNPROCESSABLE_ENTITY);
            return $this->render("article/edit.html.twig",[
                'form_edit' => $form_edit->createView()
            ],$response);
        }

        return $this->render("article/edit.html.twig",[
            'form_edit' => $form_edit->createView()
        ]);
    }
}
