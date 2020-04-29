<?php

/**
 * This file is part of SebastianFeldmann\Crontab.
 *
 * (c) Sebastian Feldmann <sf@sebastian-feldmann.info>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SebastianFeldmann\Crontab;

use PHPUnit\Framework\TestCase;

/**
 * Class JobTest
 *
 * @package SebastianFeldmann\Crontab
 */
class JobTest extends TestCase
{
    /**
     * Tests Job::getSchedule
     */
    public function testGetSchedule()
    {
        $job = new Job('* * * * *', 'echo 1');
        $this->assertEquals('* * * * *', $job->getSchedule());
    }

    /**
     * Tests Job::getCommand
     */
    public function testGetCommand()
    {
        $job = new Job('* * * * *', 'echo 1');
        $this->assertEquals('echo 1', $job->getCommand());
    }

    /**
     * Tests Job::getComments
     */
    public function testGetComments()
    {
        $job = new Job('* * * * *', 'echo 1', ['foo']);
        $this->assertEquals(['foo'], $job->getComments());
    }


    /**
     * Tests Job::__toString
     */
    public function testGetToString()
    {
        $job = new Job('* * * * *', 'echo 1', ['foo']);
        $this->assertEquals(
            '# foo' . PHP_EOL . '* * * * * echo 1' . PHP_EOL,
            (string) $job
        );
    }
}
