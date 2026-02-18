<?php

namespace App\Controller;

use App\Entity\Socio;
use App\Form\SocioType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SocioController extends AbstractController
{
    #[Route('/socio/alta', name: 'socio_alta')]
    public function alta(Request $request): Response
    {
        $socio = new Socio();
        $form = $this->createForm(SocioType::class, $socio);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Aquí iría la lógica para guardar el socio en la base de datos
            // y enviar notificaciones, etc.
            $this->addFlash('success', 'Socio registrado correctamente.');
            return $this->redirectToRoute('socio_alta');
        }

        return $this->render('socio/alta.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
