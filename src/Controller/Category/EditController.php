<?php

namespace App\Controller\Category;

use App\Form\Type\CategoryType;
use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class EditController extends AbstractController
{
    #[Route('/admin/category/edit/{id}', name: 'category_edit')]
    public function edit($id, CategoryRepository $categoryRepository, Request $request, SluggerInterface $slugger): Response
    {
        $category = $categoryRepository->find($id);
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() and $form->isValid()) {
            $category->setSlug(strtolower($slugger->slug($category->getName())));
            $categoryRepository->save($category, true);

            return $this->redirectToRoute('homepage');
        }

        return $this->render('category/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
