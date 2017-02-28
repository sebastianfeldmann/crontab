<?php
/**
 * This file is part of SebastianFeldmann\Crontab.
 *
 * (c) Sebastian Feldmann <sf@sebastian-feldmann.info>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace SebastianFeldmann\Crontab\Cli;

use SebastianFeldmann\Cli\Command\Executable as CliExecutable;
use SebastianFeldmann\Cli\CommandLine;
use SebastianFeldmann\Cli\Util;
use SebastianFeldmann\Crontab\Job;

/**
 * Class Executable
 *
 * @package SebastianFeldmann\Crontab
 */
class Executable
{
    /**
     * Path to crontab command.
     *
     * @var string
     */
    private $cmd;

    /**
     * Username.
     *
     * @var string
     */
    private $user = '';

    /**
     * Show current crontab
     * -l
     *
     * @var bool
     */
    private $listJobs = false;

    /**
     * Job to schedule.
     *
     * @var \SebastianFeldmann\Crontab\Job
     */
    private $job;

    /**
     * Executable constructor.
     *
     * @param string $path
     */
    public function __construct(string $path = '')
    {
        $this->cmd = Util::detectCmdLocation('crontab', $path);
    }

    /**
     * User setter.
     *
     * @param  string $user
     * @return \SebastianFeldmann\Crontab\Cli\Executable
     */
    public function forUser(string $user) : Executable
    {
        $this->user = $user;
        return $this;
    }

    /**
     *List option setter.
     *
     * @param  bool $bool
     * @return \SebastianFeldmann\Crontab\Cli\Executable
     */
    public function listJobs(bool $bool = true) : Executable
    {
        $this->listJobs = $bool;
        return $this;
    }

    /**
     * Add a crontab entry to the current crontab.
     *
     * @param  \SebastianFeldmann\Crontab\Job $job
     * @return \SebastianFeldmann\Crontab\Cli\Executable
     */
    public function addJob(Job $job) : Executable
    {
        $this->job = $job;
        return $this;
    }

    /**
     * Create the command line to execute the crontab commands.
     *
     * @return \SebastianFeldmann\Cli\CommandLine
     */
    public function createCommandLine() : CommandLine
    {
        $line = new CommandLine();
        $cmd  = new CliExecutable($this->cmd);
        $line->addCommand($cmd);
        $cmd->addOptionIfNotEmpty('-u', $this->user, true, ' ');

        if (empty($this->job)) {
            $cmd->addOptionIfNotEmpty('-l', $this->listJobs, false);
        } else {
            // echo current crontab
            $cmd->addOption('-l');
            // echo new job
            $echo = new CliExecutable('echo');
            $echo->addArgument((string) $this->job);
            $line->addCommand($echo);

            // pipe both outputs to new crontab
            $pipe = new CliExecutable($this->cmd);
            $pipe->addOptionIfNotEmpty('-u', $this->user, true, ' ')
                 ->addOption('-');
            $line->pipeOutputTo($pipe);
        }

        return $line;
    }
}
