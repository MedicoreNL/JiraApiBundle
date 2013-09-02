<?php

namespace JiraApiBundle\Tests\Service;

use JiraApiBundle\Tests\TestCase;
use JiraApiBundle\Service\IssueService;

class IssueServiceTest extends TestCase
{
    public function testIssueServiceGetAll()
    {        
        $jsonFile = __DIR__ . '/../assets/response/issue.json';

        $service = new IssueService(
            $this->getClientMock($jsonFile)
        );

        $result = $service->getAll('TD-945');

        $this->assertEquals('TD-945', $result['key']);
        $this->assertEquals('Bug', $result['fields']['issuetype']['name']);
    }

    public function testIssueServiceGetAllException()
    {
        $service = new IssueService($this->getClientMockException());

        $result = $service->getAll('PROJECT', 'repository', 'branch');

        $this->assertEquals(false, $result);
    }

    public function testIssueServiceGetAllNoData()
    {
        $service = new IssueService($this->getClientMockNoData());

        $result = $service->getAll('PROJECT', 'repository', 'branch');

        $this->assertEquals(false, $result);
    }
}
