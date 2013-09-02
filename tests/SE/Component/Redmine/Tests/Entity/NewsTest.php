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
        $author = new \SE\Component\Redmine\Entity\AuthorRelation();

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
        $project = new \SE\Component\Redmine\Entity\ProjectRelation();

        $this->assertNull($entity->getProject());
        $entity->setProject($project);
        $this->assertSame($project, $entity->getProject());
    }
}