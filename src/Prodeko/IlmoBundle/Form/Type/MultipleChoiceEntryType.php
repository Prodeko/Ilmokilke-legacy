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
		$choices = array();
		foreach ($field->getChoices() as $choice) {
			$choices[$choice] = $choice; // Tallennetaan vaihtoehdot niin, että avaimet ja arvot ovat samat => valinnat tallentuvat tekstinä multipleChoiceEntry-tauluun
		}
		$expanded = (count($choices) < 4 ? true : false); // Extended määrää, näytetäänkö kenttä radiobuttoneina vai valintalistana.
		$builder->add('selection', 'choice', array('choices' => $choices, 'label' => $field->getName(), 'expanded' => $expanded));
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