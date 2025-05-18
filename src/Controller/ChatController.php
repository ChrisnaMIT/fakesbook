<?php

namespace App\Controller;

use App\Entity\Conversation;
use App\Entity\Message;
use App\Entity\Notification;
use App\Entity\Profile;
use App\Form\MessageForm;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ChatController extends AbstractController
{
    #[Route('/chat/initiate/{id}', name: 'app_chat_initiate')]
    public function initiate(Profile $profile, EntityManagerInterface $manager): Response
    {
        if(!$profile){return $this->redirectToRoute('app_people');}

        $conversation = $this->getUser()->getProfile()->isChattingWith($profile);

        if(!$conversation){
            $conversation =new Conversation();
            $conversation->addParticipant($this->getUser()->getProfile());
            $conversation->addParticipant($profile);
            $conversation->setCreatedAt(new \DateTimeImmutable());
            $manager->persist($conversation);
            $manager->flush();

        }
        return $this->redirectToRoute('app_chat', ['id'=> $conversation->getId()]);
    }

    #[Route('/chat/{id}', name: 'app_chat')]
    public function chat(Conversation $chat, EntityManagerInterface $manager, Request $request): Response
    {
        if(!$chat){
            return $this->redirectToRoute('app_people');
        }

        $message = new Message();
        $form =$this->createForm(MessageForm::class , $message);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){

            $message->setConversation($chat);
            $message->setCreatedAt(new \DateTimeImmutable());
            $message->setAuthor($this->getUser()->getProfile());
            $manager->persist($message);



            $notification = new Notification();
            $notification->setProfile($this->getUser()->getProfile());
            $notification->setMessageNotification($message);
            $notification->setCreatedAt(new \DateTimeImmutable());


            $manager->persist($notification);
            $manager->flush();
            return $this->redirectToRoute('app_chat', ['id'=> $chat->getId()]);

        }

        return $this->render('chat/chat.html.twig', [
            'chat' => $chat,
            'form' => $form,
        ]);


    }













}
