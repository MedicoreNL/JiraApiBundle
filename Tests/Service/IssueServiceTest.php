<?php

namespace JiraApiBundle\Tests\Service;

use JiraApiBundle\Tests\TestCase;
use JiraApiBundle\Service\IssueService;

class IssueServiceTest extends TestCase
{
    public function testGetIssueDetails()
    {        
        $issueJsonFile = __DIR__ . '/../assets/response/issue.json';
        $issueService = new IssueService($this->getClientMock($issueJsonFile));                
        $issueDetails = $issueService->getIssueDetails('TD-945');     
        $this->assertEquals('TD-945', $issueDetails['key']);
        $this->assertEquals('Bug', $issueDetails['fields']['issuetype']['name']);
    }
   
}
