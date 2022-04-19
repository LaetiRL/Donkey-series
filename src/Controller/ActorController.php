<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Actor;
use App\Repository\ActorRepository;

class ActorController extends AbstractController
{
    #[Route('/actor', name: 'actor')]
    public function index(ActorRepository $actor): Response
    {
        return $this->render(
            'actor/index.html.twig',
            ['actor' => $actor->findAll()]
        );
    }

    #[Route('/actor/{id}', name: 'actor_show', methods: ['GET'])]
    public function show(Actor $actor): Response
    {
        
        if (!$actor) {
            throw $this->createNotFoundException(
                'No program with id ' . $actor->getId() . ' found.'
            );
        }

        $programs = $actor->getPrograms();

        return $this->render(
            'actor/show.html.twig',
            ['id' => $actor, 'programs' => $programs]
        );
    }
}
