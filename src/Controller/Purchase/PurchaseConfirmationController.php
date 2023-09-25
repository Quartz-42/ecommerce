<?php

namespace App\Controller\Purchase;

use App\Entity\Purchase;
use App\Entity\PurchaseItem;
use App\Form\Type\CartConfirmationType;
use App\Service\CartService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PurchaseConfirmationController extends AbstractController
{
    protected $security;
    protected $cartService;
    protected $em;

    public function __construct(Security $security, CartService $cartService, EntityManagerInterface $em)
    {
        $this->security = $security;
        $this->cartService = $cartService;
        $this->em = $em;
    }

    #[Route('/purchase/confirm', name: 'purchase_confirm')]
    public function confirm(Request $request)
    {
        $form = $this->createForm(CartConfirmationType::class);
        $form->handleRequest($request);

        if (!$form->isSubmitted()) {
            $this->addFlash('warning', 'Erreur dans la soumission du formulaire');

            return $this->redirectToRoute('cart_show');
        }

        $user = $this->getUser();

        if (!$user) {
            $this->addFlash('warning', 'Vous devez posséder un compte et être connecté pour valider votre commande');
            return $this->redirectToRoute('cart_show');
        }

        $cartItems = $this->cartService->getDetailedCartItems();
        if (!$cartItems) {
            $this->addFlash('warning', 'Impossible de confirmer une commande vide');

            return $this->redirectToRoute('cart_show');
        }

        /** @var Purchase */
        $purchase = $form->getData();

        $purchase
            ->setUsers($user)
            ->setPurchasedAt(\DateTimeImmutable::createFromMutable(new \DateTime()))
            ->setTotal($this->cartService->getTotal());

        $this->em->persist($purchase);

        foreach ($this->cartService->getDetailedCartItems() as $cartItem) {
            $purchaseItem = new PurchaseItem();
            $purchaseItem
                ->setPurchase($purchase)
                ->setProduct($cartItem->product)
                ->setProductName($cartItem->product->getName())
                ->setProductQuantity($cartItem->quantity)
                ->setTotal($cartItem->getTotal())
                ->setProductPrice($cartItem->product->getPrice());

            $this->em->persist($purchaseItem);
        }

        $this->em->flush();

        $this->cartService->empty();

        $this->addFlash('success', 'La commande a bien été enregistrée');

        return $this->redirectToRoute('homepage');
    }
}
