<?php 
namespace Prodeko\IlmoBundle\Controller;

use Symfony\Component\HttpFoundation\Response;

class IlmoController
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
		return new Response("<h1>Ime paskaa, " . $tapahtuma . "</h1>");
	}
}
