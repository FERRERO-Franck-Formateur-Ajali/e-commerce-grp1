<?php

namespace App\Controller;

date_default_timezone_set('Europe/Paris');

use App\Entity\Comment;
use App\Entity\Produit;
use App\Form\CommentType;
use App\Repository\ProduitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProduitsController extends AbstractController
{

    /**
     * @Route("/produits", name="produits")
     */
    public function index(Request $request, PaginatorInterface $paginator): Response
    {
        
        $donnees = $this->getDoctrine()->getRepository(Produit::class)->findAll();   

        $produits = $paginator->paginate(
            $donnees,
            $request->query->getInt('page', 1),
            9
        );
        
        return $this->render('produits/index.html.twig', [
            'controller_name' => 'ProduitsController',
            'produits' => $produits
        ]);
    }

    /**
     * @Route("/produits/{id}", name="produits_show")
     */
    public function show(ProduitRepository $repo, $id,Produit $produit, Request $request, EntityManagerInterface $manager){
        $comment = new Comment();

        $form = $this->createForm(CommentType::class, $comment);

        $form->handleRequest($request);

        if ($form->isSubmitted() AND $form->isValid()){ 
            $comment->setCreatedAt(new \DateTime())
                    ->setProduit($produit);

            $manager->persist($comment);
            $manager->flush(); 

            return $this->redirectToRoute('produits_show',['id' => $produit->getId()]);
        }

        $produit = $repo->find($id);

        return $this->render('produits/show.html.twig', [
            'produit' => $produit,
            'CommentForm' => $form->createView()
        ]);
    }

}

