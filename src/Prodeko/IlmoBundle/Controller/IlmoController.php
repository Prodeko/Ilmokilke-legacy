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
		$now = new \DateTime();
		
		//Listaa tapahtumat, joiden ilmo on tulevaisuudessa
		$query = $repository->createQueryBuilder('e')
   			->where('e.registrationStarts > :now')
	    	->setParameter('now', $now)
	    	->getQuery();

		$upcomingEvents = $query->getResult();
		
		//Listaa tapahtumat, joiden ilmo on k�ynniss�
		$query = $repository->createQueryBuilder('e')
			->where('e.registrationStarts < :now')
			->andWhere('e.registrationEnds > :now')
			->setParameter('now', $now)
			->getQuery();
		$activeEvents = $query->getResult();
		
		
		//Listaa tapahtumia, joiden ilmo on jo sulkeutunut
		$query = $repository->createQueryBuilder('e')
			->where('e.registrationEnds < :now')
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
		//Hae kyseiseen tapahtumaan liittyvät ilmoittautumiset
		$registrations = $this->getDoctrine()
			->getRepository('ProdekoIlmoBundle:Registration')
			->findBy(array('event' => $id));
		//Luo uusi ilmoittautumisolio ja liitä sille kyseinen tapahtuma
		$registration = new Registration();
		$registration->setEvent($event);
		//Tee ilmoittautumislomake, määrittely löytyy Prodeko\IlmoBundle\Form\Type\RegistrationType
		$form = $this->createForm(new RegistrationType(), $registration);
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
				'form' => $form->createView(),
				'id' => $id,
				'isOpen' => $eventIsOpen
				);
		
		return $this->render('ProdekoIlmoBundle:Ilmo:event.html.twig', $variables);
	}
	
	public function removeRegistrationAction($id, Request $request) 
	{
		//Poistaa ilmoittautumisen annetulla id:llä. Tähän pitää tehdä varmennussysteemit.
		$em = $this->getDoctrine()->getEntityManager();
		$registration = $this->getRepository('ProdekoIlmoBundle:Registration')->find($id);
		$em->remove($registration);
		$em->flush();
	}

}
?>
