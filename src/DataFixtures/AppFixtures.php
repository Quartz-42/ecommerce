<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use App\Entity\Product;
use App\Entity\Category;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\String\Slugger\SluggerInterface;

class AppFixtures extends Fixture
{
    protected $slugger;

    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        $faker->addProvider(new \Liior\Faker\Prices($faker));
        $faker->addProvider(new \Bezhanov\Faker\Provider\Commerce($faker));
        $faker->addProvider(new \Bluemmb\Faker\PicsumPhotosProvider($faker));

        for ($c = 0; $c < 5; ++$c) {
            $category = new Category();
            $category
                ->setName($faker->department)
                ->setSlug(strtolower($this->slugger->slug($category->getName())));

            $manager->persist($category);

            for ($p = 0; $p < 30; ++$p) {
                $product = new Product();
                $product
                    ->setName($faker->productName)
                    ->setPrice($faker->price(4000, 20000))
                    ->setSlug(strtolower($this->slugger->slug($product->getName())))
                    ->setCategory($category)
                    ->setShortDescription($faker->paragraph(3, false))
                    ->setMainPicture($faker->imageUrl(400, 400, true))
                    ->setPublicationDate($faker->dateTimeBetween('-1 month', '+6 months'));

                $manager->persist($product);
            }
        }

        $admin = new User();
        $admin
            ->setEmail('admin@gmail.com')
            ->setFullName("admin")
            ->setPassword("passowrd")
            ->setRoles(['ROLE_ADMIN']);

        $manager->persist($admin);

        for ($u = 0; $u < 5; $u++) {
            $user = new User();
            $user
                ->setEmail('user' . $u . '@gmail.com')
                ->setFullName($faker->name())
                ->setPassword("password");

            $manager->persist($user);
        }

        $manager->flush();
    }
}
