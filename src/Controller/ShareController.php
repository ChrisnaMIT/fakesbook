<?php

namespace App\Controller;

use App\Entity\Conversation;
use App\Entity\Message;
use App\Entity\Post;
use App\Entity\Profile;
use App\Entity\Share;
use App\Repository\ProfileRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ShareController extends AbstractController
{
    #[Route('/sharewith/{id}', name: 'app_share_with')]
    public function shareWith(Post $post): Response
    {
        return $this->render('share/index.html.twig', [
            'post' => $post,
        ]);
    }



    #[Route('/share/{post}/{recipient}', name: 'app_share')]
    public function share(Post $post, Profile $recipient, EntityManagerInterface $manager): Response
    {

        if(!$this->getUser()){
            return $this->redirectToRoute('app_login');
        }
        $senderProfile = $this->getUser()->getProfile();
        $conversation = $senderProfile->isChattingWith($recipient);

        if(!$conversation){
            $conversation =new Conversation();
            $conversation->addParticipant($senderProfile);
            $conversation->addParticipant($recipient);
            $conversation->setCreatedAt(new \DateTimeImmutable());
            $manager->persist($conversation);
        }

        $message = new Message();
        $message->setConversation($conversation);
        $message->setCreatedAt(new \DateTimeImmutable());
        $message->setAuthor($senderProfile);
        $message->setPost($post);
        $manager->persist($message);
        $manager->flush();


        $share= new Share();
        $share->setPost($post);
        $share->setSender($this->getUser()->getProfile());
        $share->setRecipient($recipient);
        $manager->persist($share);
        $manager->flush();
        return $this->redirectToRoute('app_post');

    }












}
