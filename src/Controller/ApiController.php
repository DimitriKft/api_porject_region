<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\DecoderInterface;


class ApiController extends AbstractController
{
    /**
     * @Route("/listeRegions", name="listeRegions")
     */
    public function listeRegions(DecoderInterface $decode)
    {
        $mesRegions = file_get_contents('https://geo.api.gouv.fr/regions');
        $mesRegionsTab = $decode->decode($mesRegions, 'json');
       
        return $this->render('api/index.html.twig', [
            'mesRegions' => $mesRegionsTab
        ]);
    }
}
