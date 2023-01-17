<?php

namespace App\Controller;

use App\Entity\EquipementExt;
use App\Form\EquipementExtType;
use App\Repository\EquipementExtRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/equipement/ext')]
class EquipementExtController extends AbstractController
{
    #[Route('/', name: 'app_equipement_ext_index', methods: ['GET'])]
    public function index(EquipementExtRepository $equipementExtRepository): Response
    {
        return $this->render('equipement_ext/index.html.twig', [
            'equipement_exts' => $equipementExtRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_equipement_ext_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EquipementExtRepository $equipementExtRepository): Response
    {
        $equipementExt = new EquipementExt();
        $form = $this->createForm(EquipementExtType::class, $equipementExt);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $equipementExtRepository->save($equipementExt, true);

            return $this->redirectToRoute('app_equipement_ext_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('equipement_ext/new.html.twig', [
            'equipement_ext' => $equipementExt,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_equipement_ext_show', methods: ['GET'])]
    public function show(EquipementExt $equipementExt): Response
    {
        return $this->render('equipement_ext/show.html.twig', [
            'equipement_ext' => $equipementExt,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_equipement_ext_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, EquipementExt $equipementExt, EquipementExtRepository $equipementExtRepository): Response
    {
        $form = $this->createForm(EquipementExtType::class, $equipementExt);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $equipementExtRepository->save($equipementExt, true);

            return $this->redirectToRoute('app_equipement_ext_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('equipement_ext/edit.html.twig', [
            'equipement_ext' => $equipementExt,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_equipement_ext_delete', methods: ['POST'])]
    public function delete(Request $request, EquipementExt $equipementExt, EquipementExtRepository $equipementExtRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$equipementExt->getId(), $request->request->get('_token'))) {
            $equipementExtRepository->remove($equipementExt, true);
        }

        return $this->redirectToRoute('app_equipement_ext_index', [], Response::HTTP_SEE_OTHER);
    }
}
