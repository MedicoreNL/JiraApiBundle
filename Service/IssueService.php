<?php

namespace JiraApiBundle\Service;

use Guzzle\Http\Client;
use Guzzle\Http\Exception\BadResponseException;
use Guzzle\Http\Exception\ClientErrorResponseException;

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
     * @return array|bool
     */
    public function get($key, $params = array())
    {
        try{
            return $this->performQuery(
                $this->createUrl(
                    sprintf('issue/%s', $key),
                    $params
                )
            );
        } catch (ClientErrorResponseException $ex) {
            return false;
        }
    }
}
