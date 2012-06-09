<?php
namespace Prodeko\IlmoBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class RegistrationType extends AbstractType
{
	public function buildForm(FormBuilder $builder, array $options)
    {
        $builder->add('firstName', 'text');
        $builder->add('lastName', 'text');
        $builder->add('email', 'email');
        $builder->add('allergies', 'text', array('required' => false));
        $builder->add('freeTextEntries', 'collection', array(
        		'type' => new FreeTextEntryType(),
        		'by_reference' => false,
        		)
        	);
        $builder->add('quota', 'entity', array(
        		'class' => 'ProdekoIlmoBundle:Quota',
        		'query_builder' => function($repository) 
        						{
        						   return $repository->createQueryBuilder('p')->orderBy('p.name','ASC');
        						},
        		'property' => 'name',
        ));
        
    }
    //Tällanen funktio pitää jostain syystä olla, palauttaa formin "nimen"
    public function getName()
    {
        return 'registration';
    }
    public function getDefaultOptions(array $options)
    {
    	return array(
    			'data_class' => 'Prodeko\IlmoBundle\Entity\Registration',
    	);
    }
    
}