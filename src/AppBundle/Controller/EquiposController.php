<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Equipos;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class EquiposController extends Controller
{
    /**
     * @Route("/", name="Equipos")
     */
    public function listAction()
    {
        $equipos = $this->getDoctrine()
          ->getRepository('AppBundle:Equipos')
          ->FindAll();

        return $this->render('equipos/index.html.twig', array(
          'equipos' => $equipos
        ));
    }

    /**
     * @Route("/equipos/crear", name="Equipos_Crear")
     */
    public function createAction(Request $request)
    {
        $equipo = new Equipos;

        $form = $this->createFormBuilder($equipo)
          ->add('Nombre', TextType::class, array('attr' => array('class'=>'form-control','style'=>'margin-bottom:15px')))
          ->add('Categoria', ChoiceType::class, array('choices' => array('Senior' => 'Senior', 'Master' => 'Master', 'SuperMaster' => 'SuperMaster'), 'attr' => array('class'=>'form-control','style'=>'margin-bottom:15px')))
          ->add('Guardar', SubmitType::class, array('label' => 'Crear Equipo','attr' => array('class'=>'btn btn-primary','style'=>'margin-bottom:15px')))
          ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
          // Get Datos
          $nombre = $form['Nombre']->getData();
          $categoria = $form['Categoria']->getData();

          $equipo->setNombre($nombre);
          $equipo->setCategoria($categoria);

          $em = $this->getDoctrine()->getManager();

          $em->persist($equipo);
          $em->flush();

          $this->addFlash(
            'Notice',
            'Equipo Ingresado'
          );

          return $this->redirectToRoute('Equipos');
        }
        return $this->render('equipos/crear.html.twig',array(
          'form' => $form->createView()
        ));
    }

    /**
     * @Route("/equipos/editar/{id}", name="Equipos_Editar")
     */
    public function editAction($id, Request $request)
    {
      $equipo = $this->getDoctrine()
        ->getRepository('AppBundle:Equipos')
        ->Find($id);

        $equipo->setNombre($equipo->getNombre());
        $equipo->setCategoria($equipo->getCategoria());

        $form = $this->createFormBuilder($equipo)
          ->add('Nombre', TextType::class, array('attr' => array('class'=>'form-control','style'=>'margin-bottom:15px')))
          ->add('Categoria', ChoiceType::class, array('choices' => array('Senior' => 'Senior', 'Master' => 'Master', 'SuperMaster' => 'SuperMaster'), 'attr' => array('class'=>'form-control','style'=>'margin-bottom:15px')))
          ->add('Guardar', SubmitType::class, array('label' => 'Actualizar Equipo','attr' => array('class'=>'btn btn-primary','style'=>'margin-bottom:15px')))
          ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
          // Get Datos
          $nombre = $form['Nombre']->getData();
          $categoria = $form['Categoria']->getData();

          $em = $this->getDoctrine()->getManager();
          $equipo = $em->getRepository('AppBundle:Equipos')->find($id);

          $equipo->setNombre($nombre);
          $equipo->setCategoria($categoria);

          $em->flush();

          $this->addFlash(
            'Notice',
            'Equipo Actualizado'
          );

          return $this->redirectToRoute('Equipos');
        }

      return $this->render('equipos/editar.html.twig', array(
        'equipo' => $equipo,
        'form' => $form->createView()
      ));
    }

    /**
     * @Route("/equipos/listar/{id}", name="Equipos_lista")
     */
    public function DetalleAction($id)
    {
        return $this->render('equipos/lista.html.twig');
    }
    /**
     * @Route("/equipos/eliminar/{id}", name="Equipos_Eliminar")
     */
    public function EliminarAction($id)
    {
      $em = $this->getDoctrine()->getManager();
      $equipo = $em->getRepository('AppBundle:Equipos')->find($id);

      $em->remove($equipo);
      $em->flush();

      $this->addFlash(
        'notice',
        'Equipo Eliminado'
      );

      return $this->redirectToRoute('Equipos');
    }
}
