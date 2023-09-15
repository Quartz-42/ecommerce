<?php

namespace App\Twig;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

final class AppExtension extends AbstractExtension
{
    public function __construct(private CategoryRepository $categoryRepository)
    {
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('list_categories', [$this, 'findAllCategories']),
        ];
    }

    /**
     * @return Category[]
     */
    public function findAllCategories(): array
    {
        return $this->categoryRepository->findAll();
    }
}
