<?php

namespace App\Controller;

use App\Class\Panier;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PanierController extends AbstractController
{
    public function __construct(private RequestStack $requestStack, private EntityManagerInterface $entityManager)
    {
        
    }
    #[Route('/panier', name: 'app_panier')]
    public function index(Panier $panier): Response
    {
        return $this->render('panier/index.html.twig', [
            'controller_name' => 'PanierController',
            'panier' => $panier->showAll(),
        ]);
    }

    #[Route('/panier/add/{id}', name: 'app_add_panier')]
    public function addProduct(Panier $panier, $id): Response
    {
        $panier->addProduct($id);
        return $this->redirectToRoute('app_panier');
        // return $this->redirectToRoute('app_produit_index');
    }
    #[Route('/panier/delete/{id}', name: 'app_decrease_panier')]
    public function decreaseProduct(Panier $panier, $id): Response
    {
        $panier->decreaseProduct($id);
        return $this->redirectToRoute('app_panier');
    }
    #[Route('/panier/deleteProduct/{id}', name: 'app_delete_product')]
    public function deleteProduct(Panier $panier, $id): Response
    {
        $panier->deleteProduct($id);
        return $this->redirectToRoute('app_panier');
    }
    #[Route('/panier/deletePanier}', name: 'app_delete_panier')]
    public function removeCart(Panier $panier): Response
    {
        $panier->removeCart();
        return $this->redirectToRoute('app_panier');
    }
   
}
