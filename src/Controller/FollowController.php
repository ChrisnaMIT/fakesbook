<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class FollowController extends AbstractController
{
    #[Route('/profile/follow/{id}', name: 'app_follow_profile')]
    public function index(): Response
    {
        return $this->render('follow/index.html.twig', [
            'controller_name' => 'FollowController',
        ]);
    }
}
