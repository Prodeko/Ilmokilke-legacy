<?php 
namespace Prodeko\IlmoBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class FreeTextEntryType extends AbstractType
{
	public function buildForm(FormBuilder $builder, array $options)
	{
		$builder->add('content', 'text');
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