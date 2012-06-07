<?php
namespace Prodeko\IlmoBundle\Form\Type;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class QuotaType extends AbstractType{
	
	public function buildForm(FormBuilder $builder, array $options) {
		$builder->add('name', 'text');
		$builder->add('size', 'integer');
	}
	public function getName() {
		return 'quota';
	}
	
	public function getDefaultOptions(array $options)
	{
		return array(
				'data_class' => 'Prodeko\IlmoBundle\Entity\Quota',
		);
	}
}
