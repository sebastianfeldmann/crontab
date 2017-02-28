<?php
/**
 * This file is part of SebastianFeldmann\Crontab.
 *
 * (c) Sebastian Feldmann <sf@sebastian-feldmann.info>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace SebastianFeldmann\Crontab\Parser;

/**
 * Class ParserTest
 *
 * @package SebastianFeldmann\Crontab
 */
class ParserTest extends \PHPUnit\Framework\TestCase
{
    /**
     * Tests Vixie::parse
     */
    public function testParseRow()
    {
        $parser = new Vixie();

        $result = $parser->parse('* * * * * /foo/bar --option=\'    \'');

        $this->assertEquals('*', $result->min);
        $this->assertEquals('*', $result->hour);
        $this->assertEquals('*', $result->day);
        $this->assertEquals('*', $result->month);
        $this->assertEquals('*', $result->dayOfWeek);
        $this->assertEquals('/foo/bar --option=\'    \'', $result->command);
    }

    /**
     * Tests Vixie::parse
     */
    public function testParseRowWithYear()
    {
        $parser = new Vixie();
        $parser->expectYear();

        $result = $parser->parse('* * * * * * /foo/bar --option=\'    \'');

        $this->assertEquals('*', $result->min);
        $this->assertEquals('*', $result->hour);
        $this->assertEquals('*', $result->day);
        $this->assertEquals('*', $result->month);
        $this->assertEquals('*', $result->dayOfWeek);
        $this->assertEquals('*', $result->year);
        $this->assertEquals('/foo/bar --option=\'    \'', $result->command);
    }

    /**
     * Tests Vixie::parse
     */
    public function testParseRowWithUser()
    {
        $parser = new Vixie();
        $parser->expectUser();

        $result = $parser->parse('* * * * * root /foo/bar --option=\'    \'');

        $this->assertEquals('*', $result->min);
        $this->assertEquals('*', $result->hour);
        $this->assertEquals('*', $result->day);
        $this->assertEquals('*', $result->month);
        $this->assertEquals('*', $result->dayOfWeek);
        $this->assertEquals('root', $result->user);
        $this->assertEquals('/foo/bar --option=\'    \'', $result->command);
    }

    /**
     * Tests Vixie::parse
     */
    public function testParseRowWithYearAndUser()
    {
        $parser = new Vixie();
        $parser->expectUser()
               ->expectYear();

        $result = $parser->parse('* * * * * * root /foo/bar --option=\'    \'');

        $this->assertEquals('*', $result->min);
        $this->assertEquals('*', $result->hour);
        $this->assertEquals('*', $result->day);
        $this->assertEquals('*', $result->month);
        $this->assertEquals('*', $result->dayOfWeek);
        $this->assertEquals('*', $result->year);
        $this->assertEquals('root', $result->user);
        $this->assertEquals('/foo/bar --option=\'    \'', $result->command);
    }
}
