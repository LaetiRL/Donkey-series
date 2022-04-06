<?php
// src/Controller/ProgramController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Repository\ProgramRepository;

/**
 * @Route("/program", name="program_")
 */

class ProgramController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(ProgramRepository $programs): Response
    {       
        return $this->render(
            'program/index.html.twig',
            ['programs' => $programs->findAll()]
        );
    }

    /**
     * @Route("/show/{id<\d+>}", methods={"GET"}, name="show")
     */
    public function show(ProgramRepository $programs, int $id): Response
    {
        $program = $programs->findOneBy(['id' => $id]);
        
        if (!$program) {
            throw $this->createNotFoundException(
                'No program with id '.$id.' found in program\'s table.'
            );
        }
        return $this->render(
            'program/show.html.twig',
            ['id' => $program]
        );
    }
}