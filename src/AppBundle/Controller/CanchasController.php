<?php

namespace AppBundle\Controller;
use AppBundle\Entity\Canchas;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class CanchasController extends Controller
{
  /**
   * @Route("/canchas", name="Canchas")
   */
  public function listAction()
  {
    $cancha = $this->getDoctrine()
      ->getRepository('AppBundle:Canchas')
      ->FindAll();
    return $this->render('canchas/index.html.twig', array(
      'canchas' => $cancha
    ));
  }

  /**
   * @Route("/canchas/crear", name="Canchas_Crear")
   */
  public function CrearAction(Request $request)
  {
    $cancha = new Canchas;

    $form = $this->createFormBuilder($cancha)
      ->add('Nombre', TextType::class, array('attr' => array('class'=>'form-control','style'=>'margin-bottom:15px')))
      ->add('Descripcion', TextareaType::class, array('attr' => array('class'=>'form-control','style'=>'margin-bottom:15px')))
      ->add('Ubicacion', TextareaType::class, array('attr' => array('class'=>'form-control','style'=>'margin-bottom:15px')))
      ->add('Guardar', SubmitType::class, array('label' => 'Crear Cancha','attr' => array('class'=>'btn btn-primary','style'=>'margin-bottom:15px')))
      ->getForm();

      $form->handleRequest($request);

      if($form->isSubmitted() && $form->isValid()){
          $nom = $form['Nombre']->getData();
          $desc = $form['Descripcion']->getData();
          $ub = $form['Ubicacion']->getData();

          $cancha->setNombre($nom);
          $cancha->setDescripcion($desc);
          $cancha->setUbicacion($ub);

          $em = $this->getDoctrine()->getManager();
          $em->persist($cancha);
          $em->flush();

           $this->addFlash(
            'notice',
            'Cancha Creada'
          );
        return $this->redirectToRoute('Canchas');
      }
      return $this->render('canchas/crear.html.twig', array(
        'form' => $form->createView()
      ));
  }

  /**
   * @Route("/canchas/editar/{id}", name="Canchas_Editar")
   */
  public function EditarAction($id, Request $request)
  {
    $cancha = $this->getDoctrine()
      ->getRepository('AppBundle:Canchas')
      ->Find($id);

      $cancha->setNombre($cancha->getNombre());
      $cancha->setDescripcion($cancha->getDescripcion());
      $cancha->setUbicacion($cancha->getUbicacion());

      $form = $this->createFormBuilder($cancha)
      ->add('Nombre', TextType::class, array('attr' => array('class'=>'form-control','style'=>'margin-bottom:15px')))
      ->add('Descripcion', TextareaType::class, array('attr' => array('class'=>'form-control','style'=>'margin-bottom:15px')))
      ->add('Ubicacion', TextareaType::class, array('attr' => array('class'=>'form-control','style'=>'margin-bottom:15px')))
      ->add('Guardar', SubmitType::class, array('label' => 'Actualizar Cancha','attr' => array('class'=>'btn btn-primary','style'=>'margin-bottom:15px')))
      ->getForm();

      $form->handleRequest($request);

      if ($form->isSubmitted() && $form->isValid()) {
        // Get Datos
        $nom = $form['Nombre']->getData();
        $desc = $form['Descripcion']->getData();
        $ub = $form['Ubicacion']->getData();

        $em = $this->getDoctrine()->getManager();
        $cancha = $em->getRepository('AppBundle:Canchas')->find($id);

        $cancha->setNombre($nom);
        $cancha->setDescripcion($desc);
        $cancha->setUbicacion($ub);

        $em->flush();

        $this->addFlash(
          'Notice',
          'Cancha Actualizada'
        );

        return $this->redirectToRoute('Canchas');
      }

    return $this->render('canchas/editar.html.twig', array(
      'cancha' => $cancha,
      'form' => $form->createView()
    ));
  }

  /**
   * @Route("/canchas/detalle/{id}", name="Canchas_Detalle")
   */
  public function DetalleAction($id)
  {
    $cancha = $this->getDoctrine()
      ->getRepository('AppBundle:Canchas')
      ->Find($id);
    return $this->render('canchas/detalle.html.twig', array(
      'cancha' => $cancha
    ));
  }

  /**
   * @Route("/canchas/eliminar/{id}", name="Canchas_Eliminar")
   */
  public function EliminarAction($id)
  {
    $em = $this->getDoctrine()->getManager();
    $cancha = $em->getRepository('AppBundle:Canchas')->find($id);

    $em->remove($cancha);
    $em->flush();

    $this->addFlash(
      'notice',
      'Cancha Eliminada'
    );

    return $this->redirectToRoute('Canchas');
  }
}
