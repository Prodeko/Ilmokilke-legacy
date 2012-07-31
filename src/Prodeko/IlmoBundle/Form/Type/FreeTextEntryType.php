<?php 
namespace Prodeko\IlmoBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class FreeTextEntryType extends AbstractType
{
	
	public function __construct($event) {
		$this->fields = $event->getFreeTextFields()->getSnapshot();
		$this->index = 0;
	}
	
	public function buildForm(FormBuilder $builder, array $options)
	{
		$field = $this->fields[$this->index];
		$builder->add('content', 'textarea', array('required' => false, 'label' => $field->getName()));
		$this->index++;
	}
	//Tällanen funktio pitää jostain syystä olla, palauttaa formin "nimen"
	public function getName()
	{
		return 'freetextentry';
	}
	public function getDefaultOptions(array $options)
	{
		return array(
				'data_class' => 'Prodeko\IlmoBundle\Entity\FreeTextEntry',
		);
	}

}

?>