<?php

namespace App\Controller\Category;

use App\Entity\Category;
use App\Form\Type\CategoryType;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class EditController extends AbstractController
{
    #[Route('/admin/category/edit/{id}', name: 'category_edit')]
    public function edit(Category $category, Request $request, SluggerInterface $slugger, CategoryRepository $categoryRepository): Response
    {
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() and $form->isValid()) {
            /* @phpstan-ignore-next-line */
            $category->setSlug(strtolower($slugger->slug($category->getName())));
            $categoryRepository->save($category, true);

            return $this->redirectToRoute('homepage');
        }

        return $this->render('category/edit.html.twig', [
            'form' => $form,
        ]);
    }
}
