<?php

namespace App\Controller;

use App\Entity\EquipementInt;
use App\Form\EquipementIntType;
use App\Repository\EquipementIntRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/equipement/int')]
class EquipementIntController extends AbstractController
{
    #[Route('/', name: 'app_equipement_int_index', methods: ['GET'])]
    public function index(EquipementIntRepository $equipementIntRepository): Response
    {
        return $this->render('equipement_int/index.html.twig', [
            'equipement_ints' => $equipementIntRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_equipement_int_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EquipementIntRepository $equipementIntRepository): Response
    {
        $equipementInt = new EquipementInt();
        $form = $this->createForm(EquipementIntType::class, $equipementInt);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $equipementIntRepository->save($equipementInt, true);

            return $this->redirectToRoute('app_equipement_int_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('equipement_int/new.html.twig', [
            'equipement_int' => $equipementInt,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_equipement_int_show', methods: ['GET'])]
    public function show(EquipementInt $equipementInt): Response
    {
        return $this->render('equipement_int/show.html.twig', [
            'equipement_int' => $equipementInt,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_equipement_int_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, EquipementInt $equipementInt, EquipementIntRepository $equipementIntRepository): Response
    {
        $form = $this->createForm(EquipementIntType::class, $equipementInt);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $equipementIntRepository->save($equipementInt, true);

            return $this->redirectToRoute('app_equipement_int_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('equipement_int/edit.html.twig', [
            'equipement_int' => $equipementInt,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_equipement_int_delete', methods: ['POST'])]
    public function delete(Request $request, EquipementInt $equipementInt, EquipementIntRepository $equipementIntRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$equipementInt->getId(), $request->request->get('_token'))) {
            $equipementIntRepository->remove($equipementInt, true);
        }

        return $this->redirectToRoute('app_equipement_int_index', [], Response::HTTP_SEE_OTHER);
    }
}
