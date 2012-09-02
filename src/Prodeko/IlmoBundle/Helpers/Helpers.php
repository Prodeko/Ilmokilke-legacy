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
	
	/*
	 * Hakee argumenttina annetun tapahtuman jonossa olevat ilmot, 
	 * so. kustakin kiintiöstä ne ilmot, jotka eivät mahtuneet kiintiöön
	 */
	public static function getQueue(Event $event, EntityRepository $repository)
	{
		$queue = array();
		$quotas = $event->getQuotas();
		foreach ($quotas as $quota) {
			//Haetaan jonossa olevat ilmot kussakin kiintiössä
			$quotaSize = $quota->getSize();
			if (!$quota->hasFreeSeats()) {
				$queueInCurrentQuota = $repository->createQueryBuilder('r')
				->where('r.quota = :quota')
				->setParameter('quota', $quota->getId())
				->orderBy('r.registrationTime', 'DESC')
				->setMaxResults($quota->getQueueLength())
				->getQuery()
				->getResult();
				$queue = array_merge($queue, $queueInCurrentQuota);
			}
		}
		usort($queue, array('\Prodeko\IlmoBundle\Entity\Registration', 'compareByRegistrationTime'));
		return array_slice($queue, $event->getSizeOfOpenQuota());
	}
	
	/*
	 * Hakee argumenttina annettuun tapahtumaan mahtuneet ilmoittautumiset.
	 */
	public static function getParticipants(Event $event, EntityRepository $repository)
	{
		$participants = array();
		$quotas = $event->getQuotas();
		foreach($quotas as $quota) {
			$participantsInCurrent = $quota->getRegistrations();
			$participants = array_merge($participants, $participantsInCurrent);
		}
		$participantsInOpenQuota = $event->getOpenQuotaRegistrations();
		return array_merge($participants,$participantsInOpenQuota);
	}
	
	/*
	 * Luo argumenttina annettuun tapahtumaan liittyvän ilmo-olion
	 * vaadittavine kenttäsyöteolioineen.
	 */
	public static function createRegistrationObject(Event $event)
	{
		$registration = new Registration();
		$registration->setEvent($event);
		//Hae tapahtuman vapaatekstikentät
		$freeTextFields = $event->getFreeTextFields();
		$fieldNames = array();
		foreach ($freeTextFields as $freeTextField) {
			//Lisää entry-olio jokaiselle vapaatekstikentälle
			$entry = new FreeTextEntry();
			$entry->setField($freeTextField);
			$freeTextField->addFreeTextEntry($entry);
			$entry->setRegistration($registration);
			$registration->addFreeTextEntry($entry);
			$fieldNames[] = $freeTextField->getName();
		}
		
		$multipleChoiceFields = $event->getMultipleChoiceFields();
		foreach ($multipleChoiceFields as $multipleChoiceField) {
			//Lisää entry-olio jokaiselle monivalintakentälle
			$entry = new MultipleChoiceEntry();
			$entry->setField($multipleChoiceField);
			$multipleChoiceField->addMultipleChoiceEntry($entry);
			$entry->setRegistration($registration);
			$registration->addMultipleChoiceEntry($entry);
		}
		return $registration;
	}
	
	/*
	 * Palauttaa alkuperäisten ja muutettujen kenttien perusteella arrayt poistetuista ja lisätyistä kentistä.
	 */
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
	
	/*
	 * Lisää annetuille kentille annetuille ilmoittautumisille dummy-entryt
	 */ 
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
	/*
	 * TODO: tähän lyhyt kuvaus siitä, mitä funktio tekee
	 */
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
	
	/*
	 * Palauttaa argumenttina annetun ilmo-olion hashin,
	 * jota käytetään ilmoittautumisen poistamiseen
	 * (ja muokkaamiseen?)
	 */
	public static function getRegistrationToken(Registration $registration) {
		//käytetään ilmoittautuneen mailiosoitetta ja ilmoaikaa
		$email = $registration->getEmail();
		$timestamp = $registration->getRegistrationTime()->format('YmdHis');
		$hashkey = $email . $timestamp;
		//suolataan hash, ettei sen lähdettä pysty päättelemään 
		$salt = sha1(rand());
		$salt = substr($salt, 0, 3);
		$token = base64_encode(sha1($hashkey . $salt));
		return substr($token, 0,strlen($token) - 2);
	}
	
}