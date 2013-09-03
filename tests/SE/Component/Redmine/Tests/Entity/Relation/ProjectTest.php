<?php
/**
 * This file is part of the Redmine php library
 *
 * (c) Sven Eisenschmidt <sven.eisenschmidt@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace SE\Component\Redmine\Tests\Entity\Relation;


/**
 *
 * @package SE\Component\Redmine\Tests
 * @author Sven Eisenschmidt <sven.eisenschmidt@gmail.com>
 */
class ProjectTest extends \PHPUnit_Framework_TestCase
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
        $entity = new \SE\Component\Redmine\Entity\Relation\Project;
        $hash = sha1(uniqid(microtime(true), true));

        $this->assertNull($entity->getId());
        $entity->setId($hash);
        $this->assertEquals($hash, $entity->getId());
    }

    /**
     *
     * @test
     */
    public function Get_Set_Name()
    {
        $entity = new \SE\Component\Redmine\Entity\Relation\Project;
        $hash = sha1(uniqid(microtime(true), true));

        $this->assertNull($entity->getName());
        $entity->setName($hash);
        $this->assertEquals($hash, $entity->getName());
    }

    /**
     *
     * @test
     */
    public function Serialize()
    {
        $entity = new \SE\Component\Redmine\Entity\Relation\Project;
        $entity->setId(1);
        $entity->setName('REST');

        $expected = file_get_contents(__DIR__.'/Fixtures/project_relation.xml');
        $actual = $this->serializer->serialize($entity, 'xml');

        $this->assertEquals($expected, $actual);
    }

    /**
     *
     * @test
     */
    public function Serialize_Empty()
    {
        $entity = new \SE\Component\Redmine\Entity\Relation\Project;

        $expected = file_get_contents(__DIR__.'/Fixtures/project_relation_empty.xml');
        $actual = $this->serializer->serialize($entity, 'xml');

        $this->assertEquals($expected, $actual);
    }

    /**
     *
     * @test
     */
    public function Deserialize()
    {
        $contents = file_get_contents(__DIR__.'/Fixtures/project_relation.xml');
        $entity = $this->serializer->deserialize($contents, 'SE\Component\Redmine\Entity\Relation\Project', 'xml');

        $this->assertEquals(1, $entity->getId());
        $this->assertEquals('REST', $entity->getName());
    }

    /**
     *
     * @test
     */
    public function Deserialize_Empty()
    {
        $contents = file_get_contents(__DIR__.'/Fixtures/project_relation_empty.xml');
        $entity = $this->serializer->deserialize($contents, 'SE\Component\Redmine\Entity\Relation\Project', 'xml');

        $this->assertNull($entity->getId());
        $this->assertNull($entity->getName());
    }
}