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
 *
 * @group live
 * @group client
 * @group rest
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
     */
    public function Can_Authenticate()
    {
        $collection = $this->client->getRepository('news')->findAll(array(
            'limit' => 1
        ));

        $this->assertLessThanOrEqual(1, $collection->count());
    }

    /**
     *
     */
    public function Can_Load_News()
    {
        $collection = $this->client->getRepository('news')->findAll(array(
            'limit' => 5
        ));

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
                $this->assertInstanceOf('\SE\Component\Redmine\Entity\Relation\Author', $news->getAuthor());
                $this->assertInstanceOf('\SE\Component\Redmine\Entity\Relation\Project', $news->getProject());
            }
        } else {
            $this->markTestSkipped('No news found for testing.');
        }
    }

    /**
     *
     */
    public function Can_Load_Issues()
    {
        $collection = $this->client->getRepository('issues')->findAll(array(
            'limit' => 5
        ));

        $this->assertLessThanOrEqual(5, $collection->count());

        if($collection->count() >= 1) {
            foreach($collection->getIssues() as $issue) {
                $this->assertNotNull($issue->getAuthor());
                $this->assertNotNull($issue->getProject());
                $this->assertNotNull($issue->getTracker());
                $this->assertNotNull($issue->getSubject());

                $this->assertInternalType('integer', $issue->getId());
                $this->assertInternalType('string', $issue->getSubject());
                $this->assertInternalType('string', $issue->getDescription());

                $this->assertInstanceOf('\DateTime', $issue->getCreatedOn());
                $this->assertInstanceOf('\DateTime', $issue->getUpdatedOn());
                $this->assertInstanceOf('\SE\Component\Redmine\Entity\Relation\Author', $issue->getAuthor());
                $this->assertInstanceOf('\SE\Component\Redmine\Entity\Relation\Project', $issue->getProject());
                $this->assertInstanceOf('\SE\Component\Redmine\Entity\Relation\Status', $issue->getStatus());
                $this->assertInstanceOf('\SE\Component\Redmine\Entity\Relation\Tracker', $issue->getTracker());
            }
        } else {
            $this->markTestSkipped('No issues found for testing.');
        }
    }

    /**
     *
     */
    public function Can_Load_Issue()
    {
        $repository = $this->client->getRepository('issues');
        $collection = $repository->findAll(array(
            'limit' => 1
        ));

        $this->assertLessThanOrEqual(1, $collection->count());

        if($collection->count() >= 1) {
            $issues = $collection->getIssues();
            $proxy = array_shift($issues);
            $issue = $repository->find($proxy->getId());

            $this->assertNotNull($issue->getAuthor());
            $this->assertNotNull($issue->getProject());
            $this->assertNotNull($issue->getTracker());
            $this->assertNotNull($issue->getSubject());

            $this->assertInternalType('integer', $issue->getId());
            $this->assertInternalType('string', $issue->getSubject());
            $this->assertInternalType('string', $issue->getDescription());

            $this->assertInstanceOf('\DateTime', $issue->getCreatedOn());
            $this->assertInstanceOf('\DateTime', $issue->getUpdatedOn());
            $this->assertInstanceOf('\SE\Component\Redmine\Entity\Relation\Author', $issue->getAuthor());
            $this->assertInstanceOf('\SE\Component\Redmine\Entity\Relation\Project', $issue->getProject());
            $this->assertInstanceOf('\SE\Component\Redmine\Entity\Relation\Status', $issue->getStatus());
            $this->assertInstanceOf('\SE\Component\Redmine\Entity\Relation\Tracker', $issue->getTracker());

        } else {
            $this->markTestSkipped('No issues found for retrieving a valid issue for testing.');
        }
    }

    /**
     *
     * @test
     */
    public function Can_Create_Issue()
    {
        $project = new \SE\Component\Redmine\Entity\Relation\Project;
        $project->setId(TESTS_REDMINE_REST_PROJECT_ID);

        $tracker = new \SE\Component\Redmine\Entity\Relation\Tracker;
        $tracker->setId(TESTS_REDMINE_REST_TRACKER_ID);

        $issue = new \SE\Component\Redmine\Entity\Issue;
        $issue->setSubject('Some Test Ticket');
        $issue->setDescription("Welcome \n\n This is your first ticket.");
        $issue->setProject($project);
        $issue->setTracker($tracker);

        $this->assertNull($issue->getId());
        $this->client->getRepository('issues')->persist($issue);
        $this->assertNotNull($issue->getId());
    }
}
