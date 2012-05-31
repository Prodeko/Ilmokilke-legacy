<?php 
namespace Prodeko\IlmoBundle\Controller;

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
	
	public function showAction($tapahtuma)
	{
		//TODO: implement "show event details"-controller
		return $this->render('ProdekoIlmoBundle:Ilmo:event.html.twig', array('event' => $tapahtuma));
	}
}
?>