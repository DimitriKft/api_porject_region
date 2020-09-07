<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\Encoder\DecoderInterface;

class ApiController extends AbstractController
{
    /**
     * @Route("/listeRegions", name="listeRegions")
     */
    public function listeRegions(SerializerInterface $serializerInterface)
    {
        $mesRegions = file_get_contents('https://geo.api.gouv.fr/regions');
        $mesRegions = $serializerInterface->deserialize($mesRegions, 'App\Entity\Region[]', 'json');
        return $this->render('api/index.html.twig', [
            'mesRegions' => $mesRegions
        ]);
    }

     /**
     * @Route("/listeDepsParRegion", name="listeDepsParRegion")
     */
    public function listeDepsParRegion(Request $request,DecoderInterface $decoderInterface, SerializerInterface $serializerInterface)
    {
        // Je récupère les région du select, get('region') me permet de chercher la valeur du select dans mon form via l'url.
        $codeRegion = $request->query->get('region'); 

        //je recupere les régions de l'api
        $mesRegions = file_get_contents('https://geo.api.gouv.fr/regions');
        $mesRegions = $serializerInterface->deserialize($mesRegions, 'App\Entity\Region[]', 'json');

        //Je récupère les départements de l'api
        if($codeRegion == null || $codeRegion == "Toutes")
        {
            $mesDeps = file_get_contents('https://geo.api.gouv.fr/departements');
        }
        else
        {
            $mesDeps = file_get_contents('https://geo.api.gouv.fr/regions/' . $codeRegion. '/departements');
        }

        // décodage du format json en tableau
        $mesDeps = $decoderInterface->decode($mesDeps, 'json');
       
        return $this->render('api/listDepsParRegion.html.twig', [
            'mesRegions' => $mesRegions,
            'mesDeps'    => $mesDeps
        ]);
    }
}
