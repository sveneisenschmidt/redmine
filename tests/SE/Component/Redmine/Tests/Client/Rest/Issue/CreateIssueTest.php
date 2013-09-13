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
 * @group create
 */
class CreateIssueTest extends \PHPUnit_Framework_TestCase
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
        $httpClient = new \Guzzle\Http\Client;

        $this->restClient = new \SE\Component\Redmine\Client\Rest\RestClient($baseUrl, $apiKey, $httpClient);
    }

    /**
     *
     * @test
     */
    public function Create_Issue_From_Entity()
    {
        $plugin = new \Guzzle\Plugin\Mock\MockPlugin(array(
            new \Guzzle\Http\Message\Response(200, null, file_get_contents(__DIR__.'/Fixtures/issue.get.default.xml'))
        ));
        $this->restClient->getHttpClient()->addSubscriber($plugin);

        $author = new \SE\Component\Redmine\Entity\Relation\Author;
        $author->setId(1);
        $author->setName('John Smith');

        $issue = new \SE\Component\Redmine\Entity\Issue;
        $issue->setSubject('Some Test Ticket');
        $issue->setDescription("Welcome \n\n This is your first ticket.");
        $issue->setAuthor($author);

        $this->assertNull($issue->getId());
        $this->restClient->getRepository('issues')->persist($issue);
        $this->assertNotNull($issue->getId());
    }
}