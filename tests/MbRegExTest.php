<?php
use PHPUnit\Framework\TestCase;
use unrealization\MbRegEx;

/**
 * Test Case for MbRegEx
 * @covers unrealization\MbRegEx
 */
class MbRegExTest extends TestCase
{
	private $oldEncoding = null;

	public function setUp(): void
	{
		$this->oldEncoding = mb_regex_encoding();
	}

	public function tearDown(): void
	{
		$this->assertSame($this->oldEncoding, mb_regex_encoding());
	}

	public function testMatch()
	{
		$matches = MbRegEx::match('([\d]+) ([^\d\s]+)', '123 Test');
		$this->assertIsArray($matches);
		$this->assertSame(3, count($matches));
		$this->assertIsString($matches[0]);
		$this->assertSame('123 Test', $matches[0]);
		$this->assertIsString($matches[1]);
		$this->assertSame('123', $matches[1]);
		$this->assertIsString($matches[2]);
		$this->assertSame('Test', $matches[2]);

		$matches = MbRegEx::match('(([\d]+) )?([^\d\s]+)', 'Test');
		$this->assertIsArray($matches);
		$this->assertSame(4, count($matches));
		$this->assertIsBool($matches[1]);
		$this->assertFalse($matches[1]);
		$this->assertIsBool($matches[2]);
		$this->assertFalse($matches[2]);
		$this->assertIsString($matches[3]);
		$this->assertSame('Test', $matches[3]);

		$matches = MbRegEx::match('([\d]+) ([^\d\s]+)', 'Test');
		$this->assertNull($matches);
	}

	public function testMatchAll()
	{
		$matches = MbRegEx::matchAll('([\d]+) ([^\d\s]+)', '123 Test 456 Test 123 456 789 Test');
		$this->assertIsArray($matches);
		$this->assertSame(3, count($matches));
		$this->assertIsArray($matches[0]);
		$this->assertSame(3, count($matches[0]));
		$this->assertIsString($matches[0][0]);
		$this->assertSame('123 Test', $matches[0][0]);
		$this->assertIsString($matches[0][1]);
		$this->assertSame('123', $matches[0][1]);
		$this->assertIsString($matches[0][2]);
		$this->assertSame('Test', $matches[0][2]);
		$this->assertIsArray($matches[1]);
		$this->assertSame(3, count($matches[1]));
		$this->assertIsString($matches[1][0]);
		$this->assertSame('456 Test', $matches[1][0]);
		$this->assertIsString($matches[1][1]);
		$this->assertSame('456', $matches[1][1]);
		$this->assertIsString($matches[1][2]);
		$this->assertSame('Test', $matches[1][2]);
		$this->assertIsArray($matches[2]);
		$this->assertSame(3, count($matches[2]));
		$this->assertIsString($matches[2][0]);
		$this->assertSame('789 Test', $matches[2][0]);
		$this->assertIsString($matches[2][1]);
		$this->assertSame('Test', $matches[2][2]);
		$this->assertIsString($matches[2][2]);
		$this->assertSame('Test', $matches[2][2]);

		$matches = MbRegEx::matchAll('(([\d]+) )?([^\d\s]+)', 'Test 123 Test Test 456');
		$this->assertIsArray($matches);
		$this->assertSame(3, count($matches));
		$this->assertIsArray($matches[0]);
		$this->assertSame(4, count($matches[0]));
		$this->assertIsString($matches[0][0]);
		$this->assertSame('Test', $matches[0][0]);
		$this->assertIsBool($matches[0][1]);
		$this->assertFalse($matches[0][1]);
		$this->assertIsBool($matches[0][2]);
		$this->assertFalse($matches[0][2]);
		$this->assertIsString($matches[0][3]);
		$this->assertSame('Test', $matches[0][3]);
		$this->assertIsArray($matches[1]);
		$this->assertSame(4, count($matches[1]));
		$this->assertIsString($matches[1][0]);
		$this->assertSame('123 Test', $matches[1][0]);
		$this->assertIsString($matches[1][1]);
		$this->assertSame('123 ',$matches[1][1]);
		$this->assertIsString($matches[1][2]);
		$this->assertSame('123', $matches[1][2]);
		$this->assertIsString($matches[1][3]);
		$this->assertSame('Test', $matches[1][3]);
		$this->assertIsArray($matches[2]);
		$this->assertSame(4, count($matches[2]));
		$this->assertIsString($matches[2][0]);
		$this->assertSame('Test', $matches[2][0]);
		$this->assertIsBool($matches[2][1]);
		$this->assertFalse($matches[2][1]);
		$this->assertIsBool($matches[2][2]);
		$this->assertFalse($matches[2][2]);
		$this->assertIsString($matches[2][3]);
		$this->assertSame('Test', $matches[2][3]);

		$matches = MbRegEx::matchAll('([\d]+) ([^\d\s]+)', 'Test');
		$this->assertIsArray($matches);
		$this->assertEmpty($matches);
	}

