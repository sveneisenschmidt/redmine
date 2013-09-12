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
 *
 * @group entity
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
        $entity = new \SE\Component\Redmine\Entity\CustomField\ScalarValue;
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
        $entity = new \SE\Component\Redmine\Entity\CustomField\ScalarValue;
        $value = sha1(uniqid(microtime(true), true));

        $this->assertNull($entity->getName());
        $entity->setName($value);
        $this->assertEquals($value, $entity->getName());
    }

    /**
     *
     * @test
     */
    public function Get_Set_Value_Scalar()
    {
        $entity = new \SE\Component\Redmine\Entity\CustomField\ScalarValue;
        $value = sha1(uniqid(microtime(true), true));

        $this->assertEmpty($entity->getValue());
        $entity->setValue($value);
        $this->assertEquals($value, $entity->getValue());
    }

    /**
     *
     * @test
     */
    public function Is_Multiple_Scalar_Default()
    {
        $entity = new \SE\Component\Redmine\Entity\CustomField\ScalarValue;
        $this->assertFalse($entity->isMultiple());
    }

    /**
     *
     * @test
     */
    public function Serialize_Scalar()
    {
        $entity = new \SE\Component\Redmine\Entity\CustomField\ScalarValue;

        $entity->setId(45);
        $entity->setName('Field Name');
        $entity->setValue('My Field Value');

        $expected = file_get_contents(__DIR__.'/Fixtures/custom_field_scalar.xml');
        $actual = $this->serializer->serialize($entity, 'xml');

        $this->assertEquals($expected, $actual);
    }

    /**
     *
     * @test
     */
    public function Serialize_Scalar_Empty()
    {
        $entity = new \SE\Component\Redmine\Entity\CustomField\ScalarValue;

        $expected = file_get_contents(__DIR__.'/Fixtures/custom_field_scalar_empty.xml');
        $actual = $this->serializer->serialize($entity, 'xml');

        $this->assertEquals($expected, $actual);
    }

    /**
     *
     * @test
     */
    public function Deserialize_Scalar()
    {
        $contents = file_get_contents(__DIR__.'/Fixtures/custom_field_scalar.xml');
        $entity = $this->serializer->deserialize($contents, 'SE\Component\Redmine\Entity\CustomField\ScalarValue', 'xml');

        $this->assertEquals(45, $entity->getId());
        $this->assertEquals('Field Name', $entity->getName());
        $this->assertEquals('My Field Value', $entity->getValue());
        $this->assertFalse($entity->isMultiple());

    }

    /**
     *
     * @test
     */
    public function Deserialize_Scalar_Empty()
    {
        $contents = file_get_contents(__DIR__.'/Fixtures/custom_field_scalar_empty.xml');
        $entity = $this->serializer->deserialize($contents, 'SE\Component\Redmine\Entity\CustomField\ScalarValue', 'xml');

        $this->assertNull($entity->getId());
        $this->assertNull($entity->getName());
        $this->assertNull($entity->getValue());
        $this->assertFalse($entity->isMultiple());
    }

    /**
     *
     * @test
     */
    public function Get_Set_Value_Array()
    {
        $entity = new \SE\Component\Redmine\Entity\CustomField\ArrayValue;
        $value = array(
            sha1(uniqid(microtime(true), true)),
            sha1(uniqid(microtime(true), true)),
            sha1(uniqid(microtime(true), true))
        );

        $this->assertEmpty($entity->getValue());
        $entity->setValue($value);
        $this->assertEquals($value, $entity->getValue());
    }

    /**
     *
     * @test
     */
    public function Is_Multiple_Array_Default()
    {
        $entity = new \SE\Component\Redmine\Entity\CustomField\ArrayValue;
        $this->assertTrue($entity->isMultiple());
    }

    /**
     *
     * @test
     */
    public function Serialize_Array()
    {
        $entity = new \SE\Component\Redmine\Entity\CustomField\ArrayValue;

        $entity->setId(45);
        $entity->setName('Field Name');
        $entity->setValue(array(1,2,3));
        $entity->setMultiple(true);

        $expected = file_get_contents(__DIR__.'/Fixtures/custom_field_array.xml');
        $actual = $this->serializer->serialize($entity, 'xml');

        $this->assertEquals($expected, $actual);
    }

    /**
     *
     * @test
     */
    public function Serialize_Empty_Array()
    {
        $entity = new \SE\Component\Redmine\Entity\CustomField\ArrayValue;

        $expected = file_get_contents(__DIR__.'/Fixtures/custom_field_array_empty.xml');
        $actual = $this->serializer->serialize($entity, 'xml');

        $this->assertEquals($expected, $actual);
    }

    /**
     *
     * @test
     */
    public function Deserialize_Array()
    {
        $contents = file_get_contents(__DIR__.'/Fixtures/custom_field_array.xml');
        $entity = $this->serializer->deserialize($contents, 'SE\Component\Redmine\Entity\CustomField\ArrayValue', 'xml');

        $this->assertEquals(45, $entity->getId());
        $this->assertEquals('Field Name', $entity->getName());
        $this->assertEquals(array(1,2,3), $entity->getValue());
        $this->assertTrue($entity->isMultiple());

    }

    /**
     *
     * @test
     */
    public function Deserialize_Array_Empty()
    {
        $contents = file_get_contents(__DIR__.'/Fixtures/custom_field_array_empty.xml');
        $entity = $this->serializer->deserialize($contents, 'SE\Component\Redmine\Entity\CustomField\ArrayValue', 'xml');

        $this->assertNull($entity->getId());
        $this->assertNull($entity->getName());
        $this->assertEquals(array(), $entity->getValue());
        $this->assertTrue($entity->isMultiple());
    }
}