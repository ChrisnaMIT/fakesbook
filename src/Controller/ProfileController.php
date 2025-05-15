<?php

namespace App\Controller;

use App\Entity\Image;
use App\Entity\Profile;
use App\Form\ProfileForm;
use App\Repository\PostRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\ImageForm;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ProfileController extends AbstractController
{
    #[Route('/profile/{id}', name: 'app_profile')]
    public function index(Profile $profile, PostRepository $postRepository, Request $request, EntityManagerInterface $manager): Response
    {
        if(!$this->getUser()){
            return $this->redirectToRoute('app_login');
        }
        if($this->getUser() !== $profile->getOfUser()){
            return $this->redirectToRoute('app_login');
        }

        $user = $this->getUser();
        $form = $this->createForm(ProfileForm::Class, $profile);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $manager->persist($profile);
            $manager->flush();
            return $this->redirectToRoute('app_profile', ['id' => $profile->getId()]);
        }
        return $this->render('profile/index.html.twig', [
            'profile' => $profile,
            'formProfile' => $form->createView(),
            'posts' => $postRepository->findBy(['profile' => $profile->getId()]),
            'user' => $user,
        ]);
    }


    #[Route('/profile/{id}/addImage', name: 'app_addImageProfile')]
    public function create(Request $request, EntityManagerInterface $manager, UserRepository $userRepository): Response
    {
        if(!$this->getUser()){
        return $this->redirectToRoute('app_login');}



        $image = new Image();
        $form = $this->createForm(ImageForm::class, $image);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $image->setProfile($this->getUser()->getProfile());
            $manager->persist($image);
            $manager->flush();
            return $this->redirectToRoute('app_addImageProfile', ['id' => $image->getProfile()->getId()]);
        }
        return $this->render('profile/addImageProfile.html.twig', [
            'form' => $form->createView(),
        ]);
    }





}
