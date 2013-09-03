<?php
/**
 * This file is part of the Redmine php library
 *
 * (c) Sven Eisenschmidt <sven.eisenschmidt@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace SE\Component\Redmine\Tests\Entity;


/**
 *
 * @package SE\Component\Redmine\Tests
 * @author Sven Eisenschmidt <sven.eisenschmidt@gmail.com>
 */
class NewsTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->serializer = \JMS\Serializer\SerializerBuilder::create()->build();
    }

    /**
     *
     * @test
     */
    public function Get_Set_Id()
    {
        $entity = new \SE\Component\Redmine\Entity\News;
        $value = rand(1,100);

        $this->assertNull($entity->getId());
        $entity->setId($value);
        $this->assertEquals($value, $entity->getId());
    }

    /**
     *
     * @test
     */
    public function Get_Set_Title()
    {
        $entity = new \SE\Component\Redmine\Entity\News;
        $value = sha1(uniqid(microtime(true), true));

        $this->assertNull($entity->getTitle());
        $entity->setTitle($value);
        $this->assertEquals($value, $entity->getTitle());
    }

    /**
     *
     * @test
     */
    public function Get_Set_Summary()
    {
        $entity = new \SE\Component\Redmine\Entity\News;
        $value = sha1(uniqid(microtime(true), true));

        $this->assertNull($entity->getSummary());
        $entity->setSummary($value);
        $this->assertEquals($value, $entity->getSummary());
    }

    /**
     *
     * @test
     */
    public function Get_Set_Description()
    {
        $entity = new \SE\Component\Redmine\Entity\News;
        $value = sha1(uniqid(microtime(true), true));

        $this->assertNull($entity->getDescription());
        $entity->setDescription($value);
        $this->assertEquals($value, $entity->getDescription());
    }

    /**
     *
     * @test
     */
    public function Get_Set_Author()
    {
        $entity = new \SE\Component\Redmine\Entity\News;
        $author = new \SE\Component\Redmine\Entity\Relation\Author();

        $this->assertNull($entity->getAuthor());
        $entity->setAuthor($author);
        $this->assertSame($author, $entity->getAuthor());
    }

    /**
     *
     * @test
     */
    public function Get_Set_Project()
    {
        $entity = new \SE\Component\Redmine\Entity\News;
        $project = new \SE\Component\Redmine\Entity\Relation\Project();

        $this->assertNull($entity->getProject());
        $entity->setProject($project);
        $this->assertSame($project, $entity->getProject());
    }

    /**
     *
     * @test
     */
    public function Get_Set_Created_On()
    {
        $entity = new \SE\Component\Redmine\Entity\News;
        $value = new \DateTime('2013-01-01 00:00:00 +00:00');

        $this->assertNull($entity->getCreatedOn());
        $entity->setCreatedOn($value);
        $this->assertSame($value, $entity->getCreatedOn());
    }

    /**
     *
     * @test
     */
    public function Serialize()
    {
        $entity = new \SE\Component\Redmine\Entity\News;
        $entity->setTitle('Title #1');
        $entity->setSummary('Summary #2');
        $entity->setDescription('Description #3');
        $entity->setCreatedOn(new \DateTime('2013-01-01 00:00:00 +00:00'));

        $author = new \SE\Component\Redmine\Entity\Relation\Author();
        $author->setId(33);
        $author->setName('Jane Smith');
        $entity->setAuthor($author);

        $project = new \SE\Component\Redmine\Entity\Relation\Project();
        $project->setId(97);
        $project->setName('Test Project');
        $entity->setProject($project);

        $expected = file_get_contents(__DIR__.'/Fixtures/news.xml');
        $actual = $this->serializer->serialize($entity, 'xml');

        $this->assertEquals($expected, $actual);
    }

    /**
     *
     * @test
     */
    public function Serialize_Empty()
    {
        $entity = new \SE\Component\Redmine\Entity\News;

        $expected = file_get_contents(__DIR__.'/Fixtures/news_empty.xml');
        $actual = $this->serializer->serialize($entity, 'xml');

        $this->assertEquals($expected, $actual);
    }

    /**
     *
     * @test
     */
    public function Deserialize()
    {
        $contents = file_get_contents(__DIR__.'/Fixtures/news.xml');
        $entity = $this->serializer->deserialize($contents, 'SE\Component\Redmine\Entity\News', 'xml');

        $this->assertEquals('Title #1', $entity->getTitle());
        $this->assertEquals('Summary #2', $entity->getSummary());
        $this->assertEquals('Description #3', $entity->getDescription());
        $this->assertEquals(new \DateTime('2013-01-01 00:00:00 +00:00'), $entity->getCreatedOn());
        $this->assertEquals(33, $entity->getAuthor()->getId());
        $this->assertEquals(97, $entity->getProject()->getId());
        $this->assertEquals('Jane Smith', $entity->getAuthor()->getName());
        $this->assertEquals('Test Project', $entity->getProject()->getName());
    }

    /**
     *
     * @test
     */
    public function Deserialize_Empty()
    {
        $contents = file_get_contents(__DIR__.'/Fixtures/news_empty.xml');
        $entity = $this->serializer->deserialize($contents, 'SE\Component\Redmine\Entity\News', 'xml');

        $this->assertNull($entity->getTitle());
        $this->assertNull($entity->getDescription());
        $this->assertNull($entity->getSummary());
        $this->assertNull($entity->getCreatedOn());
        $this->assertNull($entity->getAuthor());
        $this->assertNull($entity->getProject());
    }
}