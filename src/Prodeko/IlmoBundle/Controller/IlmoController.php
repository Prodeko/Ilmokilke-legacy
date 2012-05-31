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
		return new Response("Homo");
	}
	
	public function showAction($tapahtuma)
	{
		//TODO: implement "show event details"-controller
		$variables = array(
				'eventname' => $tapahtuma,
				'description' => 'Lorem ipsum vittu on perseestä',
				'starttime' => '20:15'
				);
		return $this->render('ProdekoIlmoBundle:Ilmo:event.html.twig', $variables);
	}
}
