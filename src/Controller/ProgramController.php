<?php
// src/Controller/ProgramController.php
namespace App\Controller;

use App\Entity\Program;
use App\Entity\Season;
use App\Entity\Episode;
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
     * @Route("/{id<\d+>}", methods={"GET"}, name="show")
     */
    public function show(Program $program): Response
    {
        
        if (!$program) {
            throw $this->createNotFoundException(
                'No program with id ' . $program->getId() . ' found.'
            );
        }

        $seasons = $program->getSeasons();

        return $this->render(
            'program/show.html.twig',
            ['id' => $program, 'seasons' => $seasons]
        );
    }

    /**
     * @Route("/{program<\d+>}/season/{season<\d+>}", methods={"GET"}, name="season_show")
     */
    public function showSeason(Program $program, Season $season): Response
    {
        $episodes = $season->getEpisodes();

        if (!$season) {
            throw $this->createNotFoundException(
                'No season with id ' . $season->getId() . ' found.'
            );
        }
        return $this->render(
            'program/season_show.html.twig',
            ['program' => $program, 'season' => $season, 'episodes' => $episodes]
        );
    }

    /**
     * @Route("/{program<\d+>}/season/{season<\d+>}/episode/{episode<\d+>}", methods={"GET"}, name="episode_show")
     */
    public function showEpisode(Program $program, Season $season, Episode $episode): Response
    {
        if (!$episode) {
            throw $this->createNotFoundException(
                'No season with id ' . $episode->getId() . ' found.'
            );
        }
        return $this->render(
            'program/episode_show.html.twig',
            ['program' => $program, 'season' => $season, 'episode' => $episode]
        );
    }
}
