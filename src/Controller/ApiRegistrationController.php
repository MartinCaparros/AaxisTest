<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ApiRegistrationController extends AbstractController
{
    #[Route('/api/register', name: 'app_api_register')]
    public function index(ManagerRegistry $doctrine, Request $request, UserPasswordHasherInterface $passwordHasher): JsonResponse
    {
       $em = $doctrine->getManager();
       $decoded = json_decode($request->getContent());
       $email = $decoded->email;
       $plaintextPassword = $decoded->password;

       $user = new User();
       $hashedPassword = $passwordHasher->hashPassword(
           $user,
           $plaintextPassword
       );
       $user->setPassword($hashedPassword);
       $user->setEmail($email);
       $em->persist($user);
       $em->flush();

       return $this->json(['message' => 'Registered successfully!']);
    }
}