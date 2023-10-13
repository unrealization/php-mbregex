<?php
declare(strict_types=1);
/**
 * @package PHPClassCollection
 * @subpackage MbRegEx
 * @link http://php-classes.sourceforge.net/ PHP Class Collection
 * @author Dennis Wronka <reptiler@users.sourceforge.net>
 */
namespace unrealization;
/**
 * @package PHPClassCollection
 * @subpackage MbRegEx
 * @link http://php-classes.sourceforge.net/ PHP Class Collection
 * @author Dennis Wronka <reptiler@users.sourceforge.net>
 * @version 3.0.0
 * @license http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL 2.1
 */
class MbRegEx
{
	/**
	 * Get the position of the first match for the given regular expression.
	 * @param string $regEx
	 * @param string $content
	 * @param string $options
	 * @return int|NULL
	 */
	public static function search(string $regEx, string $content, string $options = ''): ?int
	{
		$oldEncoding = mb_regex_encoding();
		$encoding = mb_detect_encoding($content, mb_list_encodings());
		mb_regex_encoding($encoding);
		mb_ereg_search_init($content);
		$found = mb_ereg_search($regEx, $options);
		mb_regex_encoding($oldEncoding);

		if (!$found)
		{
			return null;
		}

		return mb_ereg_search_getpos();
	}

	/**
	 * Get the positions of all matches for the given regular expression.
	 * @param string $regEx
	 * @param string $content
	 * @param string $options
	 * @return array
	 */
	public static function searchAll(string $regEx, string $content, string $options = ''): array
	{
		$oldEncoding = mb_regex_encoding();
		$matches = array();
		$encoding = mb_detect_encoding($content, mb_list_encodings());
		mb_regex_encoding($encoding);
		mb_ereg_search_init($content);

		while (mb_ereg_search($regEx, $options))
		{
			$matches[] = mb_ereg_search_getpos();
		}

		mb_regex_encoding($oldEncoding);
		return $matches;
	}

	/**
	 * Get the first match for the given regular expression.
	 * @param string $regEx
	 * @param string $content
	 * @param string $options
	 * @return array|NULL
	 */
	public static function match(string $regEx, string $content, string $options = ''): ?array
	{
		$oldEncoding = mb_regex_encoding();
		$encoding = mb_detect_encoding($content, mb_list_encodings());
		mb_regex_encoding($encoding);
		mb_ereg_search_init($content);
		$found = mb_ereg_search($regEx, $options);
		mb_regex_encoding($oldEncoding);

		if (!$found)
		{
			return null;
		}

		return mb_ereg_search_getregs();
	}

	/**
	 * Get all matches for the given regular expression.
	 * @param string $regEx
	 * @param string $content
	 * @param string $options
	 * @return array
	 */
	public static function matchAll(string $regEx, string $content, string $options = ''): array
	{
		$oldEncoding = mb_regex_encoding();
		$matches = array();
		$encoding = mb_detect_encoding($content, mb_list_encodings());
		mb_regex_encoding($encoding);
		mb_ereg_search_init($content);

		while (mb_ereg_search($regEx, $options))
		{
			$matches[] = mb_ereg_search_getregs();
		}

		mb_regex_encoding($oldEncoding);
		return $matches;
	}

	/**
	 * Replace part of a string.
	 * @param string $regEx
	 * @param string $replacement
	 * @param string $content
	 * @param string $options
	 * @return string|NULL
	 */
	public static function replace(string $regEx, string $replacement, string $content, string $options = ''): ?string
	{
		$oldEncoding = mb_regex_encoding();
		$encoding = mb_detect_encoding($content, mb_list_encodings());
		mb_regex_encoding($encoding);
		$output = mb_ereg_replace($regEx, $replacement, $content, $options);
		mb_regex_encoding($oldEncoding);

		if ($output === false)
		{
			return null;
		}

		return $output;
	}

	/**
	 * Pad a string to a specific length.
	 * @param string $input
	 * @param int $padLength
	 * @param string $padString
	 * @param int $padType
	 * @throws \Exception
	 * @return string
	 */
	public static function padString(string $input, int $padLength, string $padString, int $padType = STR_PAD_RIGHT): string
	{
		$inputEncoding = mb_detect_encoding($input, mb_list_encodings());
		$padStringEncoding = mb_detect_encoding($padString, mb_list_encodings());

		if ($inputEncoding !== $padStringEncoding)
		{
			$padString = mb_convert_encoding($padString, $inputEncoding, $padStringEncoding);
		}

		switch ($padType)
		{
			case STR_PAD_RIGHT:
			case STR_PAD_BOTH:
				$padRight = true;
				break;
			case STR_PAD_LEFT:
				$padRight = false;
				break;
			default:
				throw new \Exception('Unknown pad type '.$padType);
		}

		$leftPadding = '';
		$rightPadding = '';

		while (mb_strlen($leftPadding.$input.$rightPadding) < $padLength)
		{
			if ($padLength - mb_strlen($leftPadding.$input.$rightPadding) < mb_strlen($padString))
			{
				$padding = mb_substr($padString, 0, $padLength - mb_strlen($leftPadding.$input.$rightPadding));
			}
			else
			{
				$padding = $padString;
			}

			if ($padRight)
			{
				$rightPadding .= $padding;
			}
			else
			{
				$leftPadding .= $padding;
			}

			if ($padType === STR_PAD_BOTH)
			{
				$padRight = !$padRight;
			}
		}

		return $leftPadding.$input.$rightPadding;
	}
}