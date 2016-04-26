#!/usr/bin/env php
<?php

require __DIR__.'/vendor/autoload.php';

use DAG\JIRA\Post\Command\PostMessageCommand;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\ArgvInput;

$input = new ArgvInput(
    [
        basename(__FILE__),
        'post-message',
        $_SERVER['git_branch'],
        $_SERVER['jira_user'],
        $_SERVER['jira_password'],
        $_SERVER['jira_build_message'],
        $_SERVER['jira_domain'],
    ]
);

$application = new Application(
    'Post JIRA comment with build details',
    '@package_version@'
);
$application->add(new PostMessageCommand());
$application->run($input);
