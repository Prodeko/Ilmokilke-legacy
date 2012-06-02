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
		$query = $repository->createQueryBuilder('e')
   			->where('e.takesPlace < :now')
	    	->setParameter('now', new \DateTime())
	    	->getQuery();

		$events = $query->getResult();

		return $this->render('ProdekoIlmoBundle:Ilmo:eventlist.html.twig', array('list' => $events));
	}
	
	//Näyttää yhden tapahtuman tiedot
	public function showAction($id, Request $request)
	{
		//Hae tapahtuma URI:sta tulleen id:n perusteella
		//TODO: Tarkasta, onko tapahtuma auki. Tallennusta ei myöskään pidä tehdä, jos tapahtuma on kiinni.
		$event = $this->getDoctrine()
			->getRepository('ProdekoIlmoBundle:Event')
			->findOneBy(array('id' => $id));
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
			//Tarkasta lomake, isValid näyttää automaattisesti errorit, jos niitä on
			if ($form->isValid()) {
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
				'id' => $id
				);
		
		return $this->render('ProdekoIlmoBundle:Ilmo:event.html.twig', $variables);
	}

}
?>
