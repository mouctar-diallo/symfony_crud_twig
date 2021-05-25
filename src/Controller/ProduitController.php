<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Form\ProduitFormType;
use App\Repository\ProduitRepository;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProduitController extends AbstractController
{
    private $em;
    private $categoryRepository;
    public function __construct(EntityManagerInterface $em, CategoryRepository $categoryRepository)
    {
        $this->em = $em;
        $this->categoryRepository = $categoryRepository;
    }
    /**
     * @Route("/produit/create", name="product_create")
     */
    public function index(Request $request)
    {
        $produit = new Produit();
        $form = $this->createForm(ProduitFormType::class,$produit);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $produit = $form->getData();

            $this->em->persist($produit);
            $this->em->flush();
            return $this->redirectToRoute("product_all");
        }
        return $this->render('produit/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/produit/all",name="product_all")
     */
    public function all(ProduitRepository $repo)
    {
        $products = $repo->findAll();

        return $this->render('produit/list.html.twig',[
            'products' => $products,
        ]);
    }


     /**
     * @Route("/produit/edit/{id}", name="product_edit")
     */
    public function edit(ProduitRepository $repo,$id,Request $request)
    {
        $product = $repo->find($id);
        $form = $this->createForm(ProduitFormType::class,$product);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $product = $form->getData();

            $this->em->flush();

            return $this->redirectToRoute("product_all");
        }

        return $this->render('produit/edit.html.twig',[
            'form' => $form->createView(), 
        ]);
    }

     /**
     * @Route("/produit/delete/{id}", name="product_delete")
     */
    public function delete(ProduitRepository $repo,$id)
    {
        $product = $repo->find($id);
        if ($product) {
            $this->em->remove($product);
            $this->em->flush();
            return $this->redirectToRoute('product_all');
        }
    }



}
