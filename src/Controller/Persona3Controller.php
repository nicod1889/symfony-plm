<?php

namespace App\Controller;

use App\Repository\Persona3Repository;
use App\Repository\ProgramaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/persona3')]
class Persona3Controller extends AbstractController {
    #[Route('/conductores', name: 'app_conductores_index', methods: ['GET'])] 
    public function conductores(Persona3Repository $persona3Repository, ProgramaRepository $programaRepository): Response   {
        $programas = $programaRepository->findAll();

        $conductorPresencias = [];
        foreach ($programas as $programa) {
            foreach ($programa->getConductores() as $conductor) {
                $conductorId = $conductor->getId();
                if (!isset($conductorPresencias[$conductorId])) {
                    $conductorPresencias[$conductorId] = 0;
                }
                $conductorPresencias[$conductorId]++;
            }
        }
        
        $tabla = [];
        foreach ($conductorPresencias as $conductorId => $presencias) {
            $conductor = $persona3Repository->find($conductorId);
            if ($conductor) {
                $tabla[] = [
                    'nombre' => $conductor->getNombre(),
                    'presencias' => $presencias,
                ];
            }
        }
        usort($tabla, function($a, $b) {
            return $b['presencias'] - $a['presencias'];
        });    

        return $this->render('persona3/conductores.html.twig', [
            'conductores' => $persona3Repository->findConductores(),
            'tabla' => $tabla
        ]);
    }

    #[Route('/columnistas', name: 'app_columnistas_index', methods: ['GET'])] 
    public function columnistas(Persona3Repository $persona3Repository): Response   {
        return $this->render('persona3/columnistas.html.twig', [
            'columnistas' => $persona3Repository->findColumnistas(),
        ]);
    }

    #[Route('/columnas/{id}', name: 'app_columnas_index', methods: ['GET'])] 
    public function columnas(Persona3Repository $persona3Repository): Response   {
        return $this->render('persona3/columnas.html.twig', [
            'columnistas' => $persona3Repository->findColumnistas(),
        ]);
    }
}