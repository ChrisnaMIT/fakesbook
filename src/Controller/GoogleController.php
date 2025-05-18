<?php

namespace App\Controller;

use App\Entity\User;
use App\Security\SecurityAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;

class GoogleController extends AbstractController
{
    #[Route('/connect/google', name: 'connect_google_start')]
    public function connect(ClientRegistry $clientRegistry)
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('app_posts');
        }

        return $clientRegistry
            ->getClient('google')
            ->redirect([], [
                'prompt' => 'select_account',
                'scope' => ['email', 'profile'],
            ]);
    }

    #[Route('/connect/google/check', name: 'connect_google_check')]
    public function connectCheck(
        Request $request,
        ClientRegistry $clientRegistry,
        UserPasswordHasherInterface $passwordHasher,
        EntityManagerInterface $entityManager,
        UserAuthenticatorInterface $userAuthenticator,
        SecurityAuthenticator $authenticator
    ) {
        if ($this->getUser()) {
            return $this->redirectToRoute('app_posts');
        }

        $client = $clientRegistry->getClient('google');

        try {
            $googleUser = $client->fetchUser();

            $email = $googleUser->getEmail();
            $googleId = $googleUser->getId();

            $existingUser = $entityManager->getRepository(User::class)->findOneBy(['email' => $email]);

            if ($existingUser) {
                return $userAuthenticator->authenticateUser($existingUser, $authenticator, $request);
            }

            $user = new User();
            $user->setEmail($email);
            $user->setGoogleId($googleId);
            $user->setPassword($passwordHasher->hashPassword($user, bin2hex(random_bytes(20))));

            $entityManager->persist($user);
            $entityManager->flush();

            return $userAuthenticator->authenticateUser($user, $authenticator, $request);
        } catch (IdentityProviderException $e) {
            dd($e->getMessage());
        }
    }
}
