<?php

namespace App\Controller;

use App\Entity\Personne;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\PersonneRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PersonneController extends AbstractController
{
    /**
     * @Route("/personne/", name="personne_select", methods={"GET"})
     */
    public function personneSelect(PersonneRepository $repo): Response
    {
        return $this->json($repo->findAll());
    }

    /**
     * @Route("/personne/", name="personne_add", methods={"POST"})
     */
    public function personneAdd(EntityManagerInterface $em, Request $request): Response
    {
        $data = json_decode($request->getContent());
        
        /* Code d'origine
        $personne = new Personne;
        $personne->setNom($data->nom);
        $personne->setPrenom($data->prenom);

        $em->persist($personne);
        $em->flush();
        */

        //factorisation
        $em->persist((new Personne)->setNom($data->nom)->setPrenom($data->prenom));
        $em->flush();

        //Redirection vers la méthode GET pour l'affichage des données dans la bdd
        return $this->redirectToRoute('personne_select');
    }

    /**
     * @Route("/personne/{id}", name="personne_delete", methods={"DELETE"})
     */
    public function personneDelete(Personne $personne, EntityManagerInterface $em): Response
    {
        $em->remove($personne);
        $em->flush();

        return $this->redirectToRoute('personne_select');
    }

    /**
     * @Route("/personne/{id}", name="personne_update", methods={"PUT"})
     */
    public function personneUpdate(Personne $personne, EntityManagerInterface $em, Request $request): Response
    {
        
        $data = json_decode($request->getContent());
        $personne->setNom($data->nom);
        $personne->setPrenom($data->prenom);
        
        //$em->persist($personne);
        $em->flush();

        return $this->redirectToRoute('personne_select');
    }

}