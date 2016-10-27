<?php

namespace AppBundle\Controller;
use AppBundle\Entity\Categoria;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class CategoriaController extends Controller
{
  /**
   * @Route("/categorias", name="Categorias")
   */
  public function listAction()
  {
    $categoria = $this->getDoctrine()
      ->getRepository('AppBundle:Categoria')
      ->FindAll();
    return $this->render('categoria/index.html.twig', array(
      'categorias' => $categoria
    ));
  }

  /**
   * @Route("/categorias/crear", name="Categorias_Crear")
   */
  public function CrearAction(Request $request)
  {
    $categoria = new Categoria;

    $form = $this->createFormBuilder($categoria)
      ->add('Nombre', TextType::class, array('attr' => array('class'=>'form-control','style'=>'margin-bottom:15px')))
      ->add('Descripcion', TextareaType::class, array('attr' => array('class'=>'form-control','style'=>'margin-bottom:15px')))
      ->add('Guardar', SubmitType::class, array('label' => 'Crear Categoria','attr' => array('class'=>'btn btn-primary','style'=>'margin-bottom:15px')))
      ->getForm();

      $form->handleRequest($request);

      if($form->isSubmitted() && $form->isValid()){
          $nom = $form['Nombre']->getData();
          $desc = $form['Descripcion']->getData();

          $categoria->setNombre($nom);
          $categoria->setDescripcion($desc);

          $em = $this->getDoctrine()->getManager();
          $em->persist($categoria);
          $em->flush();

           $this->addFlash(
            'notice',
            'Categoria Creada'
          );
        return $this->redirectToRoute('Categorias');
      }
      return $this->render('categoria/crear.html.twig', array(
        'form' => $form->createView()
      ));
  }

  /**
   * @Route("/categorias/editar/{id}", name="Categorias_Editar")
   */
  public function EditarAction($id, Request $request)
  {
    $categoria = $this->getDoctrine()
      ->getRepository('AppBundle:Categoria')
      ->Find($id);

      $categoria->setNombre($categoria->getNombre());
      $categoria->setDescripcion($categoria->getDescripcion());

      $form = $this->createFormBuilder($categoria)
      ->add('Nombre', TextType::class, array('attr' => array('class'=>'form-control','style'=>'margin-bottom:15px')))
      ->add('Descripcion', TextareaType::class, array('attr' => array('class'=>'form-control','style'=>'margin-bottom:15px')))
      ->add('Guardar', SubmitType::class, array('label' => 'Actualizar Categoria','attr' => array('class'=>'btn btn-primary','style'=>'margin-bottom:15px')))
      ->getForm();

      $form->handleRequest($request);

      if ($form->isSubmitted() && $form->isValid()) {
        // Get Datos
        $nom = $form['Nombre']->getData();
        $desc = $form['Descripcion']->getData();

        $em = $this->getDoctrine()->getManager();
        $categoria = $em->getRepository('AppBundle:Categoria')->find($id);

        $categoria->setNombre($nom);
        $categoria->setDescripcion($desc);

        $em->flush();

        $this->addFlash(
          'Notice',
          'Categoria Actualizada'
        );

        return $this->redirectToRoute('Categorias');
      }

    return $this->render('categoria/editar.html.twig', array(
      'categoria' => $categoria,
      'form' => $form->createView()
    ));
  }

  /**
   * @Route("/categorias/detalle/{id}", name="Categorias_Detalle")
   */
  public function DetalleAction($id)
  {
    $categoria = $this->getDoctrine()
      ->getRepository('AppBundle:Categoria')
      ->Find($id);
    return $this->render('categoria/detalle.html.twig', array(
      'categoria' => $categoria
    ));
  }

  /**
   * @Route("/categorias/eliminar/{id}", name="Categorias_Eliminar")
   */
  public function EliminarAction($id)
  {
    $em = $this->getDoctrine()->getManager();
    $categoria = $em->getRepository('AppBundle:Categoria')->find($id);

    $em->remove($categoria);
    $em->flush();

    $this->addFlash(
      'notice',
      'Categoria Eliminada'
    );

    return $this->redirectToRoute('Categorias');
  }
}
