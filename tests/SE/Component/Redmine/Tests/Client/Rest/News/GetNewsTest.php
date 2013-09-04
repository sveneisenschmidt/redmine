<?php
/**
 * This file is part of the Redmine php library
 *
 * (c) Sven Eisenschmidt <sven.eisenschmidt@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace SE\Component\Redmine\Tests\Client\Rest\News;


/**
 *
 * @package SE\Component\Redmine\Tests
 * @author Sven Eisenschmidt <sven.eisenschmidt@gmail.com>
 *
 * @group client
 * @group rest
 * @group news
 */
class GetNewsTest extends \PHPUnit_Framework_TestCase
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
    public function Get_News_With_Default_Values()
    {
        $plugin = new \Guzzle\Plugin\Mock\MockPlugin(array(
            new \Guzzle\Http\Message\Response(200, null, file_get_contents(__DIR__.'/Fixtures/news.get.default.xml'))
        ));
        $this->restClient->getHttpClient()->addSubscriber($plugin);

        $collection = $this->restClient->getRepository('news')->findAll();
        $request = $this->history->getLastRequest();
        $this->assertNotNull($request);
        $this->assertEquals('/news.xml', $request->getPath());

        $this->assertInstanceOf('\SE\Component\Redmine\Entity\Collection\News', $collection);
        $this->assertEquals(25, $collection->getLimit());
        $this->assertEquals(3, $collection->getTotalCount());
        $this->assertEquals(0, $collection->getOffset());

        $news = $collection->getNews();
        $this->assertCount(3, $news);

        $entity = array_shift($news);
        $this->assertEquals(1, $entity->getId());
        $this->assertInstanceOf('\SE\Component\Redmine\Entity\Relation\Author', $entity->getAuthor());
        $this->assertInstanceOf('\SE\Component\Redmine\Entity\Relation\Project', $entity->getProject());

        $this->assertEquals(97, $entity->getProject()->getId());
        $this->assertEquals('Redmine', $entity->getProject()->getName());

        $this->assertEquals(99, $entity->getAuthor()->getId());
        $this->assertEquals('Sven Eisenschmidt', $entity->getAuthor()->getName());

        $this->assertEquals('Redmine PHP Api 0.1 released #1', $entity->getTitle());
        $this->assertEquals('Redmine PHP Api 0.1 has been released', $entity->getDescription());
        $this->assertEmpty($entity->getSummary());

    }

    /**
     *
     * @test
     */
    public function Get_News_With_Limit()
    {
        $plugin = new \Guzzle\Plugin\Mock\MockPlugin(array(
            new \Guzzle\Http\Message\Response(200, null, file_get_contents(__DIR__.'/Fixtures/news.get.limit.xml'))
        ));
        $this->restClient->getHttpClient()->addSubscriber($plugin);

        $collection = $this->restClient->getRepository('news')->findAll(array(
            'limit' => 1
        ));
        $request = $this->history->getLastRequest();

        $this->assertNotNull($request);
        $this->assertEquals('limit=1', (string)$request->getQuery());
        $this->assertEquals('/news.xml', $request->getPath());

        $this->assertInstanceOf('\SE\Component\Redmine\Entity\Collection\News', $collection);
        $this->assertEquals(1, $collection->getLimit());
        $this->assertEquals(3, $collection->getTotalCount());
        $this->assertEquals(0, $collection->getOffset());
    }

    /**
     *
     * @test
     */
    public function Get_News_With_Project()
    {
        $plugin = new \Guzzle\Plugin\Mock\MockPlugin(array(
            new \Guzzle\Http\Message\Response(200, null, file_get_contents(__DIR__.'/Fixtures/news.get.project.xml'))
        ));
        $this->restClient->getHttpClient()->addSubscriber($plugin);

        $collection = $this->restClient->getRepository('news')->findAll(array(
            'project_id' =>'test-project',
            'limit' => 10
        ));
        $request = $this->history->getLastRequest();

        $this->assertNotNull($request);
        $this->assertEquals('project_id=test-project&limit=10', (string)$request->getQuery());
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

        $collection = $this->restClient->getRepository('news')->findAll();
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

        $collection = $this->restClient->getRepository('news')->findAll();
    }
}