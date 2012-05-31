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
		$tapahtuma = array(array('nimi'=>'Ekatapahtuma','aika'=>'Tanaan','kuvaus'=>'Parasta ikina'),array('nimi'=>'Tokatapahtuma','aika'=>'Tanaan','kuvaus'=>'Parasta ikina'),array('nimi'=>'Kolmastapahtuma','aika'=>'Tanaan','kuvaus'=>'Parasta ikina'));
		return $this->render('ProdekoIlmoBundle:Ilmo:eventlist.html.twig', array('list' => $tapahtuma));
	}
	
	//Näyttää yhden tapahtuman tiedot
	public function showAction($tapahtuma)
	{
		//TODO: implement "show event details"-controller
		$id = $request->query->get('id', '1');
		$event = $this->getDoctrine()
			->getRepository('ProdekoIlmoBundle:Event')
			->findOneBy(array('id' => $id));
		$registrations = $this->getDoctrine()
			->getRepository('ProdekoIlmomBundle:Registration')
			->findBy(array('event_id' => $id));
		$variables = array(
				'eventname' => $event->getName(),
				'description' => $event->getDescription(),
				'starttime' => $event->getTakesPlace(),
				'registration_starts' => $event->getRegistrationStarts(),
				'registration_ends' => $event->getRegistrationEnds(),
				'location' => $event->getLocation(),
				'summary' => $event->getSummary(),
				'registrations' => $registrations
				);											//Osallistujat
		return $this->render('ProdekoIlmoBundle:Ilmo:event.html.twig', $variables);
	}
	
	// Näyttää lomakkeen jolla luodaan tapahtuma
	public function createEventFormAction() 
	{
		$tapahtuma = new Event();
		$form = $this->createFormBuilder($tapahtuma)
		->add('name', 'text')
		->add('summary', 'textarea')
		->add('description', 'textarea')
		->add('takes_place', "datetime")
		->add('registration_starts', "datetime")
		->add('registration_ends', "datetime")
		->add('location', "text")
		->getForm();
		
		return $this->render('ProdekoIlmoBundle:Ilmo:createEvent.html.twig', array(
				'form' => $form->createView(),
		));
	}
	
	
	public function createEventAction(Request $r)
	{
		$event = new Event();
		$form = $this->createFormBuilder($event)
		->add('name', 'text')
		->add('summary', 'textarea')
		->add('description', 'textarea')
		->add('takes_place', "datetime")
		->add('registration_starts', "datetime")
		->add('registration_ends', "datetime")
		->add('location', "text")
		->getForm();
        $form->bindRequest($r);
		$event = $form->getData();
		
		$em = $this->getDoctrine()->getEntityManager();
		$em->persist($event);
		$em->flush();
		
		return $this->render('ProdekoIlmoBundle:Ilmo:createEvent.html.twig', array(
				'form' => $form->createView(),
		));
/*		$name = "lol";//$post_params->get("name");
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
*/	}
}
?>
