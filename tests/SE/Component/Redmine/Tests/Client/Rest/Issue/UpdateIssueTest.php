<?php
/**
 * This file is part of the Redmine php library
 *
 * (c) Sven Eisenschmidt <sven.eisenschmidt@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace SE\Component\Redmine\Tests\Client\Rest\Issue;


/**
 *
 * @package SE\Component\Redmine\Tests
 * @author Sven Eisenschmidt <sven.eisenschmidt@gmail.com>
 *
 * @group client
 * @group rest
 * @group issues
 * @group update
 */
class UpdateIssueTest extends \PHPUnit_Framework_TestCase
{
    /**
     *
     * @var \SE\Component\Redmine\Client\Rest\RestClient
     */
    protected $restClient;

    public function setUp()
    {
        $baseUrl = 'http://localhost/';
        $apiKey = sha1(uniqid(microtime(true), true));
        $http = new \Guzzle\Http\Client;

        $this->restClient = new \SE\Component\Redmine\Client\Rest\RestClient($http, $baseUrl, $apiKey);
    }

    /**
     *
     * @test
     */
    public function Update_Issue_From_Entity()
    {
        $subject = 'My_Subject_'.sha1(uniqid(microtime(true), true));
        $description = 'My_Description_'.sha1(uniqid(microtime(true), true));

        $contents = str_replace(
            array('%NEW_TITLE%', '%CONTROL_VALUE%'),
            array($subject, $description),
            file_get_contents(__DIR__.'/Fixtures/issue.update.default.xml')
        );

        $plugin = new \Guzzle\Plugin\Mock\MockPlugin(array(
            new \Guzzle\Http\Message\Response(200, null, file_get_contents(__DIR__.'/Fixtures/issue.get.default.xml')),
            new \Guzzle\Http\Message\Response(200, null, file_get_contents(__DIR__.'/Fixtures/issue.get.default.xml')),
            new \Guzzle\Http\Message\Response(200, null, $contents),
        ));
        $this->restClient->getHttpClient()->addSubscriber($plugin);

        $issue = $this->restClient->getRepository('issues')->find(1);

        // should be the original Title after the update
        // ensures the entity gets persisted and updated with the new entity
        $issue->setSubject($subject);
        $this->restClient->getRepository('issues')->persist($issue);;

        $this->assertEquals($subject, $issue->getSubject());
        $this->assertEquals($description, $issue->getDescription());
    }
}