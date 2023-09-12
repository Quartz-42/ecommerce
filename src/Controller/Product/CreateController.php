<?php

namespace App\Controller\Product;

use App\Entity\Product;
use App\Form\Type\ProductType;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CreateController extends AbstractController
{

    #[Route('/admin/product/create', name: 'product_create')]
    public function new(ProductRepository $productRepository, SluggerInterface $slugger, Request $request): Response
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //Gestion des images
            $uploadedFile = $form['mainPicture']->getData();
            $destination = $this->getParameter('kernel.project_dir') . '/public/uploads/products_image';
            $originalFilename = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
            $newFilename = $slugger->slug($originalFilename) . '-' . uniqid() . '.' . $uploadedFile->guessExtension();
            $uploadedFile->move(
                $destination,
                $newFilename
            );

            $product->setMainPicture($newFilename);
            $product->setSlug(strtolower($slugger->slug($product->getName())));
            $productRepository->save($product, true);

            return $this->redirectToRoute('homepage');
        }

        return $this->render('product/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
