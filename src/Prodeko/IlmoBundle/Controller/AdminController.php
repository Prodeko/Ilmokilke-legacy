<?php 
namespace Prodeko\IlmoBundle\Controller;


use Prodeko\IlmoBundle\Form\Type\RegistrationType;
use Prodeko\IlmoBundle\Form\Type\EventType;

use Prodeko\IlmoBundle\Entity\Event;

use Prodeko\IlmoBundle\Entity\Registration;

use Symfony\Component\HttpFoundation\Request;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Prodeko\IlmoBundle\Controller\IlmoController;

use Symfony\Component\HttpFoundation\Response;

class AdminController extends IlmoController
{
	
	// Näyttää lomakkeen jolla luodaan tapahtuma
	public function createEventFormAction($id, Request $request) 
	{
	
		if ($id != 0) {
			$event = $this->getDoctrine()
			->getRepository('ProdekoIlmoBundle:Event')
			->findOneBy(array('id' => $id));	
		}
		else {
			$event = new Event();
		}
		//Tee ilmoittautumislomake, määrittely löytyy Prodeko\IlmoBundle\Form\Type\EventType
		$form = $this->createForm(new EventType(), $event);
		
		if ($request->getMethod() == 'POST') {	
			//Jos kyseessä on lähetetyn lomakkeen käsittely, anna lomakkeesta tulleet arvot eventille
			$form->bindRequest($request);
			$event = $form->getData();
			//Tallenna tapahtuma
			$em = $this->getDoctrine()->getEntityManager();
			$em->persist($event);
			$em->flush();
			//Ohjaa tarkastelemaan luotua tapahtumaa
			return $this->redirect($this->generateUrl("show", array('id' => $event->getId())));
		}
		
		
		return $this->render('ProdekoIlmoBundle:Ilmo:createEvent.html.twig', array(
				'form' => $form->createView(), 'id' => $id
		));
	}
	
	
	public function createEventAction(Request $r)
	{
		$form = $this->createForm(new EventType(), new Event());
		
		
		return $this->redirect($this->generateUrl("show", array('id' => $event->getId())));

	}
}
?>
