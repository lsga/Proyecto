<?php

namespace AppBundle\Controller;
use AppBundle\Entity\Usuarios;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class UsuariosController extends Controller
{
  /**
   * @Route("/usuarios", name="Usuarios")
   */
  public function listAction()
  {
    $us = $this->getDoctrine()
      ->getRepository('AppBundle:Usuarios')
      ->FindAll();
    return $this->render('usuarios/index.html.twig', array(
      'usuarios' => $us
    ));
  }

  /**
   * @Route("/usuarios/crear", name="Usuarios_Crear")
   */
  public function CrearAction(Request $request)
  {
    $us = new Usuarios;

    $form = $this->createFormBuilder($us)
      ->add('Nombre', TextType::class, array('attr' => array('class'=>'form-control','style'=>'margin-bottom:15px')))
      ->add('Apellido', TextType::class, array('attr' => array('class'=>'form-control','style'=>'margin-bottom:15px')))
      ->add('User', TextType::class, array('attr' => array('class'=>'form-control','style'=>'margin-bottom:15px')))
      ->add('Password', PasswordType::class, array('attr' => array('class'=>'form-control','style'=>'margin-bottom:15px')))
      ->add('Guardar', SubmitType::class, array('label' => 'Crear Usuario','attr' => array('class'=>'btn btn-primary','style'=>'margin-bottom:15px')))
      ->getForm();

      $form->handleRequest($request);

      if($form->isSubmitted() && $form->isValid()){
          $nom = $form['Nombre']->getData();
          $ape = $form['Apellido']->getData();
          $use = $form['User']->getData();
          $pas = $form['Password']->getData();

          $us->setNombre($nom);
          $us->setApellido($ape);
          $us->setUser($use);
          $us->setPassword($pas);

          $em = $this->getDoctrine()->getManager();
          $em->persist($us);
          $em->flush();

           $this->addFlash(
            'notice',
            'Usuario Creado'
          );
        return $this->redirectToRoute('Usuarios');
      }
      return $this->render('usuarios/crear.html.twig', array(
        'form' => $form->createView()
      ));
  }

  /**
   * @Route("/usuarios/editar/{id}", name="Usuarios_Editar")
   */
  public function EditarAction($id, Request $request)
  {
    $us = $this->getDoctrine()
      ->getRepository('AppBundle:Usuarios')
      ->Find($id);

      $us->setNombre($us->getNombre());
      $us->setApellido($us->getApellido());
      $us->setUser($us->getUser());
      $us->setPassword($us->getPassword());

      $form = $this->createFormBuilder($us)
      ->add('Nombre', TextType::class, array('attr' => array('class'=>'form-control','style'=>'margin-bottom:15px')))
      ->add('Apellido', TextType::class, array('attr' => array('class'=>'form-control','style'=>'margin-bottom:15px')))
      ->add('User', TextType::class, array('attr' => array('class'=>'form-control','style'=>'margin-bottom:15px')))
      ->add('Password', PasswordType::class, array('attr' => array('class'=>'form-control','style'=>'margin-bottom:15px')))
      ->add('Guardar', SubmitType::class, array('label' => 'Actualizar Usuario','attr' => array('class'=>'btn btn-primary','style'=>'margin-bottom:15px')))
      ->getForm();

      $form->handleRequest($request);

      if ($form->isSubmitted() && $form->isValid()) {
        // Get Datos
        $nom = $form['Nombre']->getData();
        $ape = $form['Apellido']->getData();
        $use = $form['User']->getData();
        $pas = $form['Password']->getData();

        $em = $this->getDoctrine()->getManager();
        $us = $em->getRepository('AppBundle:Usuarios')->find($id);

        $us->setNombre($nom);
        $us->setApellido($ape);
        $us->setUser($use);
        $us->setPassword($pas);

        $em->flush();

        $this->addFlash(
          'Notice',
          'Usuario Actualizado'
        );

        return $this->redirectToRoute('Usuarios');
      }

    return $this->render('usuarios/editar.html.twig', array(
      'usuario' => $us,
      'form' => $form->createView()
    ));
  }

  /**
   * @Route("/usuarios/listar/{id}", name="Usuarios_Lista")
   */
  public function DetalleAction($id)
  {
      return $this->render('usuarios/lista.html.twig');
  }

  /**
   * @Route("/usuarios/eliminar/{id}", name="Usuarios_Eliminar")
   */
  public function EliminarAction($id)
  {
    $em = $this->getDoctrine()->getManager();
    $us = $em->getRepository('AppBundle:Usuarios')->find($id);

    $em->remove($us);
    $em->flush();

    $this->addFlash(
      'notice',
      'Usuario Eliminado'
    );

    return $this->redirectToRoute('Usuarios');
  }
}
