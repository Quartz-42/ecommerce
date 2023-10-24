<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Product;
use App\Entity\Purchase;
use App\Entity\PurchaseItem;
use App\Entity\User;
use Bezhanov\Faker\Provider\Commerce;
use Bluemmb\Faker\PicsumPhotosProvider;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Liior\Faker\Prices;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\String\Slugger\SluggerInterface;

class AppFixtures extends Fixture
{
    protected SluggerInterface $slugger;
    protected UserPasswordHasherInterface $hasher;

    public function __construct(SluggerInterface $slugger, UserPasswordHasherInterface $hasher)
    {
        $this->slugger = $slugger;
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        $faker->addProvider(new Prices($faker));
        $faker->addProvider(new Commerce($faker));
        $faker->addProvider(new PicsumPhotosProvider($faker));

        $products = [];

        for ($c = 0; $c < 4; ++$c) {
            $category = new Category();
            $category
                ->setName($faker->department); /* @phpstan-ignore-line */
            // ->setSlug(strtolower($this->slugger->slug($category->getName())));

            $manager->persist($category);

            for ($p = 0; $p < 30; ++$p) {
                $product = new Product();
                $product
                    ->setName($faker->productName) /* @phpstan-ignore-line */
                    ->setPrice($faker->price(4000, 20000)) /* @phpstan-ignore-line */
                    ->setSlug(strtolower($this->slugger->slug($product->getName()))) /* @phpstan-ignore-line */
                    ->setCategory($category)
                    ->setShortDescription($faker->paragraph(3, false))
                    ->setMainPicture($faker->imageUrl(400, 400, true))
                    ->setPublicationDate($faker->dateTimeBetween('-1 month', '+6 months'));
                $products[] = $product;

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
                ->setEmail('user'.$u.'@gmail.com')
                ->setPassword($hash)
                ->setIsVerified(true);

            $users[] = $user;

            $manager->persist($user);
        }

        for ($p = 0; $p < 20; ++$p) {
            $purchase = new Purchase();
            $purchase
                ->setFullName($faker->name())
                ->setAddress($faker->streetAddress)
                ->setPostalCode($faker->postcode)
                ->setCity($faker->city)
                ->setUsers($faker->randomElement($users))
                ->setTotal(mt_rand(2000, 300000))
                ->setPurchasedAt(\DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-6months')));

            $selectedProducts = $faker->randomElements($products, mt_rand(3, 5));

            foreach ($selectedProducts as $product) {
                $purchaseItem = new PurchaseItem();
                $purchaseItem
                    ->setProduct($product)
                    ->setProductQuantity(mt_rand(1, 4))
                    ->setProductName($product->getName())
                    ->setProductPrice($product->getPrice())
                    ->setTotal($purchaseItem->getProductPrice() * $purchaseItem->getProductQuantity())
                    ->setPurchase($purchase);

                $manager->persist($purchaseItem);
            }

            if ($faker->boolean(90)) {
                $purchase->setStatus(Purchase::STATUS_PAID);
            }

            $manager->persist($purchase);
        }

        $manager->flush();
    }
}
