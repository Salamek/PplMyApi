<?php
/**
 * Created by PhpStorm.
 * User: Galek
 * Date: 29.12.2017
 */
namespace Salamek\PplMyApi\Validators;

interface IValidatorLength
{
	/**
	 * @param $value
	 * @param $need
	 * @return bool
	 */
	public static function validate($value, $need);
}
