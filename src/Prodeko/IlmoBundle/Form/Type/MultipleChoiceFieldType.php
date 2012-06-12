<?php
namespace Prodeko\IlmoBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class EventType extends AbstractType
{
	public function buildForm(FormBuilder $builder, array $options)
    {
        $builder->add('name', 'text');
        
    }
    //Tällanen funktio pitää jostain syystä olla, palauttaa formin "nimen"
    public function getName()
    {
        return 'multiplechoicefield';
    }
    public function getDefaultOptions(array $options)
    {
    	return array(
    			'data_class' => 'Prodeko\IlmoBundle\Entity\MultipleChoiceField',
    	);
    }
    
}