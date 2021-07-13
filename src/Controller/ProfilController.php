<?php

namespace App\Controller;

use App\Entity\AdresseLivraison;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\AdresseLivraisonRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class ProfilController extends AbstractController
{
    /**
     * @Route("/profil", name="profil")
     */
    public function index(): Response
    {
        return $this->render('profil/index.html.twig', [
            'controller_name' => 'ProfilController',
        ]);
    }
    
    /**
     * @Route("/profil/info", name="info")
     */
    public function info() {
        return $this->render('profil/info.html.twig');
    }

    /**
     * @Route("/livraison", name="livraison")
     */

    public function livraison(AdresseLivraisonRepository $adresseLivraisonRepository): Response{
        return $this->render('profil/livraison.html.twig', [
            'controller_name' => 'ProfilController',
            'AdresseLivraison' => $adresseLivraisonRepository->findAll(),
        ]);
    }

     /**
     * @Route("/livraison/new", name="livraison_create")
     * @Route("/livraison/{id}/edit", name="livraison_edit")
     */
    public function form(AdresseLivraison $adresselivraison = null, Request $request, EntityManagerInterface $manager){

        if(!$adresselivraison){
            $adresselivraison = new AdresseLivraison();
        }
        //$adresselivraison = new AdresseLivraison();

        $form = $this->createFormBuilder($adresselivraison)
                     ->add('nom')
                     ->add('prenom')
                     ->add('adresse')
                     ->add('cp')
                     ->add('ville')
                     ->add('telephone')
                     ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() AND $form->isValid()){
            
            $manager->persist($adresselivraison);
            $manager->flush();

            return $this->redirectToRoute('livraison', ['id' => $adresselivraison->getId()]);
            
        }

        return $this->render('profil/livraisoncreate.html.twig', [
            'AdresseLivraisonType' => $form->createView(),
            'editMode' => $adresselivraison->getId() !== null
        ]);
    }

    /**
     * @Route("/profil/facturation", name="facturation")
     */
    public function facturation() {
        return $this->render('profil/facturation.html.twig');
    }

    /**
     * @Route("/profil/historique", name="historique")
     */
    public function historique() {
        return $this->render('profil/historique.html.twig');
    }

    /**
     * @Route("/profil/cgv", name="cgv")
     */
    public function cgv() {
        return $this->render('profil/cgv.html.twig');
    }

    /**
     * @Route("/profil/newsletter", name="newsletter")
     */
    public function newsletter() {
        return $this->render('profil/newsletter.html.twig');
    }
    
}