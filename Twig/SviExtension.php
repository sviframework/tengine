<?php

namespace Svi\TengineBundle\Twig;

use Svi\Application;

class SviExtension extends \Twig_Extension
{
	/**
	 * @var Application
	 */
	private $app;

	function __construct(Application $app)
	{
		$this->app = $app;
	}

	public function getFunctions()
	{
		return [
			new \Twig_SimpleFunction('trans', [$this, 'transFunction']),
		];
	}

	public function getFilters()
	{
		return [
			new \Twig_SimpleFilter('trans', [$this, 'transFunction']),
			new \Twig_SimpleFilter('plural', [$this, 'pluralFunction']),
		];
	}

	public function pluralFunction($number, $one, $four, $many)
	{
		if ($number == 0) {
			return $many;
		}
		$number = trim($number);
		$lastChar = $number[strlen($number) - 1];
		$lastTwoChars = (strlen($number) > 1 ? $number[strlen($number) - 2] . $number[strlen($number) - 1] : 0);

		if ($lastTwoChars > 10 && $lastTwoChars < 20) {
			return $many;
		} else if ($lastChar == 1) {
			return $one;
		} else if ($lastChar == 0 || $lastChar > 4) {
			return $many;
		} else {
			return $four;
		}
	}

	public function transFunction($key, array $params = [])
	{
		return $this->app->getTranslationService()->trans($key, $params);
	}

	/**
	 * Returns the name of the extension.
	 *
	 * @return string The extension name
	 */
	public function getName()
	{
		return 'svitengineext';
	}

}