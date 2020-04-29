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
 * Class ResultTest
 *
 * @package SebastianFeldmann\Crontab
 */
class ResultTest extends \PHPUnit\Framework\TestCase
{
    /**
     * Tests Result::getSchedule
     */
    public function testGetSchedule()
    {
        $result = new Result();
        $result->min       = '1';
        $result->hour      = '3';
        $result->day       = '12';
        $result->month     = '*';
        $result->dayOfWeek = '*';

        $this->assertEquals('1 3 12 * *', $result->getSchedule());
    }
}
