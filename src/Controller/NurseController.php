<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/nurse')]

final class NurseController extends AbstractController
{
    // FindByName function
    
    #[Route('/name/{name}', methods: ['GET'], name: 'app_find_by_name')]
    public function findByName(string $name): JsonResponse
    {
        // Ruta al archivo nurses.json
        $jsonFile = $this->getParameter('kernel.project_dir') . '/nurses.json';
        
        // Leer y decodificar el archivo JSON
        $jsonContent = file_get_contents($jsonFile);
        $nurses = json_decode($jsonContent, true);

        // Buscar el enfermero por nombre (Uso del " === " para que busque el nombre exacto)
         $foundNurse = null;
        if (isset($nurses) && is_array($nurses)) {
            foreach ($nurses as $nurse) {
                if ($nurse['name'] === $name) {
                    $foundNurse = $nurse;
                }
            }
        }

        // Devolver resultado
         if ($foundNurse) {
            return $this->json([
                'nurse' => $foundNurse,
                'success' => "Nurse {$name} found!"
            ]);
        }
        return $this->json(['error' => "Nurse not found!"], 404);
    }
}

  

       

    
      
