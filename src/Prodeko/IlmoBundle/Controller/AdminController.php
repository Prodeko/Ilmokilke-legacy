<?php 
namespace Prodeko\IlmoBundle\Controller;


use Prodeko\IlmoBundle\Entity\MultipleChoiceField;

use Prodeko\IlmoBundle\Entity\FreeTextEntry;

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
		// $state-muuttujan arvot siis: 1=Uuden tapahtuman luonti, 2=Tapahtuman muokkaus, ei vielä ilmoittautuneita, 3=Tapahtuman muokkaus, ilmoittautumisia jo tullut.
		if ($id != 0) {
			$event = $this->getDoctrine()
			->getRepository('ProdekoIlmoBundle:Event')
			->findOneBy(array('id' => $id));
			if ($event) {
				$registrations = $event->getRegistrations();
				if ($registrations && count($registrations) > 0) {
					$state = 3; // Sellaisen tapahtuman muokkaus, jolla on ilmoittautumisia.
				} else {
					$state = 2; // Muokkaus, ei ilmoittautumisia.
				}
			} else {
				echo "Ei löydy tapahtumaa!"; die; //TODO: Tähän ehkä joku exception handling
			}
		}
		else {
			$state = 1; // Uuden tapahtuman luonti.
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
		$mcField = new MultipleChoiceField();
		$event->addMultipleChoiceField($mcField);
		
		
		//Tee ilmoittautumislomake, määrittely löytyy Prodeko\IlmoBundle\Form\Type\EventType
		$form = $this->createForm(new EventType(), $event);
		
		//Jos kyseessä on lomakkeen käsittely, eikä lomakkeen näyttö
		if ($request->getMethod() == 'POST') {
			
			$em = $this->getDoctrine()->getEntityManager();
			
			if ($state == 3) { // Eli jos muokataan tapahtumaa, jossa on ilmoittautumisia
				$originalFields = Array();
				// Tallenna alkuperäiset kentät ennen kuin formista tuleet tiedot luetaan event-muuttujaan
				foreach ($event->getFreeTextFields() as $field) $originalFields[] = $field;
			}
			
			
			//TODO: if ($form->isValid()) { ... } Jutut tähän väliin.
			
			//Anna lomakkeesta tulleet arvot eventille
			$form->bindRequest($request);
			$event = $form->getData();
			
			
			if ($state == 3) { // Aloita kenttien lisäyksen ja poiston käsittely
							   // Tämä on relevanttia vain jos muokataan tapahtumaa, jolla on ilmoittautumisia.
				$newFields = Array();
				$deletedFields = $originalFields;
				foreach ($event->getFreeTextFields() as $key => $field) {
					//Fieldillä on id <=> se on tallennettu tietokantaan <=> Se on pysynyt olemassaolevana.
					if ($field->getId()) {
						foreach ($deletedFields as $toDel) {
							//Etsii sen kentän alkuperäisten listasta, jota uusi kenttä vastaa.
							if ($toDel->getId() === $field->getId()) {
								//Poista kenttä deletedFields-listasta.
								unset($deletedFields[$key]);
							}
						}
					} else {
						//Jos fieldillä ei ole idiä, sen on oltava uusi.
						$newFields[] = $field;
					}
				}
				
				// Lisää jokaiselle uudelle kentälle ilmoitukset kaikkiin olemassaoleviin ilmoittautumisiin, että kenttää ei ole täytetty.
				foreach ($newFields as $newField) {
					foreach ($registrations as $registration) {
						// Luo entry, anna sille ominaisuudet ja tallenna se
						$entry = new FreeTextEntry();
						$entry->setContent('###ERROR###'); // Tai jotain...
						$entry->setField($newField);
						$entry->setRegistration($registration);
						$em->persist($entry);
					}
				}
				
				// Poista kaikkien poistuneiden fieldien entryt (ei poista fieldejä, koska fieldien kierrätys)
				foreach ($deletedFields as $toDel) {
					$toDelId = $toDel->getId();
					// Etsi esimmäiseltä ilmoittautuneelta se entry, joka vastaa poistettavaa kenttää
					foreach ($registrations[0]->getFreeTextEntries() as $key => $entry) {
						if ($entry->getField()->getId() === $toDelId) {
							// Kun kenttä löytyy, tallenna sen avain ja lopeta etsiminen.
							$delKey = $key;
							break;
						}	
					}
					// Poista jokaiselta ilmoittautuneelta kyseinen entry.
					foreach ($registrations as $registration) {
						$entries = $registration->getFreeTextEntries();
						$em->remove($entries[$delKey]);
					}
				}
			} // Lopeta kenttien lisäyksen ja poiston käsittely
			
			//Tallenna tapahtuma
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
