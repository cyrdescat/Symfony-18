<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Program;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class WildController
 * @package App\Controller
 * @Route("/wild", name="wild_")
 */
class WildController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index()
    {
        $programs = $this->getDoctrine()->getRepository(Program::class)->findAll();

        if (!$programs) {
            throw $this->createNotFoundException("No program found in program's table.");
        }

        return $this->render("wild/index.html.twig", ['programs' => $programs]);
    }

    /**
     * @param string $category
     * @return Response
     * @Route("/category/{categoryName}",
     *     requirements={"categoryName"="[a-z1-9\-\/]+"},
     *     methods={"GET"},
     *     name="show_category")
     */
    public function showByCategory(string $categoryName) : Response
    {
        $category = $this->getDoctrine()
            ->getRepository(Category::class)
            ->findOneBy(['name' => ucwords($categoryName)]);


        if (!$category) {
            throw $this->createNotFoundException(
                "No category with " . $categoryName . " category, found in category's table."
            );
        }

        $programs = $this->getDoctrine()
            ->getRepository(Program::class)
            ->findBy(
                ['category' => $category],
                ['id' => 'DESC'],
                3
            );

        if (!$programs) {
            throw $this->createNotFoundException(
                "No programs with " . $$categoryName . " category, found in program's table."
            );
        }

        return $this->render('wild/category.html.twig', [
            'programs' => $programs,
            'title' => 'horror',
        ]);
    }

    /**
     * @param string|null $slug
     * @return Response
     * @Route("/show/{slug}",
     *     requirements={"slug"="[a-z1-9\-\/]+"},
     *     defaults={"slug"="Aucune série sélectionnée, veuillez choisir une série"},
     *     methods={"GET"},
     *     name="show")
     */
    public function show(?string $slug) : Response
    {
        if (!$slug) {
            throw $this
                ->createNotFoundException('No slug has been sent to find a program in program\'s table.');
        }
        if (!strpos($slug, " ")) {
            $newSlug = ucwords(str_replace("-", " ", $slug));
        } else {
            $newSlug = $slug;
        }
        $program = $this->getDoctrine()
            ->getRepository(Program::class)
            ->findOneBy(['title' => mb_strtolower($newSlug)]);
        if (!$program) {
            throw $this->createNotFoundException(
                "No program with " . $newSlug . " title, found in program's table."
            );
        }

        return $this->render('wild/showSlug.html.twig', [
            'program' => $program,
            'slug' => $newSlug,
        ]);
    }
}
