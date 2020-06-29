<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class WildController
 * @package App\Controller
 * @Route("/wild")
 */
class WildController extends AbstractController
{
    /**
     * @Route("/show/{slug}",
     *     requirements={"slug"="[a-z1-9\-\/]+"},
     *     defaults={"slug"="Aucune série sélectionnée, veuillez choisir une série"},
     *     methods={"GET"},
     *     name="show")
     */
    public function show(string $slug)
    {
        if (!strpos($slug, " ")) {
            $newSlug = ucwords(str_replace("-", " ", $slug));
        } else {
            $newSlug = $slug;
        }

        return $this->render('wild/showSlug.html.twig', [
            'slug' => $newSlug,
        ]);
}
}
