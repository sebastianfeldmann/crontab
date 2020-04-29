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
 * Class Result
 *
 * @package SebastianFeldmann\Crontab
 * @author  Sebastian Feldmann <sf@sebastian-feldmann.info>
 * @link    https://github.com/sebastianfeldmann/crontab
 * @since   Class available since Release 0.9.0
 */
class Result
{
    /**
     * @var string
     */
    public $min;

    /**
     * @var string
     */
    public $hour;

    /**
     * @var string
     */
    public $day;

    /**
     * @var string
     */
    public $month;

    /**
     * @var string
     */
    public $dayOfWeek;

    /**
     * @var string
     */
    public $year;

    /**
     * @var string
     */
    public $user;

    /**
     * @var string
     */
    public $command;

    /**
     * Result constructor.
     */
    public function __construct()
    {
        $this->min       = '';
        $this->hour      = '';
        $this->day       = '';
        $this->month     = '';
        $this->dayOfWeek = '';
        $this->year      = '';
        $this->user      = '';
        $this->command   = '';
    }

    /**
     * Return cron expression.
     *
     * @return string
     */
    public function getSchedule(): string
    {
        $schedule  = $this->min . ' ' . $this->hour . ' ' . $this->day . ' ' . $this->month . ' ' . $this->dayOfWeek;
        $schedule .= !empty($this->year) ? ' ' . $this->year : '';

        return $schedule;
    }
}
