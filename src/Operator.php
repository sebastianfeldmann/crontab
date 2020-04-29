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

use RuntimeException;
use SebastianFeldmann\Cli\Command\Runner;
use SebastianFeldmann\Crontab\Output\ListFormatter;

/**
 * Class Operator
 *
 * @package SebastianFeldmann\Crontab
 * @author  Sebastian Feldmann <sf@sebastian-feldmann.info>
 * @link    https://github.com/sebastianfeldmann/crontab
 * @since   Class available since Release 0.9.0
 */
class Operator
{
    /**
     * Path to crontab cli command.
     *
     * @var string
     */
    private $pathToCmd;

    /**
     * Runner to execute cli commands.
     *
     * @var \SebastianFeldmann\Cli\Command\Runner
     */
    private $runner;

    /**
     * Crontab command row parser.
     *
     * @var \SebastianFeldmann\Crontab\Parser
     */
    private $parser;

    /**
     * Username
     *
     * @var string
     */
    private $user;

    /**
     * Operator constructor.
     *
     * @param \SebastianFeldmann\Crontab\Parser     $parser
     * @param \SebastianFeldmann\Cli\Command\Runner $runner
     */
    public function __construct(Parser $parser = null, Runner $runner = null)
    {
        $this->parser = empty($parser) ? new Parser\Vixie()  : $parser;
        $this->runner = empty($runner) ? new Runner\Simple() : $runner;
    }

    /**
     * Set custom path to 'crontab' command.
     *
     * @param  string $pathToCmd
     * @return \SebastianFeldmann\Crontab\Operator
     */
    public function setCommandPath(string $pathToCmd): Operator
    {
        $this->pathToCmd = $pathToCmd;
        return $this;
    }

    /**
     * User setter.
     *
     * @param  string $user
     * @return \SebastianFeldmann\Crontab\Operator
     */
    public function setUser(string $user): Operator
    {
        $this->user = $user;
        return $this;
    }

    /**
     * Return list of crontab entries.
     *
     * @return \SebastianFeldmann\Crontab\Job[]
     * @throws \RuntimeException
     */
    public function getJobs(): array
    {
        $cmd     = new Cli\Executable();
        $cmdLine = $cmd->forUser($this->user)->createCommandLine();

        try {
            $result = $this->runner->run($cmdLine, new ListFormatter($this->parser));
        } catch (RuntimeException $e) {
            if (strpos($e->getMessage(), 'no crontab') !== false) {
                return [];
            }
            throw $e;
        }

        return $result->getFormattedOutput();
    }

    /**
     * Checks if a job is scheduled already.
     *
     * @param  \SebastianFeldmann\Crontab\Job $job    Job to search for.
     * @param  bool                           $strict If strict is true the schedule has to match as well.
     * @return bool
     */
    public function isJobScheduled(Job $job, bool $strict = true)
    {
        // get current job list
        foreach ($this->getJobs() as $activeJob) {
            if ($job->getCommand() == $activeJob->getCommand()) {
                if (!$strict || $job->getSchedule() == $activeJob->getSchedule()) {
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * Add a crontab entry to a users crontab.
     *
     * @param \SebastianFeldmann\Crontab\Job $entry
     */
    public function scheduleJob(Job $entry)
    {
        $exe = new Cli\Executable();
        $cmd = $exe->forUser($this->user)->addJob($entry)->createCommandLine();
        $this->runner->run($cmd);
    }
}
