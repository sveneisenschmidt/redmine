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
 * @group client
 * @group rest
 */
class EntityNormalizerTest extends \PHPUnit_Framework_TestCase
{
    /**
     *
     * @test
     */
    public function Can_Be_Instantiated()
    {
        $serializer = $this->getMock('\JMS\Serializer\Serializer', array(), array(), '', false);
        $normalizer = new \SE\Component\Redmine\Client\Rest\EntityNormalizer($serializer);

        $this->assertSame($serializer, $normalizer->getSerializer());
    }

    /**
     *
     * @test
     */
    public function Get_Root_Key()
    {
        $serializer = $this->getMock('\JMS\Serializer\Serializer', array(), array(), '', false);
        $normalizer = new \SE\Component\Redmine\Client\Rest\EntityNormalizer($serializer);

        $object = new \SE\Component\Redmine\Entity\Issue;
        $this->assertEquals('issue', $normalizer->getRootKey($object));
    }

    /**
     *
     * @test
     * @expectedException \SE\Component\Redmine\Client\Rest\Exception\MissingAnnotationException
     */
    public function Get_Root_Key_Fails()
    {
        $object = new \SE\Component\Redmine\Tests\Client\Rest\Fixture\MissingXmlRootNodeFixture;

        $serializer = $this->getMock('\JMS\Serializer\Serializer', array(), array(), '', false);
        $normalizer = new \SE\Component\Redmine\Client\Rest\EntityNormalizer($serializer);

        $normalizer->getRootKey($object);
    }

    /**
     *
     * @test
     */
    public function To_Array()
    {
        $object = new \stdClass();
        $object->hash = sha1(uniqid(microtime(true), true));

        $serializer = $this->getMock('\JMS\Serializer\Serializer', array(), array(), '', false);
        $normalizer = new \SE\Component\Redmine\Client\Rest\EntityNormalizer($serializer);

        $serializer->expects($this->once())
            ->method('serialize')
            ->with($object, 'json')
            ->will($this->returnValue('{"hash": "'.$object->hash.'"}'));

        $data = $normalizer->toArray($object);
        $this->assertEquals(array('hash' => $object->hash), $data);
    }

    /**
     *
     * @test
     */
    public function To_Data()
    {
        $serializer = \JMS\Serializer\SerializerBuilder::create()->build();
        $normalizer = new \SE\Component\Redmine\Client\Rest\EntityNormalizer($serializer);

        $id = rand(1,9999);
        $author = new \SE\Component\Redmine\Entity\Relation\Author;
        $author->setId($id);

        $object = new \SE\Component\Redmine\Entity\Issue;
        $object->setId($id);
        $object->setAuthor($author);

        $data = $normalizer->toData($object);
        $this->assertEquals(['id' => $id, 'author_id' => $id], $data);
    }
}
