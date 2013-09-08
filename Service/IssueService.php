<?php

namespace JiraApiBundle\Service;

use Guzzle\Http\Client;
use Guzzle\Http\Exception\BadResponseException;

/**
 * Service class that manages issues.
 */
class IssueService extends AbstractService
{    
    /**
     * Retrieve details for a specific issue.
     * 
     * @param string $key
     * 
     * @return array
     */
    public function get($key)
    {
        return $this->performQuery(
            $this->createUrl(
                sprintf('issue/%s', $key)
            )
        );
    }
}
