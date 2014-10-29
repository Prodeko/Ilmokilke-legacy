<?php 
namespace Prodeko\IlmoBundle\Controller;


use Symfony\Component\HttpKernel\Exception\HttpException;

use Symfony\Component\Config\Definition\Exception\Exception;

use Prodeko\IlmoBundle\Entity\MultipleChoiceEntry;

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
		$pastEventTreshold = new \DateTime();
		$pastEventTreshold->sub(new \DateInterval('P2W')); //TODO: make configurable
		$query = $repository->createQueryBuilder('e')
			->where('e.registrationEnds < :now')
			->orderBy('e.takesPlace', 'DESC');
		
		$isAdmin = $this->get('security.context')->isGranted('ROLE_ADMIN');
		
		if(!$isAdmin) {
			$query = $query->andWhere('e.takesPlace > :treshold')
							->setParameters(array('treshold' => $pastEventTreshold, 'now' => $now));
		}
		else {
			$query = $query->setParameter('now', $now);
		}
		$query = $query->getQuery();
		$pastEvents = $query->getResult();
		
		//Hae tapahtumat, joissa on kiltisilmo paraikaa meneillään
		$kiltisNow = new \DateTime();
		$kiltisNow->add(new \DateInterval('PT3H'));
		$query = $repository->createQueryBuilder('e')
			->where('e.registrationStarts < :kiltisNow')
			->andWhere('e.registrationStarts > :now')
			->setParameter('now', $now)
			->setParameters(array('now' => $now, 'kiltisNow' => $kiltisNow))
			->getQuery();
		$kiltisEvents = $query->getResult();
		
		return $this->render('ProdekoIlmoBundle:Ilmo:eventlist.html.twig',
				array('activeEvents' => $activeEvents,
					  'upcomingEvents' => $upcomingEvents,
					  'pastEvents' => $pastEvents,
					  'kiltisEvents' => $kiltisEvents)
				);
	}
	
	//Näyttää yhden tapahtuman tiedot
	public function showAction($id, Request $request)
	{
		$kiltis = false;
		if($ip = $request->getClientIp() === $this->container->getParameter('kiltis_ip')) {
			$kiltis = true;
		}
		//Hae tapahtuma URI:sta tulleen id:n perusteella
		$event = $this->getDoctrine()
			->getRepository('ProdekoIlmoBundle:Event')
			->findOneBy(array('id' => $id));
		if(!$event)  {
			throw $this->createNotFoundException("Tapahtumaa ei löydy!");
		}
		//Luo uusi ilmoittautumisolio ja liitä sille kyseinen tapahtuma
		$registration = Helpers::createRegistrationObject($event);
		//Tee ilmoittautumislomake, määrittely löytyy Prodeko\IlmoBundle\Form\Type\RegistrationType
		$form = $this->createForm(new RegistrationType($event), $registration);
		
		//Anna templatelle muuttujat 
		$variables = array(
				'event' => $event,
				'form' => $form->createView(),
				'kiltis'	=> $kiltis,
				);
		return $this->render('ProdekoIlmoBundle:Ilmo:event.html.twig', $variables);
	}
	
	/*
	 * Tässä controllerissa käsitellään ilmoittautumisrequest,
	 * joka lähetetään ilmoittautumisnapilla.
	 */
	public function registerAction(Request $request, $id)
	{
		//Jos sivu on haettu POSTilla, on kyseessä ilmoittautumisen käsittely
		if ($request->getMethod() == 'POST') {
			$event = $this->getDoctrine()
							->getRepository('ProdekoIlmoBundle:Event')
							->findOneBy(array('id' => $id));
			//Luo uusi ilmoittautumisolio ja liitä sille kyseinen tapahtuma
			$registration = Helpers::createRegistrationObject($event);
			$form = $this->createForm(new RegistrationType($event), $registration);
			$form->bindRequest($request);
			
			/* Tarkasta lomake, isValid näyttää automaattisesti errorit, jos niitä on. 
			 * TODO: tarkista, mistä request on tullut. Jos kyseessä on jonotus,
			 * ohjaa sendConfirmationEmailin asemesta jononäkymään.
			 */
			if ($form->isValid()) {
				//Lisää lomakkeelta tulleet tiedot registration-olioon
				$registration = $form->getData();
				$time = new \DateTime();
				$registration->setRegistrationTime($time);
				$token = Helpers::getRegistrationToken($registration);
				$registration->setToken($token);
				
				//Tallenna ilmoittautuminen tietokantaan
				$em = $this->getDoctrine()->getEntityManager();
				$em->persist($registration);
				$em->flush();
				
				//Lähetä vahvistusviesti
				//Jos ilmo ei ole auki, kyseessä on jonoon ilmoittautuminen
				return $this->forward('ProdekoIlmoBundle:Ilmo:sendConfirmationEmail',
							array(	'event' => $event,
									'token' => $token,
									'email' => $registration->getEmail()));
			}
			else {
				//return new Response(var_dump($form->getErrors()));
				$kiltis = false;
				if($ip = $request->getClientIp() === $this->container->getParameter('kiltis_ip')) {
					$kiltis = true;
				}
				return $this->render('ProdekoIlmoBundle:Ilmo:event.html.twig', array(
						'form' => $form->createView(),
						'id' => $id,
						'event' => $event,
						'kiltis' => $kiltis
				));
			}
		}
		/*Jos register-routella on tehty GET-kutsu, ohjataan
		tapahtumasivulle */
		else {
			return $this->redirect($this->generateUrl('show',
					array('id' => $id)));
		}
	}
	
	/*Lähettää ilmoittautuneelle sähköpostitse vahvistusviestin,
	 joka sisältää linkin ilmon poistamiseen */
	public function sendConfirmationEmailAction($email, $token, Event $event, Request $request)
	{
		$messageBody = "Ilmoittautumisesi tapahtumaan " . $event->getName() . " on tallennettu.\n" .
						"Voit poistaa ilmoittautumisesi allaolevasta linkistä.\n" . 
						"http://ilmo.prodeko.org/fi/remove/" . $token;
		$message = \Swift_Message::newInstance()
		->setSubject($event->getName() . ' / Ilmoittautuminen tallennettu')
		->setFrom('ilmo@prodeko.fi')
		->setTo($email)
		->setBody($messageBody);
		$this->get('mailer')->send($message);
		//TODO: näytä jonkinlainen viesti "ilmoittautuminen onnistui"
		return $this->redirect($this->generateUrl('show', array('id' => $event->getId() )));
	}
	
	/*Luo jononäkymän, jossa tapahtumiin jonotetaan (kiltisjono) */
	public function queueAction($id, Request $request)
	{
		$event = $this->getDoctrine()->getRepository('ProdekoIlmoBundle:Event')
			     	  ->findOneBy(array('id' => $id));
		
		//Jos ilmo on alkanut, ohjataan tapahtumasivulle
		if($event->registrationOpen() || $event->registrationEnded()) {
			return $this->redirect($this->generateUrl('show', array('id' => $id)));
		}
		$registration = Helpers::createRegistrationObject($event);
		$form = $this->createForm(new RegistrationType($event), $registration);
		
		$variables = array(
				'event' => $event,
				'form' => $form->createView());
		return $this->render('ProdekoIlmoBundle:Ilmo:queue.html.twig', $variables);
	}
	
	public function removePromptAction($token, Request $request)
	{
		$isAdmin = $this->get('security.context')->isGranted('ROLE_ADMIN');
		$em = $this->getDoctrine()->getEntityManager();
		$registration = $this->getDoctrine()
			->getRepository('ProdekoIlmoBundle:Registration')
			->findOneBy(array('token' => $token));
		if(!$registration) {
			throw $this->createNotFoundException("Virheellinen ilmoittautumiskoodi");
		}
		if(!$registration->getEvent()->registrationEnded() || $isAdmin) {
			return $this->render('ProdekoIlmoBundle:Ilmo:removeprompt.html.twig',
					array('registration' => $registration));
		}
		//TODO: Tässä pajotain fiksumpaa
		else throw new HttpException(403, "Et voi poistaa ilmoittautumistasi, sillä tapahtuman ilmoittautuminen on sulkeutunut.");
	}
	
	
	public function removeRegistrationAction($token, Request $request) 
	{
		$isAdmin = $this->get('security.context')->isGranted('ROLE_ADMIN');
		$em = $this->getDoctrine()->getEntityManager();
		$registration = $this->getDoctrine()
			->getRepository('ProdekoIlmoBundle:Registration')
			->findOneBy(array('token' => $token));
		if (!$registration) {
			//Heitä etusivulle, jos ilmoittautumista ei löydy annetulla id:llä.
			return $this->redirect($this->generateUrl("list"));
		}
		$event = $registration->getEvent();
		if(!$registration->getEvent()->registrationEnded() || $isAdmin)
		{
			// Poista ilmoittautumisen vapaateksti- ja monivalintaentryt
			foreach ($registration->getFreeTextEntries() as $freeTextEntry) $em->remove($freeTextEntry);
			foreach ($registration->getMultipleChoiceEntries() as $multipleChoiceEntry) $em->remove($multipleChoiceEntry);
			
			// Poista itse ilmoittautuminen ja tallenna.
			$em->remove($registration);
			$em->flush();
			//Ohjaa tarkastelemaan tapahtumaa
			//TODO: Ohjaa takaisin adminin ilmoittautumiset - näkymään, jos pyyntö tullut sieltä.
			if($isAdmin) {
				return $this->redirect($this->generateUrl("adminRegistrations", array('id' => $event->getId())));
			}
			return $this->redirect($this->generateUrl("show", array('id' => $event->getId())));
		}
		
	}
}
?>
