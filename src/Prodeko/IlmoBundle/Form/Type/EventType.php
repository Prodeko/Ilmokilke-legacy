<?php
namespace Prodeko\IlmoBundle\Form\Type;

use Prodeko\IlmoBundle\Entity\MultipleChoiceField;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class EventType extends AbstractType
{
	public function buildForm(FormBuilder $builder, array $options)
    {
        $builder->add('name', 'text');
		$builder->add('summary', 'textarea');
		$builder->add('description', 'textarea');
		$builder->add('takesPlace', "datetime", array(
				'date_widget' => 'single_text',
				'time_widget' => 'single_text',
				'date_format' => 'dd.MM.yyyy'));
		$builder->add('registrationStarts', "datetime", array(
				'date_widget' => 'single_text',
				'time_widget' => 'single_text',
				'date_format' => 'dd.MM.yyyy'));
		$builder->add('registrationEnds', "datetime", array(
				'date_widget' => 'single_text',
				'time_widget' => 'single_text',
				'date_format' => 'dd.MM.yyyy'));
		$builder->add('location', "text");
		$builder->add('sizeOfOpenQuota','integer');
		$builder->add('hiddenList', 'checkbox', array('required' => false));
		$builder->add('askAboutAllergies', 'checkbox', array('required' => false));
		$builder->add('kiltisilmo', 'checkbox', array('required' => false));
		
		$builder->add('freeTextFields', 'collection', array(
				'type' => new FreeTextFieldType(),
				'label' => ' ',
				'allow_add' => true,
				'allow_delete' => true,
				'by_reference' => false,
				)
		);
		
		$builder->add('multipleChoiceFields', 'collection', array(
				'type' => new MultipleChoiceFieldType($this->em),
				'label' => ' ',
				'allow_add' => true,
				'allow_delete' => true,
				'by_reference' => false,
				)
		);
		
		$builder->add('quotas', 'collection', array(
				'type' => new QuotaType(),
				'label' => ' ',
				'allow_add' => true,
				'allow_delete' => true,
				'by_reference' => false,
				)
		);
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