<?php
// src/Controller/ProgramController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Repository\ProgramRepository;
use App\Repository\SeasonRepository;

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
     * @Route("/{id<\d+>}", methods={"GET"}, name="show")
     */
    public function show(ProgramRepository $programs, int $id): Response
    {
        $program = $programs->findOneBy(['id' => $id]);
        
        if (!$program) {
            throw $this->createNotFoundException(
                'No program with id '.$id.' found.'
            );
        }
        
        $seasons = $program->getSeasons();
  
        return $this->render(
            'program/show.html.twig',
            ['id' => $program, 'seasons' => $seasons]
        );
    }

    /**
     * @Route("/{programId<\d+>}/season/{seasonId<\d+>}", methods={"GET"}, name="season_show")
     */
    public function showSeason(ProgramRepository $programs, SeasonRepository $seasons, int $programId, int $seasonId): Response
    {   
        $program = $programs->findOneBy(['id' => $programId]);
        $season = $seasons->findOneBy(['id' => $seasonId]);
        $episodes = $season->getEpisodes();
    
        if (!$program) {
            throw $this->createNotFoundException(
                'No program with id '.$programId.' found.'
            );
        }
        if (!$season) {
            throw $this->createNotFoundException(
                'No season with id '.$seasonId.' found.'
            );
        }
        return $this->render(
            'program/season_show.html.twig',
            ['program' => $program, 'season' => $season, 'episodes' => $episodes]
        );

    }
}