<?php

namespace App\Controller\Purchase;

use App\Entity\PurchaseItem;
use App\Form\Type\CartConfirmationType;
use App\Service\CartService;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;

class PurchaseConfirmationController extends AbstractController
{
    protected Security $security;
    protected CartService $cartService;
    protected EntityManager $em;
    protected MailerInterface $mailer;

    public function __construct(Security $security, CartService $cartService, EntityManagerInterface $em, MailerInterface $mailer)
    {
        $this->security = $security;
        $this->cartService = $cartService;
        $this->em = $em;
        $this->mailer = $mailer;
    }

    #[Route('/purchase/confirm', name: 'purchase_confirm')]
    public function confirm(Request $request): RedirectResponse
    {
        $form = $this->createForm(CartConfirmationType::class);
        $form->handleRequest($request);

        /* @phpstan-ignore-next-line */
        if (!$form->isSubmitted()) {
            $this->addFlash('warning', 'Erreur dans la soumission du formulaire');

            return $this->redirectToRoute('cart_show');
        }

        /** @var \App\Entity\User $user */
        $user = $this->getUser();

        if (!$user) {
            $this->addFlash('warning', 'Vous devez être connecté pour valider votre commande');

            return $this->redirectToRoute('cart_show');
        }

        $cartItems = $this->cartService->getDetailedCartItems();
        if (!$cartItems) {
            $this->addFlash('warning', 'Impossible de confirmer une commande vide');

            return $this->redirectToRoute('cart_show');
        }

        /** @var \App\Entity\Purchase $purchase */
        $purchase = $form->getData();

        $purchase->setUsers($user);

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
            $purchasedItems[] = $purchaseItem;
        }

        $this->em->flush();

        $email = (new TemplatedEmail())
            ->from('benjamin.baroche@free.fr')
            /* @phpstan-ignore-next-line */
            ->to($user->getEmail())
            ->replyTo('contact@mail.com')
            ->subject('Confirmation de votre commande')
            ->text('Bonne nouvelle en vue !')
            ->htmlTemplate('/purchase/purchase_confirmation_email.html.twig')
            ->context([
                'purchasedItems' => $purchasedItems,
                'purchase' => $purchase,
            ]);

        $this->mailer->send($email);

        return $this->redirectToRoute('purchase_payment_form', [
            'id' => $purchase->getId(),
        ]);
    }
}
