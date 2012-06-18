<?php
namespace Prodeko\IlmoBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Prodeko\IlmoBundle\Form\DataTransformer\ChoicesToTextTransformer;

class ChoicesSelectorType extends AbstractType
{

	public function buildForm(FormBuilder $builder, array $options)
	{
		$transformer = new ChoicesToTextTransformer();
		$builder->appendClientTransformer($transformer);
	}

	public function getDefaultOptions(array $options)
	{
		return array(
				'invalid_message' => 'VIDDU :D:D:D',
		); //Ebin.
	}

	public function getParent(array $options)
	{
		return 'textarea';
	}

	public function getName()
	{
		return 'choices_selector';
	}
}