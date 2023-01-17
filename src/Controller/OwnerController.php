<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ContactType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class OwnerController extends AbstractController
{
    #[Route('/owner/add-contact', name: 'app_owner')]
    public function add_contact(Request $request, UserPasswordHasherInterface $userPasswordHasher, UserRepository $userRepository): Response
    {

        $contact = new User();
        //
        $form = $this->createForm(ContactType::class , $contact);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $contact->setRoles(['ROLE_CONTACT']);
            $contact->setPassword(
                $userPasswordHasher->hashPassword(
                    $contact,
                    '123456'
                )
            );

            $contact->setOwner($this->getUser());

            $userRepository->save($contact, true);


            dd($contact);
        }
        return $this->render('owner/index.html.twig', [
            'form' => $form,
        ]);
    }
}
