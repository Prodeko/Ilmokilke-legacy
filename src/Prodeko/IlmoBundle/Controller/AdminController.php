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
	
	public function adminRegistrationsAction($id, Request $request) // Täydellinen lista ilmoittautuneista admineille
	{
		$event = $this->getDoctrine()
			->getRepository('ProdekoIlmoBundle:Event')
			->findOneBy(array('id' => $id));
		
		$registrations = $event->getRegistrations();
		$freeTextFields = $event->getFreeTextFields();
		foreach ($registrations as $registration) {
			foreach ($registration->getFreeTextEntries() as $entry) {
				$field = $entry->getField();
				$events = $field->getEvents(); //Voisiko tämän tehdä jollain querybuilderilla? Nyt jos on sata ilmoittautunutta, joista jokaisella on viisi entryä, joista jokaisella on field, jolla on vitusti tapahtumia, niin tässä menee joku miljoona vuotta iteroida.
				foreach ($events as $testevent) {
					if ($testevent == $event) {
						$registration->getFreeTextEntries()->removeElement($entry);
					}
				}
			}
		}
		
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
