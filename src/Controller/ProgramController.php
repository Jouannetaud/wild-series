<?php

namespace App\Controller;

use App\Entity\Episode;
use App\Entity\Program;
use App\Entity\Season;
use App\Form\ProgramType;
use App\Repository\ProgramRepository;
use App\Repository\SeasonRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/program")
 */
class ProgramController extends AbstractController
{
    /**
     * @Route("/", name="program_index", methods={"GET"})
     */
    public function index(ProgramRepository $programRepository): Response
    {
        return $this->render('program/index.html.twig', [
            'programs' => $programRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="program_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $program = new Program();
        $form = $this->createForm(ProgramType::class, $program);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($program);
            $entityManager->flush();

            return $this->redirectToRoute('program_index');
        }

        return $this->render('program/new.html.twig', [
            'program' => $program,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{program}", name="program_show", methods={"GET"})
     */
    public function show(Program $program ): Response
    {

        return $this->render('program/show.html.twig', [
            'program' => $program,
            

        ]);
    }

    /**
     * @Route("/{program}/edit", name="program_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Program $program): Response
    {
        $form = $this->createForm(ProgramType::class, $program);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('program_index');
        }

        return $this->render('program/edit.html.twig', [
            'program' => $program,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{program}", name="program_delete", methods={"POST"})
     */
    public function delete(Request $request, Program $program): Response
    {
        if ($this->isCsrfTokenValid('delete'.$program->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($program);
            $entityManager->flush();
        }

        return $this->redirectToRoute('program_index');
    }

    /**
     * @Route("/{program}/seasons/{season}", name="program_season_show")
     */
    public function showSeason(Program $program, Season $season): Response
    {
        

        return $this->render('program/season_show.html.twig', [
            
            'program'=>$program,
            'season' => $season,
            
        ]);
    }


      /**
     * @Route("/{program}/seasons/{season}/episodes/{episode}", name="program_episode_show")
     */
    public function showEpisode(Program $program, Season $season , Episode $episode): Response
    {
        

        return $this->render('program/season_show.html.twig', [
             'program'=> $program,
             'season' => $season,
             'episode'=> $episode,
            
        ]);
    }

    
}
