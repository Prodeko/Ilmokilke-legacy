<?php 
namespace Prodeko\IlmoBundle\Controller;

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
	public function createEventAction($tapahtuma) 
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
	
}
