<?php
namespace Prodeko\IlmoBundle\Helpers;


use Doctrine\ORM\EntityRepository;

use Prodeko\IlmoBundle\Entity\Event;

class Helpers {
	
	public static function getRegistrationsByQuota(Event $event, EntityRepository $repository)
	{
		$queue = array();
		$quotas = $event->getQuotas();
		foreach ($quotas as $quota) {
			$quotaSize = $quota->getSize();
			$registrationsInCurrentQuota = $repository->createQueryBuilder('r')
				->where('r.quota = :quota')
				->setParameter('quota', $quota->getId())
				->orderBy('r.registrationTime', 'ASC')
				->setMaxResults($quotaSize) // rajoitetaan kiintiön kokoon
				->getQuery()
				->getResult();
			$totalRegistrationsInCurrentQuota =
			count(
					$repository->createQueryBuilder('r')
					->where('r.quota = :quota')
					->setParameter('quota', $quota->getId())
					->orderBy('r.registrationTime', 'ASC')
					->getQuery()
					->getResult()
				);
			//Haetaan jonossa olevat ilmot nykyisessä kiintiössä
			if ($totalRegistrationsInCurrentQuota > $quotaSize) {
				$queueInCurrentQuota = $repository->createQueryBuilder('r')
				->where('r.quota = :quota')
				->setParameter('quota', $quota->getId())
				->orderBy('r.registrationTime', 'DESC')
				->setMaxResults($totalRegistrationsInCurrentQuota - $quotaSize)
				->getQuery()
				->getResult();
				$queue = array_merge($queue, $queueInCurrentQuota);
			}
			$registrations[$quota->getName()] = $registrationsInCurrentQuota;
		}
		return array('registrations' => $registrations, 'queue' => $queue);
			
	}
	
}
