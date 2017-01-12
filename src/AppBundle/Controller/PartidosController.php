<?php

namespace AppBundle\Controller;
use AppBundle\Entity\Partidos;
use AppBundle\Entity\Equipos;
use AppBundle\Entity\Canchas;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Doctrine\DBAL\DriverManager;
use Symfony\Doctrine\DBAL\Connection;

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
    //$em = Doctrine_Manager::getInstance()->connection();
    $partido = new Partidos;
    //$sql = $this->getDoctrine()->getManager()->getConnection()->prepare("insert into partidos (Equipo1,Equipo2,Cancha) values ("+ $eq1  ,  $eq2 , + "(Select Nombre from canchas order by RAND() LIMIT 1))");
    //$sql->execute();
    //$sql = ("select Nombre from canchas order by RAND() limit 1");
    /*$repository = $this->getDoctrine()->getRepository('AppBundle:Canchas');
    $sql = $repository->createQueryBuilder('c')
        ->select('c.Nombre')
        ->orderBy('RAND()')
        ->getQuery();
    $cancha = $sql->setMaxResults(1);*/
    $form = $this->createFormBuilder($partido)
      //->add('Equipo1', EntityType::class, array('class' => 'AppBundle:Equipos', 'placeholder' => 'Seleccione un Equipo','choice_label' => 'Nombre', 'choice_value' => 'Nombre', 'error_bubbling' => 'true', 'translation_domain' => 'AppBundle', 'choice_translation_domain' => 'true'))
      //->add('Equipo2', EntityType::class, array('class' => 'AppBundle:Equipos', 'placeholder' => 'Seleccione un Equipo','choice_label' => 'Nombre', 'choice_value' => 'Nombre', 'error_bubbling' => 'true', 'translation_domain' => 'AppBundle', 'choice_translation_domain' => 'true'))
      ->add('Equipo1', TextType::class, array('attr' => array('class'=>'form-control','style'=>'margin-bottom:15px')))
      ->add('Equipo2', TextType::class, array('attr' => array('class'=>'form-control','style'=>'margin-bottom:15px')))
      ->add('Guardar', SubmitType::class, array('label' => 'Crear Partido','attr' => array('class'=>'btn btn-primary','style'=>'margin-bottom:15px')))
      ->getForm();

      $form->handleRequest($request);

      if($form->isSubmitted() && $form->isValid()){
          $eq1 = $form['Equipo1']->getData();
          $eq2 = $form['Equipo2']->getData();
          $sql = $this->getDoctrine()->getManager()->getConnection()->prepare("insert into partidos (Equipo1,Equipo2,Cancha,ModuloHora) values ('" . $eq1 . "','" . $eq2 . "'," . "(Select Nombre from canchas order by RAND() LIMIT 1)" . "," . RAND(1,8) . ")");
          $sql->execute();


          //$cancha = $sql->getData();

          //$partido->setEquipo1($eq1);
          //$partido->setEquipo2($eq2);
          //$partido->setCancha($cancha);

          $em = $this->getDoctrine()->getManager();
          $em->persist($sql);
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
   * @Route("/partidos/editar/{id}", name="Partidos_Editar")
   */
   public function EditarAction($id, Request $request)
   {
     $partido = $this->getDoctrine()
       ->getRepository('AppBundle:Partidos')
       ->Find($id);

      $partido->setEquipo1($partido->getEquipo1());
      $partido->setEquipo2($partido->getEquipo2());

     $form = $this->createFormBuilder($partido)
       //->add('Equipo1', EntityType::class, array('class' => 'AppBundle:Equipos', 'choice_label' => 'Nombre', 'choice_value' => 'Nombre', 'choice_translation_domain' => 'true'))
       //->add('Equipo2', EntityType::class, array('class' => 'AppBundle:Equipos', 'choice_label' => 'Nombre', 'choice_value' => 'Nombre', 'choice_translation_domain' => 'true'))
       ->add('Equipo1', TextType::class, array('attr' => array('class'=>'form-control','style'=>'margin-bottom:15px')))
       ->add('Equipo2', TextType::class, array('attr' => array('class'=>'form-control','style'=>'margin-bottom:15px')))
       ->add('Guardar', SubmitType::class, array('label' => 'Editar Partido','attr' => array('class'=>'btn btn-primary','style'=>'margin-bottom:15px')))
       ->getForm();

       $form->handleRequest($request);

       if($form->isSubmitted() && $form->isValid()){
           $eq1 = $form['Equipo1']->getData();
           $eq2 = $form['Equipo2']->getData();

           $em = $this->getDoctrine()->getManager();
           $partido = $em->getRepository('AppBundle:Partidos')->find($id);

           $partido->setEquipo1($eq1);
           $partido->setEquipo2($eq2);

           $em->flush();

            $this->addFlash(
             'notice',
             'Partido Actualizado'
           );
         return $this->redirectToRoute('Partidos');
       }
       return $this->render('partidos/editar.html.twig', array(
         'partido' => $partido,
         'form' => $form->createView()
       ));
   }

  /**
   * @Route("/partidos/detalle/{id}", name="Partidos_Detalle")
   */
   public function DetalleAction($id)
   {
     $partido = $this->getDoctrine()
       ->getRepository('AppBundle:Partidos')
       ->Find($id);
     return $this->render('partidos/detalle.html.twig', array(
       'partido' => $partido
     ));
   }

  /**
   * @Route("/partidos/eliminar/{id}", name="Partidos_Eliminar")
   */
   public function EliminarAction($id)
   {
     $em = $this->getDoctrine()->getManager();
     $partido = $em->getRepository('AppBundle:Partidos')->find($id);

     $em->remove($partido);
     $em->flush();

     $this->addFlash(
       'notice',
       'Partido Eliminado'
     );

     return $this->redirectToRoute('Partidos');
   }
}
