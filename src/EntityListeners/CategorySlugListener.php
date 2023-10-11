<?php

namespace App\EntityListeners;

use App\Entity\Category;
use Symfony\Component\String\Slugger\SluggerInterface;

class CategorySlugListener
{
    protected SluggerInterface $slugger;

    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }

    public function prePersist(Category $category): void
    {
        if (empty($category->getSlug())) {
            $category->setSlug(strtolower($this->slugger->slug($category->getName()))); /* @phpstan-ignore-line */
        }
    }
}
