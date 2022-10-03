<?php

namespace App\Controller;

use App\Entity\Cafeteria;
use App\Form\CafeteriaType;
use App\Repository\CafeteriaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/cafeteria')]
class CafeteriaController extends AbstractController
{
    #[Route('/', name: 'app_cafeteria_index', methods: ['GET'])]
    public function index(CafeteriaRepository $cafeteriaRepository): Response
    {
        return $this->render('cafeteria/index.html.twig', [
            'cafeterias' => $cafeteriaRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_cafeteria_new', methods: ['GET', 'POST'])]
    public function new(Request $request, CafeteriaRepository $cafeteriaRepository): Response
    {
        $cafeterium = new Cafeteria();
        $form = $this->createForm(CafeteriaType::class, $cafeterium);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $cafeteriaRepository->save($cafeterium, true);

            return $this->redirectToRoute('app_cafeteria_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('cafeteria/new.html.twig', [
            'cafeterium' => $cafeterium,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_cafeteria_show', methods: ['GET'])]
    public function show(Cafeteria $cafeterium): Response
    {
        return $this->render('cafeteria/show.html.twig', [
            'cafeterium' => $cafeterium,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_cafeteria_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Cafeteria $cafeterium, CafeteriaRepository $cafeteriaRepository): Response
    {
        $form = $this->createForm(CafeteriaType::class, $cafeterium);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $cafeteriaRepository->save($cafeterium, true);

            return $this->redirectToRoute('app_cafeteria_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('cafeteria/edit.html.twig', [
            'cafeterium' => $cafeterium,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_cafeteria_delete', methods: ['POST'])]
    public function delete(Request $request, Cafeteria $cafeterium, CafeteriaRepository $cafeteriaRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$cafeterium->getId(), $request->request->get('_token'))) {
            $cafeteriaRepository->remove($cafeterium, true);
        }

        return $this->redirectToRoute('app_cafeteria_index', [], Response::HTTP_SEE_OTHER);
    }
}
