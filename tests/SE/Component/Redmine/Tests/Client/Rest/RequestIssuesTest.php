<?php
/**
 * This file is part of the Redmine php library
 *
 * (c) Sven Eisenschmidt <sven.eisenschmidt@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace SE\Component\Redmine\Tests\Client\Rest;


/**
 *
 * @package SE\Component\Redmine\Tests
 * @author Sven Eisenschmidt <sven.eisenschmidt@gmail.com>
 */
class RequestIssuesTest extends \PHPUnit_Framework_TestCase
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
    public function Get_Issues_With_Default_Values()
    {
        $plugin = new \Guzzle\Plugin\Mock\MockPlugin(array(
            new \Guzzle\Http\Message\Response(200, null, file_get_contents(__DIR__.'/Fixtures/issues.get.default.xml'))
        ));
        $this->restClient->getHttpClient()->addSubscriber($plugin);

        $collection = $this->restClient->getIssues();
        $request = $this->history->getLastRequest();
        $this->assertNotNull($request);
        $this->assertEquals('limit=25', $request->getQuery());
        $this->assertEquals('/issues.xml', $request->getPath());

        $this->assertInstanceOf('\SE\Component\Redmine\Entity\Collection\Issue', $collection);
        $this->assertEquals(25, $collection->getLimit());
        $this->assertEquals(3, $collection->getTotalCount());
        $this->assertEquals(0, $collection->getOffset());
        $this->assertEquals(3, $collection->count());

        $issues = $collection->getIssues();
        $this->assertCount(3, $issues);

        $entity = array_shift($issues);
        $this->assertEquals(4326, $entity->getId());
        $this->assertInstanceOf('\SE\Component\Redmine\Entity\Relation\Author', $entity->getAuthor());
        $this->assertInstanceOf('\SE\Component\Redmine\Entity\Relation\Project', $entity->getProject());
        $this->assertInstanceOf('\SE\Component\Redmine\Entity\Relation\Status', $entity->getStatus());
        $this->assertInstanceOf('\SE\Component\Redmine\Entity\Relation\Category', $entity->getCategory());
        $this->assertInstanceOf('\SE\Component\Redmine\Entity\Relation\Priority', $entity->getPriority());
        $this->assertInstanceOf('\SE\Component\Redmine\Entity\Relation\Tracker', $entity->getTracker());
    }

    /**
     *
     * @test
     */
    public function Get_Issues_With_Limit()
    {
        $plugin = new \Guzzle\Plugin\Mock\MockPlugin(array(
            new \Guzzle\Http\Message\Response(200, null, file_get_contents(__DIR__.'/Fixtures/issues.get.limit.xml'))
        ));
        $this->restClient->getHttpClient()->addSubscriber($plugin);

        $collection = $this->restClient->getIssues(1);
        $request = $this->history->getLastRequest();

        $this->assertNotNull($request);
        $this->assertEquals('limit=1', $request->getQuery());
        $this->assertEquals('/issues.xml', $request->getPath());

        $this->assertInstanceOf('\SE\Component\Redmine\Entity\Collection\Issue', $collection);
        $this->assertEquals(1, $collection->getLimit());
        $this->assertEquals(3, $collection->getTotalCount());
        $this->assertEquals(0, $collection->getOffset());
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

        $collection = $this->restClient->getIssues();
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

        $collection = $this->restClient->getIssues();
    }
}