<?php
namespace DAG\JIRA\Post\Command;

use DAG\JIRA\Post\IssueKeyResolver;
use Jira_Api;
use Jira_Api_Authentication_Basic;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class PostMessageCommand
 */
final class PostMessageCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('post-message')
            ->setDescription('Post the message on JIRA')
            ->addArgument(
                'git-branch',
                InputArgument::REQUIRED
            )
            ->addArgument(
                'jira-user',
                InputArgument::REQUIRED
            )
            ->addArgument(
                'jira-password',
                InputArgument::REQUIRED
            )
            ->addArgument(
                'jira-build-message',
                InputArgument::REQUIRED
            )
            ->addArgument(
                'jira-endpoint',
                InputArgument::REQUIRED
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $api = new Jira_Api(
            $input->getArgument('jira-endpoint'),
            new Jira_Api_Authentication_Basic(
                $input->getArgument('jira-user'),
                $input->getArgument('jira-password')
            )
        );

        $issueKeyResolver = new IssueKeyResolver();
        $issueKey = $issueKeyResolver->resolveKeyFromBranchName(
            $input->getArgument('git-branch')
        );

        $api->addComment($issueKey, $input->getArgument('jira-build-message'));
    }
}
