<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WelcomeController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(ArticleRepository $repo): Response
    {
        $articles = $repo->findAll();
        
        return $this->render('article/list.html.twig',[
            'articles' => $articles
        ]);
    }
}
