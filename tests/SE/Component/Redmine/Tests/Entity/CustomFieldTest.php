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
class CustomFieldTest extends \PHPUnit_Framework_TestCase
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
        $entity = new \SE\Component\Redmine\Entity\CustomField;
        $value = rand(1,100);

        $this->assertNull($entity->getId());
        $entity->setId($value);
        $this->assertEquals($value, $entity->getId());
    }

    /**
     *
     * @test
     */
    public function Get_Set_Name()
    {
        $entity = new \SE\Component\Redmine\Entity\CustomField;
        $value = sha1(uniqid(microtime(true), true));

        $this->assertNull($entity->getName());
        $entity->setName($value);
        $this->assertEquals($value, $entity->getName());
    }

    /**
     *
     * @test
     */
    public function Get_Set_Value()
    {
        $entity = new \SE\Component\Redmine\Entity\CustomField;
        $value = sha1(uniqid(microtime(true), true));

        $this->assertNull($entity->getValue());
        $entity->setValue($value);
        $this->assertEquals($value, $entity->getValue());
    }

    /**
     *
     * @test
     */
    public function Is_Multiple_Default()
    {
        $entity = new \SE\Component\Redmine\Entity\CustomField;
        $this->assertFalse($entity->isMultiple());
    }

    /**
     *
     * @test
     */
    public function Serialize()
    {
        $entity = new \SE\Component\Redmine\Entity\CustomField;

        $entity->setId(45);
        $entity->setName('Field Name');
        $entity->setValue('My Field Value');

        $expected = file_get_contents(__DIR__.'/Fixtures/custom_field.xml');
        $actual = $this->serializer->serialize($entity, 'xml');

        $this->assertEquals($expected, $actual);
    }

    /**
     *
     * @test
     */
    public function Serialize_Empty()
    {
        $entity = new \SE\Component\Redmine\Entity\CustomField;

        $expected = file_get_contents(__DIR__.'/Fixtures/custom_field_empty.xml');
        $actual = $this->serializer->serialize($entity, 'xml');

        $this->assertEquals($expected, $actual);
    }

    /**
     *
     * @test
     */
    public function Deserialize()
    {
        $contents = file_get_contents(__DIR__.'/Fixtures/custom_field.xml');
        $entity = $this->serializer->deserialize($contents, 'SE\Component\Redmine\Entity\CustomField', 'xml');

        $this->assertEquals(45, $entity->getId());
        $this->assertEquals('Field Name', $entity->getName());
        $this->assertEquals('My Field Value', $entity->getValue());
        $this->assertFalse($entity->isMultiple());

    }

    /**
     *
     * @test
     */
    public function Deserialize_Empty()
    {
        $contents = file_get_contents(__DIR__.'/Fixtures/custom_field_empty.xml');
        $entity = $this->serializer->deserialize($contents, 'SE\Component\Redmine\Entity\CustomField', 'xml');

        $this->assertNull($entity->getId());
        $this->assertNull($entity->getName());
        $this->assertNull($entity->getValue());
        $this->assertFalse($entity->isMultiple());
    }
}