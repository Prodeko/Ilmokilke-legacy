<?php
namespace Prodeko\IlmoBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Prodeko\IlmoBundle\Entity;

class RegistrationType extends AbstractType
{
	protected $event;
	
	public function __construct(\Prodeko\IlmoBundle\Entity\Event $event) {
		$this->event = $event;
	}
	
	public function buildForm(FormBuilder $builder, array $options)
    {
    	$event = $this->event;
    	//var_dump($event); die;
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
        		'query_builder' => function($repository) use ($event) 
        						{
        						   return $repository->createQueryBuilder('p')->where('p.event = :event')
        						   ->setParameter('event',$event)->orderBy('p.name','ASC');
        						},
        		'property' => 'name',
        		'expanded' => 'true'
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