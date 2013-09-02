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
class AuthorRelationTest extends \PHPUnit_Framework_TestCase
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
        $entity = new \SE\Component\Redmine\Entity\AuthorRelation;
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
        $entity = new \SE\Component\Redmine\Entity\AuthorRelation;
        $hash = sha1(uniqid(microtime(true), true));

        $this->assertNull($entity->getName());
        $entity->setName($hash);
        $this->assertEquals($hash, $entity->getName());
    }
}