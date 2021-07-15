<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ClientType;
use App\Entity\AdresseLivraison;
use App\Entity\AdresseFacturation;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\AdresseLivraisonRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\AdresseFacturationRepository;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

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
     * @Route("/info", name="info")
     */
    public function linfo(UserRepository $userRepository): Response{
        return $this->render('profil/info.html.twig', [
            'controller_name' => 'ProfilController',
            'User' => $userRepository->findAll(),
        ]);
    }

    /**
     *  @Route("/info/new", name="info_create")
     * @Route("/info/{id}/edit", name="info_edit")
     */
    public function infoedit(User $user = null, Request $request, EntityManagerInterface $manager, UserPasswordEncoderInterface $passwordEncoder){

        if(!$user){
            $user = new User();
        }

        $form = $this->createFormBuilder($user)
                     ->add('email')
                     ->add('newpassword', PasswordType::class, [
                         'label' => 'Nouveau mot de passe', 
                         'attr' => [
                            'placeholder' => 'Laisse vide poour pas modifier',
                        ]                   
                      ])
                     ->add('client',ClientType::class)
                     ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() AND $form->isValid()){
            if ($user->getNewPassword() !== null) {
                $user->setPassword(
                    $passwordEncoder->encodePassword(
                        $user,
                        $user->getNewPassword()
                    )
                );
            }
            $manager->persist($user);
            $manager->flush();

            return $this->redirectToRoute('info', ['id' => $user->getId()]);
            
        }

        return $this->render('profil/infoedit.html.twig', [
            'RegistrationFormType' => $form->createView(),
            'editMode' => $user->getId() !== null
        ]);
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
    public function formLivraison(AdresseLivraison $adresselivraison = null, Request $request, EntityManagerInterface $manager){

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
     * @Route("/facturation", name="facturation")
     */
    public function facturation(AdresseFacturationRepository $adresseFacturationRepository): Response{
        return $this->render('profil/facturation.html.twig', [
            'controller_name' => 'ProfilController',
            'AdresseFacturation' => $adresseFacturationRepository->findAll(),
        ]);
    }

    /**
     * @Route("/facturation/new", name="facturation_create")
     * @Route("/facturation/{id}/edit", name="facturation_edit")
     */
    public function formFacturation(AdresseFacturation $adressefacturation = null, Request $request, EntityManagerInterface $manager){

        if(!$adressefacturation){
            $adressefacturation= new AdresseFacturation();
        }
        //$adressefacturation = new AdresseFacturation();

        $form = $this->createFormBuilder($adressefacturation)
                     ->add('nom')
                     ->add('prenom')
                     ->add('adresse')
                     ->add('cp')
                     ->add('ville')
                     ->add('telephone')
                     ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() AND $form->isValid()){
            
            $adressefacturation->setClient($this->getUser()->getClient());
            $manager->persist($adressefacturation);
            $manager->flush();

            return $this->redirectToRoute('facturation', ['id' => $adressefacturation->getId()]);
            
        }

        return $this->render('profil/facturationcreate.html.twig', [
            'AdresseFacturationType' => $form->createView(),
            'editMode' => $adressefacturation->getId() !== null
        ]);
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

    
    /**
     * @Route("/profil/delete/adresse/facturation/{id}", name="adresse_facturation_delete", methods={"POST"})
     */
    public function delete(Request $request, AdresseFacturation $adressefacturation): Response
    {
        if ($this->isCsrfTokenValid('delete'.$adressefacturation->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($adressefacturation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('facturation');
    }
    
}
