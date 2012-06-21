<?php 
namespace Prodeko\IlmoBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class MultipleChoiceEntryType extends AbstractType
{
	private $index; // Pitää kirjaa siitä, kuinka mones kenttä menossa
	
	private $fields; // Array tähän tapahtumaan liittyvistä monivalintakentistä.
	
	public function __construct($event) {
		$this->fields = $event->getMultipleChoiceFields()->getSnapshot();
		$this->index = 0;
	}
	
	public function buildForm(FormBuilder $builder, array $options)
	{
		$field = $this->fields[$this->index];
		$builder->add('selection', 'choice', array('choices' => $field->getChoices(), 'label' => $field->getName()));
		$this->index++;
	}
	//Tällanen funktio pitää jostain syystä olla, palauttaa formin "nimen"
	public function getName()
	{
		return 'multiplechoiceentry';
	}
	public function getDefaultOptions(array $options)
	{
		return array(
				'data_class' => 'Prodeko\IlmoBundle\Entity\MultipleChoiceEntry',
		);
	}

}

?>