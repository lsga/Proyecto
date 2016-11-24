<?php

namespace AppBundle\Controller;
use AppBundle\Entity\Partidos;
use AppBundle\Entity\Equipos;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class PartidosController extends Controller
{
  /**
   * @Route("/partidos", name="Partidos")
   */
  public function listAction()
  {
    $partido = $this->getDoctrine()
      ->getRepository('AppBundle:Partidos')
      ->FindAll();
    return $this->render('partidos/index.html.twig', array(
      'partidos' => $partido
    ));
  }

  /**
   * @Route("/partidos/crear", name="Partidos_Crear")
   */
  public function CrearAction(Request $request)
  {
    $partido = new Partidos;

    $form = $this->createFormBuilder($partido)
      ->add('Equipo1', EntityType::class, array('class' => 'AppBundle:Equipos', 'choice_label' => 'Nombre'))
      ->add('Equipo2', EntityType::class, array('class' => 'AppBundle:Equipos', 'choice_label' => 'Nombre'))
      ->add('Guardar', SubmitType::class, array('label' => 'Crear Partido','attr' => array('class'=>'btn btn-primary','style'=>'margin-bottom:15px')))
      ->getForm();

      $form->handleRequest($request);

      if($form->isSubmitted() && $form->isValid()){
          $eq1 = $form['Equipo1']->getData();
          $eq2 = $form['Equipo2']->getData();

          $partido->setEquipo1($eq1);
          $partido->setEquipo2($eq2);

          $em = $this->getDoctrine()->getManager();
          $em->persist($partido);
          $em->flush();

           $this->addFlash(
            'notice',
            'Partido Creado'
          );
        return $this->redirectToRoute('Partidos');
      }
      return $this->render('partidos/crear.html.twig', array(
        'form' => $form->createView()
      ));
  }

  /**
   * @Route("/canchas/editar/{id}", name="Canchas_Editar")
   */


  /**
   * @Route("/canchas/detalle/{id}", name="Canchas_Detalle")
   */


  /**
   * @Route("/canchas/eliminar/{id}", name="Canchas_Eliminar")
   */

}
