<?php	
namespace Prodeko\IlmoBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;

class ChoicesToTextTransformer implements DataTransformerInterface {

	/**
	 * Transforms an array (choices) to a string (csv).
	 *
	 * @param  Array|null $choices
	 * @return string
	 */
	public function transform($choices)
	{
		if (!is_array($choices)) {
			return "";
		}
	
		return implode(";", $choices);
	}
	
	/**
	 * Transforms a string (csv) to an array (choices).
	 *
	 * @param  string $csv
	 * @return Array|null
	 */
	public function reverseTransform($csv)
	{
		if (!$csv) {
			return null;
		}
		return explode(";", $csv);
	}
	
}