	public function testPadString()
	{
		$output = MbRegEx::padString('Test', 10, 'Test');
		$this->assertIsString($output);
		$this->assertSame(10, mb_strlen($output));
		$this->assertSame('TestTestTe', $output);

		$output = MbRegEx::padString('Test', 10, 'Test', STR_PAD_RIGHT);
		$this->assertIsString($output);
		$this->assertSame(10, mb_strlen($output));
		$this->assertSame('TestTestTe', $output);

		$output = MbRegEx::padString('Test', 10, 'Test', STR_PAD_LEFT);
		$this->assertIsString($output);
		$this->assertSame(10, mb_strlen($output));
		$this->assertSame('TestTeTest', $output);

		$output = MbRegEx::padString('Test', 10, 'Test', STR_PAD_BOTH);
		$this->assertIsString($output);
		$this->assertSame(10, mb_strlen($output));
		$this->assertSame('TeTestTest', $output);

		$output = MbRegEx::padString('テスト', 10, 'テスト');
		$this->assertIsString($output);
		$this->assertSame(10, mb_strlen($output));
		$this->assertSame('テストテストテストテ', $output);

		$output = MbRegEx::padString('テスト', 10, 'テスト', STR_PAD_RIGHT);
		$this->assertIsString($output);
		$this->assertSame(10, mb_strlen($output));
		$this->assertSame('テストテストテストテ', $output);

		$output = MbRegEx::padString('テスト', 10, 'テスト', STR_PAD_LEFT);
		$this->assertIsString($output);
		$this->assertSame(10, mb_strlen($output));
		$this->assertSame('テストテストテテスト', $output);

		$output = MbRegEx::padString('テスト', 10, 'テスト', STR_PAD_BOTH);
		$this->assertIsString($output);
		$this->assertSame(10, mb_strlen($output));
		$this->assertSame('テストテストテストテ', $output);

		$output = MbRegEx::padString('測試', 10, '測試');
		$this->assertIsString($output);
		$this->assertSame(10, mb_strlen($output));
		$this->assertSame('測試測試測試測試測試', $output);

		$output = MbRegEx::padString('測試', 10, '測試', STR_PAD_RIGHT);
		$this->assertIsString($output);
		$this->assertSame(10, mb_strlen($output));
		$this->assertSame('測試測試測試測試測試', $output);

		$output = MbRegEx::padString('測試', 10, '測試', STR_PAD_LEFT);
		$this->assertIsString($output);
		$this->assertSame(10, mb_strlen($output));
		$this->assertSame('測試測試測試測試測試', $output);

		$output = MbRegEx::padString('測試', 10, '測試', STR_PAD_BOTH);
		$this->assertIsString($output);
		$this->assertSame(10, mb_strlen($output));
		$this->assertSame('測試測試測試測試測試', $output);

		$output = MbRegEx::padString('100€', 10, mb_convert_encoding('テスト', 'EUC-JP', 'UTF-8'));
		$this->assertIsString($output);
		$this->assertSame(10, mb_strlen($output));
		$this->assertSame('100€テストテスト', $output);

		$this->expectException(\Exception::class);
		MbRegEx::padString('Test', 10, 'Test', 999);
	}

	public function testReplace()
	{
		$output = MbRegEx::replace('([\d]+) ([^\d\s]+)', '\2 \1', '123 Test');
		$this->assertIsString($output);
		$this->assertSame('Test 123', $output);

		$output = MbRegEx::replace('([\d]+) ([^\d\s]+)', '\2 \1', 'Test');
		$this->assertIsString($output);
		$this->assertSame('Test', 'Test');

		$output = @MbRegEx::replace('(', '', 'Test');
		$this->assertNull($output);
	}

	public function testSearch()
	{
		$match = MbRegEx::search('[\d]', 'Test1Test2Test3');
		$this->assertIsInt($match);
		$this->assertSame(4, $match);

		$match = MbRegEx::search('[\d]{2}', 'Test1Test2Test3');
		$this->assertNull($match);
	}

	public function testSearchAll()
	{
		$matches = MbRegEx::searchAll('[\d]', 'Test1Test2Test3');
		$this->assertIsArray($matches);
		$this->assertSame(3, count($matches));
		$this->assertIsInt($matches[0]);
		$this->assertSame(4, $matches[0]);
		$this->assertIsInt($matches[1]);
		$this->assertSame(9, $matches[1]);
		$this->assertIsInt($matches[2]);
		$this->assertSame(14, $matches[2]);

		$matches = MbRegEx::searchAll('[\d]{2}', 'Test1Test2Test3');
		$this->assertIsArray($matches);
		$this->assertEmpty($matches);
	}
}