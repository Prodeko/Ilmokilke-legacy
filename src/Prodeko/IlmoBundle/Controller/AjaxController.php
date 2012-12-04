<?php
namespace Prodeko\IlmoBundle\Controller;



use Prodeko\IlmoBundle\Entity\Quota;

use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\Serializer\Encoder\JsonEncoder;

use Symfony\Component\HttpFoundation\Request;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AjaxController extends Controller{
	public function ajaxListAction(Request $request, $quotaId)
	{
		$jsonEncoder = new JsonEncoder();
		$quota = $this->getDoctrine()
					  ->getRepository('ProdekoIlmoBundle:Quota')->findOneBy(array('id' => $quotaId));
		$registrations = $quota->getRegistrations();
		$foo = array();
		foreach ($registrations as $registration) {
			$foo[]=array('name' => $registration->getFirstName() ." ". $registration->getLastName(),
						  'time' => $registration->getRegistrationTime()->format('d.m.y G.i.s') );
		}
		$response = new Response($jsonEncoder->encode($foo, 'json'));
		return $response;
	}
}
