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
 * Interface Parser
 *
 * @package SebastianFeldmann\Crontab
 * @author  Sebastian Feldmann <sf@sebastian-feldmann.info>
 * @link    https://github.com/sebastianfeldmann/crontab
 * @since   Class available since Release 0.9.0
 */
interface Parser
{
    /**
     * Parse a crontab command row.
     *
     * @param  string $row
     * @return \SebastianFeldmann\Crontab\Parser\Result
     */
    public function parse(string $row): Parser\Result;
}
