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
class RequestNewsTest extends \PHPUnit_Framework_TestCase
{
    /**
     *
     * @var \SE\Component\Redmine\Client\Rest\RestClient
     */
    protected $restClient ;

    public function setUp()
    {
        $httpClient = new \Guzzle\Http\Client();
        $baseUrl = 'http://localhost/redmine';
        $apiKey = sha1(uniqid(microtime(true), true));
        $this->restClient = new \SE\Component\Redmine\Client\Rest\RestClient($httpClient, $baseUrl, $apiKey);
    }

    /**
     *
     * @test
     */
    public function Get_News_With_Default_Values()
    {
        $response = new \Guzzle\Http\Message\Response(200, null,
            file_get_contents(__DIR__.'/Fixtures/news.get.default.xml'));
        $plugin = new \Guzzle\Plugin\Mock\MockPlugin();
        $plugin->addResponse($response);
        $this->restClient->getHttpClient()->addSubscriber($plugin);

        $collection = $this->restClient->getNews();

        $this->assertInstanceOf('\SE\Component\Redmine\Entity\NewsCollection', $collection);
        $this->assertEquals(25, $collection->getLimit());
        $this->assertEquals(3, $collection->getTotalCount());
        $this->assertEquals(0, $collection->getOffset());

        $news = $collection->getNews();
        $this->assertCount(3, $news);

        $entity = array_shift($news);
        $this->assertEquals(1, $entity->getId());
        $this->assertInstanceOf('\SE\Component\Redmine\Entity\AuthorRelation', $entity->getAuthor());
        $this->assertInstanceOf('\SE\Component\Redmine\Entity\ProjectRelation', $entity->getProject());

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
        $response = new \Guzzle\Http\Message\Response(200, null,
            file_get_contents(__DIR__.'/Fixtures/news.get.limit.xml'));
        $plugin = new \Guzzle\Plugin\Mock\MockPlugin();
        $plugin->addResponse($response);
        $this->restClient->getHttpClient()->addSubscriber($plugin);

        $collection = $this->restClient->getNews('', 1);

        $this->assertInstanceOf('\SE\Component\Redmine\Entity\NewsCollection', $collection);
        $this->assertEquals(25, $collection->getLimit());
        $this->assertEquals(1, $collection->getTotalCount());
        $this->assertEquals(0, $collection->getOffset());
    }

    /**
     *
     * @test
     */
    public function Get_News_With_Porjekt()
    {
        $response = new \Guzzle\Http\Message\Response(200, null,
            file_get_contents(__DIR__.'/Fixtures/news.get.project.xml'));
        $plugin = new \Guzzle\Plugin\Mock\MockPlugin();
        $plugin->addResponse($response);
        $this->restClient->getHttpClient()->addSubscriber($plugin);

        $collection = $this->restClient->getNews('test-project');


    }
}