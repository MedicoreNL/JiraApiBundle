<?php

namespace JiraApiBundle\Service;

use Guzzle\Http\Client;
use Guzzle\Http\Exception\BadResponseException;

/**
 * Service class that deals with 'Issues' related JIRA apis.
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
    public function getAll($key)
    {
        $url = $this->createUrl(sprintf('issue/%s', $key));

        $result = $this->getResponseAsArray($url);

        return $result;
    }
}
