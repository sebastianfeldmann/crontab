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

/**
 * Class Job
 *
 * @package SebastianFeldmann\Crontab
 * @author  Sebastian Feldmann <sf@sebastian-feldmann.info>
 * @link    https://github.com/sebastianfeldmann/crontab
 * @since   Class available since Release 0.9.0
 */
class Job
{
    /**
     * Cron schedule expression.
     *
     * @var string
     */
    private $schedule;

    /**
     * Command that should get executed.
     *
     * @var string
     */
    private $command;

    /**
     * List of comments to describe the command.
     *
     * @var array
     */
    private $comments;

    /**
     * Entry constructor.
     *
     * @param string $schedule
     * @param string $command
     * @param array  $comments
     */
    public function __construct(string $schedule, string $command, array $comments = [])
    {
        $this->schedule = $schedule;
        $this->command  = $command;
        $this->comments = $comments;
    }

    public function getSchedule(): string
    {
        return $this->schedule;
    }

    /**
     * Return the command executed by the crontab entry.
     *
     * @return string
     */
    public function getCommand(): string
    {
        return $this->command;
    }

    /**
     * Return comment list.
     *
     * @return array
     */
    public function getComments(): array
    {
        return $this->comments;
    }

    /**
     * Return comments as string.
     * All lines get prefixed with '# '
     *
     * @return string
     */
    public function formatComments(): string
    {
        $doc = '';
        foreach ($this->comments as $comment) {
            $doc .=   '# ' . $comment . PHP_EOL;
        }
        return $doc;
    }

    /**
     * Magic to string method.
     *
     * @return string
     */
    public function __toString(): string
    {
        return $this->formatComments() . $this->schedule . ' ' . $this->command . PHP_EOL;
    }
}
