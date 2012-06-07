<?php 
namespace Prodeko\IlmoBundle\Controller;


use Prodeko\IlmoBundle\Entity\Quota;

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
			$quota_names = array('I','II','III','IV','N');
			
			for($i=1;$i<=5;$i++) {
				$quota = new Quota();
				$quota->setYearOfStudiesValue($i);
				$quota->setName($quota_names[$i-1]);
				$quota->setEvent($event);
				$event->addQuota($quota);
			}
			
				
			
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
	
	public function adminRegistrationsAction($id, Request $request) // Täydellinen lista ilmoittautuneista admineille
	{
		$event = $this->getDoctrine()
			->getRepository('ProdekoIlmoBundle:Event')
			->findOneBy(array('id' => $id));
		
		$registrations = $event->getRegistrations();
		$freeTextFields = $event->getFreeTextFields();
		
		return $this->render('ProdekoIlmoBundle:Ilmo:adminRegistrations.html.twig', array(
				'event' => $event,
				'registrations' => $registrations,
				'freeTextFields' => $freeTextFields,
				'isOpen' => $event->isOpen()
		));
		
	}
	
	
	
	
	
	
	
	
	public function createEventAction(Request $r)  //Tämän voinee jo poistaa???
	{
		$form = $this->createForm(new EventType(), new Event());
		
		
		return $this->redirect($this->generateUrl("show", array('id' => $event->getId())));

	}
}
?>
