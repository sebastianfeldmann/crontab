<?php

namespace SebastianFeldmann\Crontab\Output;

use SebastianFeldmann\Cli\Command\OutputFormatter;
use SebastianFeldmann\Crontab\Job;
use SebastianFeldmann\Crontab\Parser;

class ListFormatter implements OutputFormatter
{
    const ROW_TYPE_EMPTY   = 1;
    const ROW_TYPE_COMMENT = 2;
    const ROW_TYPE_COMMAND = 4;

    /**
     * Buffer of comments for a command row.
     *
     * @var array
     */
    private $commentBuffer;

    /**
     * List of jobs.
     * @var \SebastianFeldmann\Crontab\Job[]
     */
    private $entries;

    /**
     * @var \SebastianFeldmann\Crontab\Parser
     */
    private $parser;

    /**
     * ListFormatter constructor.
     *
     * @param \SebastianFeldmann\Crontab\Parser $parser
     */
    public function __construct(Parser $parser)
    {
        $this->parser = $parser;
    }

    /**
     * Format the output.
     *
     * @param  array $output
     * @return iterable
     */
    public function format(array $output)
    {
        $this->clearCommentBuffer();
        $this->entries = [];

        foreach ($output as $row) {
            $this->handleRow($row);
        }

        return $this->entries;
    }

    /**
     * Check row type and process row.
     *
     * @param string $row
     */
    protected function handleRow(string $row)
    {
        switch($this->getRowType($row)) {
            case self::ROW_TYPE_EMPTY:
                $this->clearCommentBuffer();
                break;
            case self::ROW_TYPE_COMMENT:
                $this->commentBuffer[] = $row;
                break;
            case self::ROW_TYPE_COMMAND:
                $this->entries[] = $this->createEntry($row);
                break;
        }
    }

    /**
     * Determine the row type.
     *   - empty
     *   - comment
     *   - command
     *
     * @param  string $row
     * @return int
     */
    private function getRowType(string $row)
    {
        // remove leading and trailing whitespaces
        $row = trim($row);
        // empty is empty is empty
        if (empty($row)) {
            return self::ROW_TYPE_EMPTY;
        }
        // comment lines should start with a '#'
        if (substr($row, 0, 1) === '#') {
            return self::ROW_TYPE_COMMENT;
        }
        // row is not empty and doesn't start with a #
        // should be a command line
        return self::ROW_TYPE_COMMAND;
    }

    /**
     * Reset the comment buffer.
     */
    protected function clearCommentBuffer()
    {
        $this->commentBuffer = [];
    }

    /**
     * Return current comment buffer and resets it.
     *
     * @return array
     */
    protected function flushCommentBuffer() : array
    {
        $buffer = $this->commentBuffer;
        $this->clearCommentBuffer();
        return $buffer;
    }

    /**
     * Creates a crontab job from a crontab row string.
     *
     * @param  string $row
     * @return \SebastianFeldmann\Crontab\Job
     */
    protected function createEntry(string $row) : Job
    {
        $result = $this->parser->parse($row);
        return new Job($result->getSchedule(), $result->command, $this->flushCommentBuffer());
    }
}
