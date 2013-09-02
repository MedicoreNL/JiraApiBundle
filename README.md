JiraApiBundle
=============

Master: [![Build Status](https://secure.travis-ci.org/MedicoreNL/JiraApiBundle.png?branch=master)](http://travis-ci.org/MedicoreNL/JiraApiBundle)

A [Symfony2](http://symfony.com) bundle that integrates the [Jira](https://www.atlassian.com/software/jira/overview) [REST API](https://developer.atlassian.com/jira/docs/latest/reference/rest-api.html) into native Symfony2 services.

Installation
------------

 1. Install [Composer](https://getcomposer.org).

    ```bash
    # Install Composer
    curl -sS https://getcomposer.org/installer | php
    ```

 2. Add this bundle to the `composer.json` file of your project.

    ```bash
    # Add JiraApiBundle as a dependency
    php composer.phar require medicorenl/jira-api-bundle dev-master
    ```
 3. After installing, you need to require Composer's autloader in the bootstrap of your project.

    ```php
    // app/autoload.php
    $loader = require __DIR__ . '/../vendor/autoload.php';
    ```

 4. Add the bundle to your application kernel.

    ```php
    // app/AppKernel.php
    public function registerBundles()
    {
        return array(
            // ...
            new JiraApiBundle\JiraApiBundle(),
            // ...
        );
    }
    ```

 5. Configure the bundle by adding parameters to the  `config.yml` file:

    ```yaml
    # app/config/config.yml
        jira_api.url:         "http://jira.your-organisation.com/jira/rest/api/latest/"
        jira_api.credentials: "username:password"
    ```

Usage
-----

This bundle contains a number of services, to access them through the service container:

```php
// Get the JiraApiBundle\Service\IssueService
$issueService = $this->get('jira_api.issue');
$issueService->searchBranch($project, $repository, $branch);

// Get the JiraApiBundle\Service\ProjectService
$projectService = $this->get('jira_api.project');
$projectService->getAll($project, $repository, $params);

// Get the JiraApiBundle\Service\SearchService
$searchService = $this->get('jira_api.search');
$searchService->getAll($project, $repository, $params);
```

You can also add them to the service container of your own bundle:

```xml
<!-- src/Project/Bundle/Resources/config/services.xml -->
<?xml version="1.0" encoding="UTF-8"?>
<container xmlns="http://symfony.com/schema/dic/services"
           xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
           xsi:schemaLocation="http://symfony.com/schema/dic/services http://symfony.com/schema/dic/services/services$
    <services>
        <service id="myproject.myservice" class="MyProject\MyBundle\Services\MyService.php" public="true">
            <argument type="service" id="jira_api.issue" />
            <argument type="service" id="jira_api.project" />
            <argument type="service" id="jira_api.search" />
        </service>
    </services>
</container>
```

You can then use them in your own services

```php
<?php

namespace Project\Bundle\Services;

use JiraApiBundle\Service\IssueService;
use JiraApiBundle\Service\ProjectService;
use JiraApiBundle\Service\SearchService;

/**
 * Service class for my bundle.
 */
class MyService
{
    /**
     * @var \JiraApiBundle\Service\IssueService
     */
    private $issueService;

    /**
     * @var \JiraApiBundle\Service\ProjectService
     */
    private $projectService;

    /**
     * @var \JiraApiBundle\Service\SearchService
     */
    private $searchService;

    /**
     * Constructor.
     *
     * @param \JiraApiBundle\Service\IssueService   $issueService
     * @param \JiraApiBundle\Service\ProjectService $projectService
     * @param \JiraApiBundle\Service\SearchService  $searchService
     */
    public function __construct(
        IssueService   $issueService,
        ProjectService $projectService,
        SearchService  $searchService,
    ) {
        $this->issueService   = $issueService;
        $this->projectService = $projectService;
        $this->searchService  = $searchService;
    }
}
```

Unit testing
------------

JiraApiBundle uses [PHP Unit](http://phpunit.de) for unit testing.

 1. Download PHP Unit.

    ```bash
    # Download PHP Unit
    wget http://pear.phpunit.de/get/phpunit.phar
    chmod +x phpunit.phar
    ```

 2. Make sure all dependencies are installed through Composer.

    ```bash
    # Install dependencies
    php composer.phar install
    ```

 3. Run the unit tests.

    ```bash
    # Run unit tests
    php phpunit.phar
    ```
