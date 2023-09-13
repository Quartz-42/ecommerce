<?php

namespace App\Controller\Product;

use App\Form\Type\ProductType;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class EditController extends AbstractController
{
    #[Route('admin/product/edit/{id}', name: 'product_edit')]
    public function edit($id, ProductRepository $productRepository, Request $request, SluggerInterface $slugger)
    {
        $product = $productRepository->find($id);
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() and $form->isValid()) {
            //Gestion des images pour la prod
            // $uploadedFile = $form['mainPicture']->getData();
            // $destination = $this->getParameter('kernel.project_dir') . '/public/uploads/products_image';
            // $originalFilename = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
            // $newFilename = $slugger->slug($originalFilename) . '-' . uniqid() . '.' . $uploadedFile->guessExtension();
            // $uploadedFile->move(
            //     $destination,
            //     $newFilename
            // );
            // $product->setMainPicture($newFilename);

            $product->setSlug(strtolower($slugger->slug($product->getName())));
            $productRepository->save($product, true);

            return $this->redirectToRoute('homepage');
        }

        return $this->render('product/edit.html.twig', [
            'form' => $form->createView(),
            'product' => $product,
        ]);
    }
}
