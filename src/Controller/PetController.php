<?php

namespace App\Controller;

use App\Entity\Pet;
use App\Form\PetType;
use App\Repository\PetRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/pet')]
class PetController extends AbstractController
{
    #[Route('/', name: 'pet_index', methods: ['GET'])]
    public function index(PetRepository $petRepository): Response
    {
        return $this->render('pet/index.html.twig', [
            'pets' => $petRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'pet_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $pet = new Pet();
        $form = $this->createForm(PetType::class, $pet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($pet);
            $entityManager->flush();

            return $this->redirectToRoute('pet_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('pet/new.html.twig', [
            'pet' => $pet,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'pet_show', methods: ['GET'])]
    public function show(Pet $pet): Response
    {
        return $this->render('pet/show.html.twig', [
            'pet' => $pet,
        ]);
    }

    #[Route('/{id}/edit', name: 'pet_edit', methods: ['GET', 'POST'])]
    public function edit(
        Request                $request,
        Pet                    $pet,
        EntityManagerInterface $entityManager,
        SluggerInterface       $slugger
    ): Response
    {
        $form = $this->createForm(PetType::class, $pet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imageFile = $form->get('picture')->getData();
            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);

                $imageFile->move(
                    $this->getParameter('pets_directory'),
                    $newFilename
                );

                $pet->setPicture($newFilename);
            }

            $entityManager->flush();

            return $this->redirectToRoute('pet_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('pet/edit.html.twig', [
            'pet' => $pet,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'pet_delete', methods: ['POST'])]
    public function delete(Request $request, Pet $pet, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $pet->getId(), $request->request->get('_token'))) {
            $entityManager->remove($pet);
            $entityManager->flush();
        }

        return $this->redirectToRoute('pet_index', [], Response::HTTP_SEE_OTHER);
    }
}
