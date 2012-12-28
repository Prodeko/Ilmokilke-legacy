<?php
namespace Prodeko\IlmoBundle\Controller;



use Prodeko\IlmoBundle\Entity\Quota;

use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\Serializer\Encoder\JsonEncoder;

use Symfony\Component\HttpFoundation\Request;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AjaxController extends Controller{
	public function ajaxListAction(Request $request, $eventId)
	{
		$jsonEncoder = new JsonEncoder();
		$event = $this->getDoctrine()
					  ->getRepository('ProdekoIlmoBundle:Event')->findOneBy(array('id' => $eventId));
		$quotas = $event->getQuotas();
		$foo = array();
		foreach ($quotas as $quota) {
			$registrationArray = array();
			$registrations = $quota->getRegistrations();
			foreach ($registrations as $registration)
			{
				$registrationArray[]=array('name' => $registration->getFirstName() . " " . $registration->getLastName(),
										   'time' => $registration->getRegistrationTime()->format('d.m.y G.i.s') );
			}
			$quotaArray[]=array('name' => $quota->getName(),
						  'registrants' => $registrationArray);
		}
		$response = new Response($jsonEncoder->encode($quotaArray, 'json'));
		return $response;
	}
}
