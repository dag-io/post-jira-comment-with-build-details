<?php
namespace DAG\JIRA\Post;

use InvalidArgumentException;

/**
 * Class IssueKeyResolver
 */
final class IssueKeyResolver
{
    /**
     * @param string $branchName
     *
     * @return string
     *
     * @throws InvalidArgumentException
     */
    public function resolveKeyFromBranchName($branchName)
    {
        $groups = [];
        if (preg_match('@^(feature|hotfix)/([\w]+\-[\w]+)\-.*@', $branchName, $groups)) {
            return $groups[2];
        } else if (preg_match('@^([\w]+\-[\w]+)\-.*@', $branchName, $groups)) {
            return $groups[1];
        } else if (preg_match('@^(release)/[\w\.]+\-([\w]+\-[\w]+)\-.*@', $branchName, $groups)) {
            return $groups[2];
        }

        throw new InvalidArgumentException(
            sprintf('The branch name "%s" is not valid', $branchName)
        );
    }
}
