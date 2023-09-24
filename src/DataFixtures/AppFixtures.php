<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use App\Entity\Product;
use App\Entity\Category;
use App\Entity\Purchase;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    protected $slugger;
    protected $hasher;

    public function __construct(SluggerInterface $slugger, UserPasswordHasherInterface $hasher)
    {
        $this->slugger = $slugger;
        $this->hasher = $hasher;
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
        $hash = $this->hasher->hashPassword($admin, 'password');
        $admin
            ->setEmail('admin@gmail.com')
            ->setPassword($hash)
            ->setRoles(['ROLE_ADMIN'])
            ->setIsVerified(true);

        $manager->persist($admin);

        $users = [];

        for ($u = 0; $u < 5; ++$u) {
            $user = new User();
            $hash = $this->hasher->hashPassword($user, 'password');
            $user
                ->setEmail('user' . $u . '@gmail.com')
                ->setPassword($hash)
                ->setIsVerified(true);

            $users[] = $user;

            $manager->persist($user);
        }

        for ($p = 0; $p < 20; $p++) {
            $purchase = new Purchase();
            $purchase
                ->setFullName($faker->name())
                ->setAddress($faker->streetAddress)
                ->setPostalCode($faker->postcode)
                ->setCity($faker->city)
                ->setUsers($faker->randomElement($users))
                ->setTotal(mt_rand(2000, 300000));

            if ($faker->boolean(90)) {
                $purchase->setStatus(Purchase::STATUS_PAID);
            }

            $manager->persist($purchase);
        }

        $manager->flush();
    }
}
