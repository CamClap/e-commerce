<?php

namespace App\Class;

use App\Entity\Produit;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class Panier
{
    private $requestStack;
    private $entityManager;
    public function __construct(RequestStack $requestStack, EntityManagerInterface $entityManager)
    {
        $this->requestStack = $requestStack;
        $this->entityManager = $entityManager;
    }
    public function showAll()
    {
        $completePanier = [];
        if ($this->get()) {
            foreach ($this->get() as $id => $quantity) {
                $produit = $this->entityManager->getRepository(Produit::class)->find($id);
                if (!$produit) {
                    $this->deleteProduct($id);
                    continue;
                }
                $completePanier[] =
                    [
                        'produit' => $produit,
                        'quantite' => $quantity
                    ];
            }
        }
        return $completePanier;
    }
    public function addProduct($id)
    {
        $panier = $this->getPanier();
        if (!empty($panier[$id])) {
            $panier[$id]++;
        } else {
            $panier[$id] = 1;
        }
        $this->setPanier($panier);
    }
    public function deleteProduct($id)
    {
        $panier = $this->getPanier();
        unset($panier[$id]);
        $this->setPanier($panier);
    }
    public function removeCart()
    {
        $session = $this->requestStack->getCurrentRequest()->getSession();
        return $session->remove('panier');
    }
    public function decreaseProduct($id)
    {
        $panier = $this->getPanier();
        if ($panier[$id] > 1) {
            $panier[$id]--;
        } else {
            unset($panier[$id]);
        }
        $this->setPanier($panier);
    }
    public function get()
    {
        return $this->getPanier();
    }
    public function getPanier()
    {
        $session = $this->requestStack->getCurrentRequest()->getSession();
        return $session->get('panier', []);
    }
    public function setPanier(array $panier)
    {
        $session = $this->requestStack->getCurrentRequest()->getSession();
        $session->set('panier', $panier);
    }
}
