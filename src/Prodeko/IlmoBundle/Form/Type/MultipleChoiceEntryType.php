<?php 
namespace Prodeko\IlmoBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class MultipleChoiceEntryType extends AbstractType
{
	private $field;
	
	public function __construct($event, $index) { // Hakee luotavaan entryyn liittyvän kentän
		$mcFields = $event->getMultipleChoiceFields()->getSnapshot();
		$this->field = $mcFields[$index];
	}
	
	public function buildForm(FormBuilder $builder, array $options)
	{
		$builder->add('selection', 'choice', array('choices' => $this->field->getChoices(), 'label' => $this->field->getName()));
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