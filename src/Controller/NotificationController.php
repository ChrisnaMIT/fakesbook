<?php

namespace App\Controller;

use App\Entity\Like;
use App\Entity\Notification;
use App\Repository\NotificationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class NotificationController extends AbstractController
{
    #[Route('/notification', name: 'app_notification')]
    public function index(NotificationRepository $notificationRepository, EntityManagerInterface $manager): Response
    {

        $profile = $this->getUser()->getProfile();
       $notifications = $notificationRepository->findby(['profile' => $profile]);

       return $this->render('notification/index.html.twig', [
           'notifications' => $notifications,
       ]);
    }
}
