<?php
/**
 * This file is part of SebastianFeldmann\Crontab.
 *
 * (c) Sebastian Feldmann <sf@sebastian-feldmann.info>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace SebastianFeldmann\Crontab\Output;

use SebastianFeldmann\Crontab\Parser\Vixie;
use PHPUnit\Framework\TestCase;

/**
 * Class ListFormatterTest
 *
 * @package SebastianFeldmann\Crontab
 */
class ListFormatterTest extends TestCase
{
    /**
     * Tests ListFormatter::format
     */
    public function testFormat()
    {
        $formatter = new ListFormatter(new Vixie());
        $formatted = $formatter->format([
           '# foo',
           '# bar',
           '10 4 * * * echo 1',
           '',
           '# fiz',
           '',
           '# baz',
           '20 4 * * * echo 2',
        ]);

        $this->assertCount(2, $formatted);
        $this->assertEquals('10 4 * * *', $formatted[0]->getSchedule());
        $this->assertEquals('echo 1', $formatted[0]->getCommand());
        $this->assertCount(2, $formatted[0]->getComments());
    }
}
