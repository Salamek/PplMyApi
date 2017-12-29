<?php
/**
 * Created by PhpStorm.
 * User: Galek
 * Date: 29.12.2017
 */

namespace Salamek\PplMyApi\Validators;


use Salamek\PplMyApi\Exception\WrongDataException;

class MaxLengthValidator implements IValidatorLength
{
	/**
	 * @inheritdoc
	 * @throws WrongDataException
	 */
	public static function validate($value, $need)
	{
		if (($len = mb_strlen($value)) > $need) {
			throw new WrongDataException(sprintf('value (%s) is longer than %d characters (%d)', $value, $need, $len));
		}
	}
}
