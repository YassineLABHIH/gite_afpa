<?php

namespace App\Controller;

use App\Entity\Gite;
use App\Entity\GiteService;
use App\Entity\Photo;
use App\Form\GiteType;
use App\Repository\GiteRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/gite')]
class GiteController extends AbstractController
{
    #[Route('/', name: 'app_gite_index', methods: ['GET'])]
    public function index(GiteRepository $giteRepository): Response
    {
        return $this->render('gite/index.html.twig', [
            'gites' => $giteRepository->findAll(),
        ]);
    }

    #[
        Route('/new', name: 'app_gite_new', methods: ['GET', 'POST']),
        IsGranted("ROLE_OWNER")
    ]
    public function new_live(Request $request, GiteRepository $giteRepository)
    {
        $gite = new Gite();
        $giteService = new GiteService();
        $gite->addGiteService($giteService);
        $photo = new Photo();
        $gite->addPhoto($photo);

        $form = $this->createForm(GiteType::class, $gite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $gite->setOwner($this->getUser());
            $giteRepository->save($gite, true);

            return $this->redirectToRoute('app_gite_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('gite/new_live.html.twig', [
            'gite' => $gite,
            'form' => $form,
        ]);
    }


    #[
        Route('/{id}', name: 'app_gite_show', methods: ['GET']),
        IsGranted("ROLE_USER")
    ]
    public function show(Gite $gite): Response
    {
        return $this->render('gite/show.html.twig', [
            'gite' => $gite,
        ]);
    }

    #[
        Route('/{id}/edit', name: 'app_gite_edit', methods: ['GET', 'POST']),
        IsGranted("ROLE_OWNER")
    ]
    public function edit(Request $request, Gite $gite, GiteRepository $giteRepository): Response
    {
        $form = $this->createForm(GiteType::class, $gite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $giteRepository->save($gite, true);

            return $this->redirectToRoute('app_gite_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('gite/edit.html.twig', [
            'gite' => $gite,
            'form' => $form,
        ]);
    }

    #[
        Route('/{id}', name: 'app_gite_delete', methods: ['POST']),
        IsGranted("ROLE_OWNER")
    ]
    public function delete(Request $request, Gite $gite, GiteRepository $giteRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $gite->getId(), $request->request->get('_token'))) {
            $giteRepository->remove($gite, true);
        }

        return $this->redirectToRoute('app_gite_index', [], Response::HTTP_SEE_OTHER);
    }
}
