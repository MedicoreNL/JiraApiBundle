<?php

namespace JiraApiBundle\Service;

use Guzzle\Http\Client;
use Guzzle\Http\Exception\BadResponseException;

/**
 * Service class that deals with 'Project' related JIRA apis.
 */
class ProjectService extends AbstractService
{
    /**
     * Constructor.
     *
     * @param Guzzle\Http\Client $client 
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Method to retrieve all projects registered in Jira
     * 
     * @return boolean|array
     */
    public function getAllProjects()
    {
        $path = 'project';
        $url = $this->createUrl($path);

        try {
            $data = $this->getResponseAsArray($url);
        } catch (BadResponseException $ex) {
            return false;
        }

        return $data;
    }
}
