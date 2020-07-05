<?php
declare(strict_types=1);
/**
 * @package PHPClassCollection
 * @subpackage MbRegex
 * @link http://php-classes.sourceforge.net/ PHP Class Collection
 * @author Dennis Wronka <reptiler@users.sourceforge.net>
 */
namespace unrealization\PHPClassCollection;
/**
 * @package PHPClassCollection
 * @subpackage MbRegex
 * @link http://php-classes.sourceforge.net/ PHP Class Collection
 * @author Dennis Wronka <reptiler@users.sourceforge.net>
 * @version 0.0.1
 * @license http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL 2.1
 */
class MbRegex
{
	public static function search(string $regex, string $content, string $options = ''): ?int
	{
		$encoding = mb_detect_encoding($content, mb_list_encodings());
		mb_regex_encoding($encoding);
		mb_ereg_search_init($content);

		if (!mb_ereg_search($regex, $options))
		{
			return null;
		}

		return mb_ereg_search_getpos();
	}

	public static function searchAll(string $regex, string $content, string $options = ''): array
	{
		$matches = array();
		$encoding = mb_detect_encoding($content, mb_list_encodings());
		mb_regex_encoding($encoding);
		mb_ereg_search_init($content);

		while (mb_ereg_search($regex, $options))
		{
			$matches[] = mb_ereg_search_getpos();
		}

		return $matches;
	}

	public static function match(string $regex, string $content, string $options = ''): ?array
	{
		$encoding = mb_detect_encoding($content, mb_list_encodings());
		mb_regex_encoding($encoding);
		mb_ereg_search_init($content);

		if (!mb_ereg_search($regex, $options))
		{
			return null;
		}

		return mb_ereg_search_getregs();
	}

	public static function matchAll(string $regex, string $content, string $options = ''): array
	{
		$matches = array();
		$encoding = mb_detect_encoding($content, mb_list_encodings());
		mb_regex_encoding($encoding);
		mb_ereg_search_init($content);

		while (mb_ereg_search($regex, $options))
		{
			$matches[] = mb_ereg_search_getregs();
		}

		return $matches;
	}
}