<?php
namespace Prodeko\IlmoBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class EventType extends AbstractType
{
	public function buildForm(FormBuilder $builder, array $options)
    {
        $builder->add('name', 'text');
		$builder->add('summary', 'textarea');
		$builder->add('description', 'textarea');
		$builder->add('takesPlace', "datetime");
		$builder->add('registrationStarts', "datetime");
		$builder->add('registrationEnds', "datetime");
		$builder->add('location', "text");
    }
    //Tällanen funktio pitää jostain syystä olla, palauttaa formin "nimen"
    public function getName()
    {
        return 'event';
    }
    public function getDefaultOptions(array $options)
    {
    	return array(
    			'data_class' => 'Prodeko\IlmoBundle\Entity\Event',
    	);
    }
    
}