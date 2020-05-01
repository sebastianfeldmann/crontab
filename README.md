# Crontab


[![Latest Stable Version](https://poser.pugx.org/sebastianfeldmann/crontab/v/stable.svg)](https://packagist.org/packages/sebastianfeldmann/crontab)
[![Minimum PHP Version](https://img.shields.io/badge/php-%3E%3D%207.1-8892BF.svg)](https://php.net/)
[![Downloads](https://img.shields.io/packagist/dt/sebastianfeldmann/crontab.svg?v1)](https://packagist.org/packages/sebastianfeldmann/crontab)
[![License](https://poser.pugx.org/sebastianfeldmann/crontab/license.svg)](https://packagist.org/packages/sebastianfeldmann/crontab)
[![Build Status](https://github.com/sebastianfeldmann/git/workflows/CI-Build/badge.svg)](https://github.com/sebastianfeldmann/crontab/actions)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/sebastianfeldmann/crontab/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/sebastianfeldmann/crontab/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/sebastianfeldmann/crontab/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/sebastianfeldmann/crontab/?branch=master)

## Features

Lists all cron jobs with a nice OO interface. Add jobs to your crontab.


## Requirements

* PHP >= 7.0
* POSIX Shell with crontab command

## Installation

Installing *crontab* via Composer.

```json
  "require": {
    "sebastianfeldmann/crontab": "~1.0"
  }
```

## Usage

### Read crontab
```php
$crontab = new SebastianFeldmann\Crontab\Operator();
foreach ($crontab->getJobs() as $job) {
    echo "Description: . PHP_EOL . implode(PHP_EOL, $job->getComments()) . PHP_EOL;
    echo "Schedule: " . PHP_EOL . $job->getSchedule() . PHP_EOL;
    echo "Command: " . PHP_EOL . $job->getCommand() . PHP_EOL;
}
```

### Add job to crontab
```php
$crontab = new SebastianFeldmann\Crontab\Operator();
$crontab->addJob(
    new SebastianFeldmann\Crontab\Job(
        '30 4 * * *',
        '/foo/bar/binary',
        ['Some foo bar binary execution']
    )
);
```
This will add the following lines to your crontab.
```
# Some foobar binary execution
30 4 * * * /foo/bar/binary
```

The crontab parser is looking for commands and their description in the lines above the command.
The parser expects commands to **NOT** spread over multiple lines with \\.
```
# Descriptoon for some command
10 23 * * * some command

# Next Command Description
# even more description for the next command
30 5 * * * next command
```
