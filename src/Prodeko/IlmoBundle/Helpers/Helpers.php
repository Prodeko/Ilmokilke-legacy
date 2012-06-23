<?php
namespace Prodeko\IlmoBundle\Helpers;


use Doctrine\ORM\PersistentCollection;

use Doctrine\ORM\EntityManager;

use Doctrine\ORM\EntityRepository;

use Prodeko\IlmoBundle\Entity\Event;

use Prodeko\IlmoBundle\Entity\FreeTextField;

use Prodeko\IlmoBundle\Entity\FreeTextEntry;

use Prodeko\IlmoBundle\Entity\MultipleChoiceField;

use Prodeko\IlmoBundle\Entity\MultipleChoiceEntry;

use Prodeko\IlmoBundle\Entity\Registration;

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
	
	// Palauttaa alkuperäisten ja muutettujen kenttien perusteella arrayt poistetuista ja lisätyistä kentistä.
	public static function filterFields($original, $modified) { 
		$new = array();
		$deleted = $original;
		foreach ($modified as $key => $field) {
			//Fieldillä on id <=> se on tallennettu tietokantaan <=> Se on pysynyt olemassaolevana.
			$fieldId = $field->getId();
			if ($fieldId) {
				foreach ($deleted as $toDel) {
					//Etsii sen kentän alkuperäisten listasta, jota uusi kenttä vastaa.
					if ($toDel->getId() === $fieldId) unset($deleted[$key]); //Poista kenttä deleted-listasta, koska sitä ei ole poistettu.
				}
			} else {
				//Jos fieldillä ei ole idiä, sen on oltava uusi.
				$new[] = $field;
			}
		}
		return array($new, $deleted);
	}
	
	// Lisää annetuille kentille annetuille ilmoittautumisille dummy-entryt
	public static function addDummyValues($fields, $registrations, EntityManager $em, $value) {
		foreach ($fields as $field) {
			// Selvitä kentän tyyppi
			$type = explode("\\", get_class($field));
			$type = end($type);
			foreach ($registrations as $registration) {
				// Luo entry riippuen kentän tyypistä ja anna sille dummysisältö
				if ($type == "FreeTextField") {
					$entry = new FreeTextEntry();
					$entry->setContent($value);
				} else if ($type == "MultipleChoiceField") {
					$entry = new MultipleChoiceEntry();
					$entry->setSelection($value);
				}
				
				// Anna muut tiedot
				$entry->setField($field);
				$entry->setRegistration($registration);
				$em->persist($entry);
			}
		}
		return $em;
	}

	public static function deleteEntries($fields, $registrations, EntityManager $em) {
		foreach ($fields as $field) {
			$id = $field->getId();
			// Selvitä kentän tyyppi
			$type = explode("\\", get_class($field));
			$type = end($type);
			// Etsi esimmäiseltä ilmoittautuneelta se entry, joka vastaa poistettavaa kenttää
			$entries = ($type == "FreeTextField") ? $registrations[0]->getFreeTextEntries() : $registrations[0]->getMultipleChoiceEntries();
			
			foreach ($entries as $key => $entry) {
				if ($entry->getField()->getId() === $id) {
					// Kun kenttä löytyy, tallenna sen avain ja lopeta etsiminen.
					$delKey = $key;
					break;
				}
			}
			// Poista jokaiselta ilmoittautuneelta kyseinen entry.
			foreach ($registrations as $registration) {
				$entries = ($type == "FreeTextField") ? $registration->getFreeTextEntries() : $registration->getMultipleChoiceEntries();
				$em->remove($entries[$delKey]);
			}
		}
		return $em;
	}
	
	public static function getRegistrationToken(Registration $registration) {
		//käytetään ilmoittautuneen mailiosoitetta ja ilmoaikaa
		$email = $registration->getEmail();
		$timestamp = $registration->getRegistrationTime()->format('YmdHis');
		$hashkey = $email . $timestamp;
		//suolataan hash, ettei sen lähdettä pysty päättelemään 
		$salt = sha1(rand());
		$salt = substr($salt, 0, 3);
		return base64_encode(sha1($hashkey . $salt));
	}
	
}