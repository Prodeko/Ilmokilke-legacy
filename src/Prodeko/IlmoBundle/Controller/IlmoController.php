<?php 
namespace Prodeko\IlmoBundle\Controller;

use Prodeko\IlmoBundle\Entity\Event;

use Symfony\Component\HttpFoundation\Request;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Response;

class IlmoController extends Controller
{
	//listaa kaikki tapahtumat
	public function listAction()
	{
		//TODO: implement list controller
		return new Response("Homo");
	}
	
	//Näyttää yhden tapahtuman tiedot
	public function showAction($tapahtuma)
	{
		//TODO: implement "show event details"-controller
		return $this->render('ProdekoIlmoBundle:Ilmo:event.html.twig', array('event' => $tapahtuma));
	}
	
	// Näyttää lomakkeen jolla luodaan tapahtuma
	public function createEventFormAction($tapahtuma) 
	{
		$form = $this->createFormBuilder($task)
		->add('name', 'text')
		->add('summary', 'textarea')
		->add('description', 'textarea')
		->getForm();
		
		return $this->render('ProdekoIlmoBundle:Ilmo:createEvent.html.twig', array(
				'form' => $form->createView(),
		));
	}
	
	
	public function createEventAction(Request $r)
	{
		$post_params = $r->request;
		$name = $post_params->get("name");
		$summary = $post_params->get("summary");
		$description = $post_params->get("description");
		$event = new Event();
		
		$event->setName($name);
		$event->setSummary($summary);
		$event->setDescription($description);
		
		$em = $this->getDoctrine()->getEntityManager();
		$em->persist($event);
		$em->flush();
		
		return $this->render('ProdekoIlmoBundle:Ilmo:event.html.twig', array('event' => $event->$getId()));
	}
}
