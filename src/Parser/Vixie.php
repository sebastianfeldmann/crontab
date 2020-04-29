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

use SebastianFeldmann\Crontab\Parser;

/**
 * Class Vixie
 * The default cron implementation for most linux distributions.
 * https://de.wikipedia.org/wiki/Cron
 *
 * @package SebastianFeldmann\Crontab
 * @author  Sebastian Feldmann <sf@sebastian-feldmann.info>
 * @link    https://github.com/sebastianfeldmann/crontab
 * @since   Class available since Release 0.9.0
 */
class Vixie implements Parser
{
    /**
     * Should the parser look for a year value.
     *
     * @var bool
     */
    private $expectYear;

    /**
     * Should the parser expect a user value.
     *
     * @var bool
     */
    private $expectUser;

    /**
     * Look for a year value.
     *
     * @param  bool $bool
     * @return \SebastianFeldmann\Crontab\Parser\Vixie
     */
    public function expectYear(bool $bool = true)
    {
        $this->expectYear = $bool;
        return $this;
    }

    /**
     * Look for a user value.
     *
     * @param  bool $bool
     * @return \SebastianFeldmann\Crontab\Parser\Vixie
     */
    public function expectUser(bool $bool = true)
    {
        $this->expectUser = $bool;
        return $this;
    }

    /**
     * Parse a crontab command row.
     *
     * @param  string $row
     * @return \SebastianFeldmann\Crontab\Parser\Result
     */
    public function parse(string $row): Result
    {
        $row    = trim($row);
        $result = new Result();
        $data   = preg_split('/\s+/', $row);
        foreach ($this->getParts() as $index => $part) {
            $result->$part = $data[$index];
            unset($data[$index]);
        }
        // we have to keep the original whitespaces within the command
        $cmd    = '';
        $spaces = preg_split('/[^\s]+/', $row);
        foreach ($data as $index => $part) {
            $cmd .= $part . $spaces[$index + 1];
        }
        $result->command = trim($cmd);

        return $result;
    }

    /**
     * Return list of expected parts.
     *
     * @return array
     */
    protected function getParts()
    {
        $parts = ['min', 'hour', 'day', 'month', 'dayOfWeek'];

        if ($this->expectYear) {
            $parts[] = 'year';
        }
        if ($this->expectUser) {
            $parts[] = 'user';
        }

        return $parts;
    }
}
