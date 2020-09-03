<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\DecoderInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\SerializerInterface;

class ApiController extends AbstractController
{
    /**
     * @Route("/listeRegions", name="listeRegions")
     */
    public function listeRegions(DecoderInterface $decode, DenormalizerInterface $denormalizerInterface,SerializerInterface $serializerInterface)
    {
        $mesRegions = file_get_contents('https://geo.api.gouv.fr/regions');
        $mesRegions = $serializerInterface->deserialize($mesRegions, 'App\Entity\Region[]', 'json');
        return $this->render('api/index.html.twig', [
            'mesRegions' => $mesRegions
        ]);
    }
}
