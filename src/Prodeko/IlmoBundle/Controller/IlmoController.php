<?php 
namespace Prodeko\IlmoBundle\Controller;


use Prodeko\IlmoBundle\Entity\FreeTextEntry;

use Prodeko\IlmoBundle\Form\Type\RegistrationType;

use Prodeko\IlmoBundle\Entity\Event;

use Prodeko\IlmoBundle\Entity\Registration;

use Prodeko\IlmoBundle\Helpers\Helpers;

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
		$now = new \DateTime();
		
		//Listaa tapahtumat, joiden ilmo on tulevaisuudessa
		$query = $repository->createQueryBuilder('e')
   			->where('e.registrationStarts > :now')
	    	->setParameter('now', $now)
	    	->orderBy('e.registrationStarts', 'ASC')
	    	->getQuery();

		$upcomingEvents = $query->getResult();
		
		//Listaa tapahtumat, joiden ilmo on käynnissä
		$query = $repository->createQueryBuilder('e')
			->where('e.registrationStarts < :now')
			->andWhere('e.registrationEnds > :now')
			->setParameter('now', $now)
			->orderBy('e.takesPlace', 'ASC')
			->getQuery();
		$activeEvents = $query->getResult();
		
		
		//Listaa tapahtumia, joiden ilmo on jo sulkeutunut
		$query = $repository->createQueryBuilder('e')
			->where('e.registrationEnds < :now')
			->andWhere('e.takesPlace > :now')
			->setParameter('now', $now)
			->getQuery();
		$pastEvents = $query->getResult();
		
		return $this->render('ProdekoIlmoBundle:Ilmo:eventlist.html.twig',
				array('activeEvents' => $activeEvents,
					  'upcomingEvents' => $upcomingEvents,
					  'pastEvents' => $pastEvents)
				);
	}
	
	//Näyttää yhden tapahtuman tiedot
	public function showAction($id, Request $request)
	{
		//Hae tapahtuma URI:sta tulleen id:n perusteella
		$event = $this->getDoctrine()
			->getRepository('ProdekoIlmoBundle:Event')
			->findOneBy(array('id' => $id));
		$eventIsOpen = $event->isOpen();
		$registrations = array();
		$queue = array();
		
		//Hae kiintiöittäin ilmoittautumiset
		$registrationStruct = Helpers::getRegistrationsByQuota($event, 
				$this->getDoctrine()->getRepository('ProdekoIlmoBundle:Registration'));
		$registrations = $registrationStruct['registrations'];
		$queue = $registrationStruct['queue'];
		
		$quotas = $event->getQuotas();
		
		usort($queue, array('\Prodeko\IlmoBundle\Entity\Registration', 'compareByRegistrationTime'));
		//Luo uusi ilmoittautumisolio ja liitä sille kyseinen tapahtuma
		$registration = new Registration();
		$registration->setEvent($event);
		//Hae tapahtuman vapaatekstikentät
		$freeTextFields = $event->getFreeTextFields();
		$fieldNames = array();
		foreach ($freeTextFields as $freeTextField) {
			//Lisää entry-olio jokaiselle vapaatekstikentälle
			$entry = new FreeTextEntry();
			$entry->setField($freeTextField);
			$freeTextField->addFreeTextEntry($entry);
			$entry->setRegistration($registration);
			$registration->addFreeTextEntry($entry);
			$fieldNames[] = $freeTextField->getName();
		}
		
		//Hae tapahtuman kiintiöiden nimet
		
		$quotaNames = array();
		foreach ($quotas as $quota) {
			$quotaNames[] = $quota->getName();
		}
		
		//Tee ilmoittautumislomake, määrittely löytyy Prodeko\IlmoBundle\Form\Type\RegistrationType
		$form = $this->createForm(new RegistrationType($event), $registration);
		
		//Jos sivu on haettu POSTilla, on kyseessä ilmoittautumisen käsittely
		if ($request->getMethod() == 'POST') {
			$form->bindRequest($request);
			//Tarkasta lomake, isValid näyttää automaattisesti errorit, jos niitä on. Älä myöskään tallenna ilmoittautumista, jos ilmo ei ole auki.
			if ($form->isValid() && $eventIsOpen) {
				//Lisää lomakkeelta tulleet tiedot registration-olioon
				$registration = $form->getData();
				$time = new \DateTime();
				$registration->setRegistrationTime($time);
				//Tallenna ilmoittautuminen tietokantaan ja ohjaa takaisin sivulle
				//TODO: Joku 'ilmoittautuminen onnistunut' -viesti, ajaxilla? parametri urlissa?
				$em = $this->getDoctrine()->getEntityManager();
				$em->persist($registration);
				$em->flush();
			
				return $this->redirect($this->generateUrl('show', array('id' => $id)));
			}
		}
		//Anna templatelle muuttujat 
		$variables = array(
				'event' => $event,
				'registrations' => $registrations,
				'queue' => $queue,
				'form' => $form->createView(),
				'id' => $id,
				'isOpen' => $eventIsOpen,
				'fieldNames' => $fieldNames,
				'quotaNames' => $quotaNames
				);
		
		return $this->render('ProdekoIlmoBundle:Ilmo:event.html.twig', $variables);
	}
	
	public function removeRegistrationAction($id, Request $request) 
	{
		//Poistaa ilmoittautumisen annetulla id:llä. Tähän pitää tehdä varmennussysteemit.
		$em = $this->getDoctrine()->getEntityManager();
		$registration = $this->getDoctrine()
			->getRepository('ProdekoIlmoBundle:Registration')
			->findOneBy(array('id' => $id));
		if (!$registration) {
			//Heitä etusivulle, jos ilmoittautumista ei löydy
			return $this->redirect($this->generateUrl("list"));
		}
		$event = $registration->getEvent();
		$freeTextEntries = $registration->getFreeTextEntries();
		$em->remove($registration);
		foreach ($freeTextEntries as $freeTextEntry) {
			$em->remove($freeTextEntry);
		}
		$em->flush();
		//Ohjaa tarkastelemaan tapahtumaa
		//TODO: Ohjaa takaisin adminin ilmoittautumiset - näkymään, jos pyyntö tullut sieltä.
		return $this->redirect($this->generateUrl("show", array('id' => $event->getId())));
	}

}
?>
