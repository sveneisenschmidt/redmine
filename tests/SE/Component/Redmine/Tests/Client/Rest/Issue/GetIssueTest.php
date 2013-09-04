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
 */
class GetIssueTest extends \PHPUnit_Framework_TestCase
{
    /**
     *
     * @var \SE\Component\Redmine\Client\Rest\RestClient
     */
    protected $restClient ;

    public function setUp()
    {
        $this->history = new \Guzzle\Plugin\History\HistoryPlugin;
        $httpClient = new \Guzzle\Http\Client();
        $httpClient->addSubscriber($this->history);
        $baseUrl = 'http://localhost/';
        $apiKey = sha1(uniqid(microtime(true), true));
        $this->restClient = new \SE\Component\Redmine\Client\Rest\RestClient($httpClient, $baseUrl, $apiKey);
    }

    /**
     *
     * @test
     */
    public function Get_Issue()
    {
        $plugin = new \Guzzle\Plugin\Mock\MockPlugin(array(
            new \Guzzle\Http\Message\Response(200, null, file_get_contents(__DIR__.'/Fixtures/issue.get.default.xml'))
        ));
        $this->restClient->getHttpClient()->addSubscriber($plugin);

        $issue = $this->restClient->getRepository('issues')->find(1);

        $this->assertNotNull($issue->getAuthor());
        $this->assertNotNull($issue->getProject());
        $this->assertNotNull($issue->getTracker());
        $this->assertNotNull($issue->getSubject());
        $this->assertNotNull($issue->getAssignedTo());
        $this->assertNotNull($issue->getStatus());
        $this->assertNotNull($issue->getPriority());
        $this->assertNotNull($issue->getCategory());

        $this->assertInternalType('integer', $issue->getId());
        $this->assertInternalType('string', $issue->getSubject());
        $this->assertInternalType('string', $issue->getDescription());

        $this->assertInstanceOf('\DateTime', $issue->getCreatedOn());
        $this->assertInstanceOf('\DateTime', $issue->getUpdatedOn());
        $this->assertInstanceOf('\SE\Component\Redmine\Entity\Relation\Author', $issue->getAuthor());
        $this->assertInstanceOf('\SE\Component\Redmine\Entity\Relation\Project', $issue->getProject());
        $this->assertInstanceOf('\SE\Component\Redmine\Entity\Relation\Status', $issue->getStatus());
        $this->assertInstanceOf('\SE\Component\Redmine\Entity\Relation\Tracker', $issue->getTracker());
        $this->assertInstanceOf('\SE\Component\Redmine\Entity\Relation\Category', $issue->getCategory());
        $this->assertInstanceOf('\SE\Component\Redmine\Entity\Relation\Priority', $issue->getPriority());
    }

    /**
     *
     * @test
     * @expectedException \Guzzle\Http\Exception\ClientErrorResponseException
     */
    public function Server_Returns_Error_404()
    {
        $plugin = new \Guzzle\Plugin\Mock\MockPlugin(array(
            new \Guzzle\Http\Message\Response(404)
        ));
        $this->restClient->getHttpClient()->addSubscriber($plugin);

        $issue = $this->restClient->getRepository('issues')->find(rand(99999,999999));
    }

    /**
     *
     * @test
     * @expectedException \Guzzle\Http\Exception\ServerErrorResponseException
     */
    public function Server_Returns_Error_500()
    {
        $plugin = new \Guzzle\Plugin\Mock\MockPlugin(array(
            new \Guzzle\Http\Message\Response(500)
        ));
        $this->restClient->getHttpClient()->addSubscriber($plugin);

        $issue = $this->restClient->getRepository('issues')->find(rand(99999,999999));
    }
}