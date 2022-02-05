<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Form\Produit1Type;
use App\Repository\ProduitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/catalog')]
class CatalogController extends AbstractController
{
    #[Route('/', name: 'catalog_index', methods: ['GET'])]
    public function index(ProduitRepository $produitRepository): Response
    {
        return $this->render('catalog/index.html.twig', [
            'produits' => $produitRepository->findAll(),
        ]);
    }

   
    #[Route('/{id}', name: 'catalog_show', methods: ['GET'])]
    public function show(Produit $produit): Response
    {
        return $this->render('catalog/show.html.twig', [
            'produit' => $produit,
        ]);
    }

}
