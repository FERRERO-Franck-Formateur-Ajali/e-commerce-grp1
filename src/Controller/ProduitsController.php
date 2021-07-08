<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Repository\ProduitRepository;
use Symfony\Component\HttpFoundation\Request;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
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
    public function show(ProduitRepository $repo, $id){

        $produit = $repo->find($id);

        return $this->render('produits/show.html.twig', [
            'produit' => $produit
        ]);
    }

}

