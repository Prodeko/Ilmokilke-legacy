<?php 
namespace Prodeko\IlmoBundle\Controller;


use Prodeko\IlmoBundle\Form\Type\RegistrationType;

use Prodeko\IlmoBundle\Entity\Event;

use Prodeko\IlmoBundle\Entity\Registration;

use Symfony\Component\HttpFoundation\Request;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Response;

class IlmoController extends Controller
{
	//listaa kaikki tapahtumat
	public function listAction()
	{
		//TODO: implement list controller
		$repository = $this->getDoctrine()->getRepository('ProdekoIlmoBundle:Event');
		$events = $repository->findAll();
		
		return $this->render('ProdekoIlmoBundle:Ilmo:eventlist.html.twig', array('list' => $events));
	}
	
	//Näyttää yhden tapahtuman tiedot
	public function showAction($id, Request $request)
	{
		//TODO: implement "show event details"-controller
		$event = $this->getDoctrine()
			->getRepository('ProdekoIlmoBundle:Event')
			->findOneBy(array('id' => $id));
		$registrations = $this->getDoctrine()
			->getRepository('ProdekoIlmoBundle:Registration')
			->findBy(array('id' => $id));
		$registration = new Registration();
		$form = $this->createForm(new RegistrationType(), $registration);
		
		if ($request->getMethod() == 'POST') {
			$form->bindRequest($request);
			if ($form->isValid()) {
				$registration = $form->getData();
				$time = new \DateTime();
				$registration->setRegistrationTime($time);
				$em = $this->getDoctrine()->getEntityManager();
				$em->persist($registration);
				$em->flush();
			
				return $this->redirect($this->generateUrl('show', array('id' => '1')));
			}
		}
		
		$variables = array(
				'event' => $event,
				'registrations' => $registrations,
				'form' => $form->createView(),
				'id' => $id
				);
		
		return $this->render('ProdekoIlmoBundle:Ilmo:event.html.twig', $variables);
	}
	
	// Näyttää lomakkeen jolla luodaan tapahtuma
	public function createEventFormAction() 
	{
		$event = new Event();
		$form = $this->createFormBuilder($event)
		->add('name', 'text')
		->add('summary', 'textarea')
		->add('description', 'textarea')
		->add('takes_place', "datetime")
		->add('registration_starts', "datetime")
		->add('registration_ends', "datetime")
		->add('location', "text")
		->getForm();
		
		return $this->render('ProdekoIlmoBundle:Ilmo:createEvent.html.twig', array(
				'form' => $form->createView(),
		));
	}
	
	
	public function createEventAction(Request $r)
	{
		$event = new Event();
		$form = $this->createFormBuilder($event)
		->add('name', 'text')
		->add('summary', 'textarea')
		->add('description', 'textarea')
		->add('takes_place', "datetime")
		->add('registration_starts', "datetime")
		->add('registration_ends', "datetime")
		->add('location', "text")
		->getForm();
        $form->bindRequest($r);
		$registration = $form->getData();
		
		$em = $this->getDoctrine()->getEntityManager();
		$em->persist($event);
		$em->flush();
		
		return $this->redirect($this->generateUrl("show", array('id' => $event->getId())));


	}

	
	
	public function createRegistrationAction(Request $request)
	{
		$registration = new Registration();
		$form = $this->createForm(new RegistrationType(), $registration);
		$form->bindRequest($request);
		if ($form->isValid()) {
			$registration = $form->getData();
			$time = new \DateTime();
			$registration->setRegistrationTime($time);
			$em = $this->getDoctrine()->getEntityManager();
			$em->persist($registration);
			$em->flush();
		
			return $this->redirect($this->generateUrl('show', array('id' => '1')));
		}
	
	}
}
?>
