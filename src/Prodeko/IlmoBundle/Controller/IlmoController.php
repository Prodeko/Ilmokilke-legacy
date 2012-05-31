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
	
	//N�ytt�� yhden tapahtuman tiedot
	public function showAction($tapahtuma)
	{
		//TODO: implement "show event details"-controller
		$variables = array(
				'eventname' => $tapahtuma,
				'description' => 'Lorem ipsum vittu on perseesta',
				'starttime' => '20:15'
				);
		return $this->render('ProdekoIlmoBundle:Ilmo:event.html.twig', $variables);
	}
	
	// N�ytt�� lomakkeen jolla luodaan tapahtuma
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
