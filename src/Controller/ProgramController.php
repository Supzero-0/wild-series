<?php

// src/Controller/ProgramController.php

namespace App\Controller;

use App\Entity\Program;
use App\Entity\Season;
use App\Entity\Episode;
use App\Repository\ProgramRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/program', name: 'program_')]

class ProgramController extends AbstractController
{
    #[Route('/', name: 'index')]

    public function index(ProgramRepository $programRepository): Response
    {
        $programs = $programRepository->findAll();

        return $this->render(
            'program/index.html.twig',
            ['programs' => $programs]
        );
    }

    #[Route('/{program_id}', methods: ['GET'], requirements: ['id' => '\d+'], name: 'show')]
    #[Entity('program', options: ['mapping' => ['program_id' => 'id']])]

    public function show(Program $program): Response
    {
        $seasons = $program->getSeasons();

        if (!$program) {
            throw $this->createNotFoundException(
                'No program with id : {program_id} found in program\'s table.'
            );
        }
        return $this->render('program/show.html.twig', ['program' => $program, 'seasons' => $seasons]);
    }

    #[Route('/{program_id}/seasons/{season_id}', methods: ['GET'], requirements: ['id' => '\d+'], name: 'season_show')]
    #[Entity('program', options: ['mapping' => ['program_id' => 'id']])]
    #[Entity('season', options: ['mapping' => ['season_id' => 'id']])]

    public function showSeason(Program $program, Season $season): Response
    {
        $episodes = $season->getEpisodes();

        if (!$episodes) {
            throw $this->createNotFoundException(
                'No episodes for this program !'
            );
        }

        return $this->render('season/show.html.twig', ['program' => $program, 'season' => $season, 'episodes' => $episodes]);
    }

    #[Route('/{program_id}/seasons/{season_id}/episode/{episode_id}', methods: ['GET'], requirements: ['id' => '\d+'], name: 'episode_show')]
    #[Entity('program', options: ['mapping' => ['program_id' => 'id']])]
    #[Entity('season', options: ['mapping' => ['season_id' => 'id']])]
    #[Entity('episode', options: ['mapping' => ['episode_id' => 'id']])]

    public function showEpisode(Program $program, Season $season, Episode $episode): Response
    {
        if (!$episode) {
            throw $this->createNotFoundException(
                'No episode for this program !'
            );
        }

        return $this->render('program/episode_show.html.twig', ['program' => $program, 'season' => $season, 'episode' => $episode]);
    }
}
