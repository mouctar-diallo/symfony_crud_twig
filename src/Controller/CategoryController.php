<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryFormType;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CategoryController extends AbstractController
{
    private $em;
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }
    /**
     * @Route("/category/create", name="category_create")
     */
    public function index(Request $request)
    {
        $category = new Category();
        $form = $this->createForm(CategoryFormType::class,$category);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $category = $form->getData();
            $this->em->persist($category);
            $this->em->flush();

            return $this->redirectToRoute('category_all');
        }
        return $this->render('category/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/category/all",name="category_all")
     */

     public function all(CategoryRepository $repo)
     {
         $categories = $repo->findAll();

         return $this->render('category/list.html.twig',[
             'categories' => $categories
         ]);
     }
}
