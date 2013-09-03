<?php
/**
 * This file is part of the Redmine php library
 *
 * (c) Sven Eisenschmidt <sven.eisenschmidt@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace SE\Component\Redmine\Tests;


/**
 *
 * @package SE\Component\Redmine\Tests
 * @author Sven Eisenschmidt <sven.eisenschmidt@gmail.com>
 *
 * @group live
 */
class LiveTest extends \PHPUnit_Framework_TestCase
{

    /**
     *
     * @\SE\Component\Redmine\Client\Rest\RestClient
     */
    protected $client;

    public function setUp()
    {
        $this->client = new \SE\Component\Redmine\Client\Rest\RestClient(
            new \Guzzle\Http\Client,
            TESTS_REDMINE_REST_BASE_URL,
            TESTS_REDMINE_REST_API_KEY
        );

        $this->client->setHttpAuth(
            TESTS_REDMINE_REST_HTTP_USER,
            TESTS_REDMINE_REST_HTTP_PASS
        );
    }

    /**
     *
     * @test
     */
    public function Can_Authenticate()
    {
        $collection = $this->client->getNews('', 1);
        $this->assertLessThanOrEqual(1, $collection->count());
    }

    /**
     *
     * @test
     */
    public function Can_Load_News()
    {
        $collection = $this->client->getNews('', 5);
        $this->assertLessThanOrEqual(5, $collection->count());

        if($collection->count() >= 1) {
            foreach($collection->getNews() as $news) {
                $this->assertNotNull($news->getAuthor());
                $this->assertNotNull($news->getProject());
                $this->assertNotNull($news->getTitle());

                $this->assertInternalType('integer', $news->getId());
                $this->assertInternalType('string', $news->getTitle());
                $this->assertInternalType('string', $news->getDescription());
                $this->assertInternalType('string', $news->getSummary());

                $this->assertInstanceOf('\DateTime', $news->getCreatedOn());
                $this->assertInstanceOf('\SE\Component\Redmine\Entity\AuthorRelation', $news->getAuthor());
                $this->assertInstanceOf('\SE\Component\Redmine\Entity\ProjectRelation', $news->getProject());
            }
        } else {
            $this->markTestSkipped('No news found for testing.');
        }
    }
}
