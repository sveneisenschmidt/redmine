<?php
/**
 * This file is part of the Redmine php library
 *
 * (c) Sven Eisenschmidt <sven.eisenschmidt@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace SE\Component\Redmine\Tests\Entity\Collection;


/**
 *
 * @package SE\Component\Redmine\Tests
 * @author Sven Eisenschmidt <sven.eisenschmidt@gmail.com>
 *
 * @group entity
 * @group news
 * @group collection
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
    public function Get_Set_Limit()
    {
        $entity = new \SE\Component\Redmine\Entity\Collection\News;
        $value = rand(1,100);

        $this->assertequals(0, $entity->getLimit());
        $entity->setLimit($value);
        $this->assertEquals($value, $entity->getLimit());
    }

    /**
     *
     * @test
     */
    public function Get_Set_Offset()
    {
        $entity = new \SE\Component\Redmine\Entity\Collection\News;
        $value = rand(1,100);

        $this->assertEquals(0, $entity->getOffset());
        $entity->setOffset($value);
        $this->assertEquals($value, $entity->getOffset());
    }

    /**
     *
     * @test
     */
    public function Get_Set_Total_Count()
    {
        $entity = new \SE\Component\Redmine\Entity\Collection\News;
        $value = rand(1,100);

        $this->assertEquals(0, $entity->getTotalCount());
        $entity->setTotalCount($value);
        $this->assertEquals($value, $entity->getTotalCount());
    }

    /**
     *
     * @test
     */
    public function Add_News()
    {
        $entity = new \SE\Component\Redmine\Entity\Collection\News;
        $news = array(
            new \SE\Component\Redmine\Entity\News,
            new \SE\Component\Redmine\Entity\News,
            new \SE\Component\Redmine\Entity\News
        );

        $entity->setNews($news);
        $this->assertSame($news, $entity->getNews());
        $this->assertEquals(3, $entity->count());
    }

    /**
     *
     * @test
     */
    public function Serialize()
    {
        $entity = new \SE\Component\Redmine\Entity\Collection\News;
        $entity->setLimit(25);
        $entity->setOffset(0);
        $entity->setTotalCount(3);

        $entity->setNews(array(
            new \SE\Component\Redmine\Entity\News,
            new \SE\Component\Redmine\Entity\News,
            new \SE\Component\Redmine\Entity\News
        ));

        $expected = file_get_contents(__DIR__.'/Fixtures/news_collection.xml');
        $actual = $this->serializer->serialize($entity, 'xml');

        $this->assertEquals($expected, $actual);
        $this->assertEquals(3, $entity->count());
    }

    /**
     *
     * @test
     */
    public function Serialize_Empty()
    {
        $entity = new \SE\Component\Redmine\Entity\Collection\News;

        $expected = file_get_contents(__DIR__.'/Fixtures/news_collection_empty.xml');
        $actual = $this->serializer->serialize($entity, 'xml');

        $this->assertEquals($expected, $actual);
        $this->assertEquals(0, $entity->count());
    }

    /**
     *
     * @test
     */
    public function Deserialize()
    {
        $contents = file_get_contents(__DIR__.'/Fixtures/news_collection.xml');
        $entity = $this->serializer->deserialize($contents, 'SE\Component\Redmine\Entity\Collection\News', 'xml');

        $this->assertEquals(25, $entity->getLimit());
        $this->assertEquals(3, $entity->getTotalCount());
        $this->assertEquals(0, $entity->getOffset());
        $this->assertNotEmpty($entity->getNews());
        $this->assertEquals(3, $entity->count());
    }

    /**
     *
     * @test
     */
    public function Deserialize_Empty()
    {
        $contents = file_get_contents(__DIR__.'/Fixtures/news_collection_empty.xml');
        $entity = $this->serializer->deserialize($contents, 'SE\Component\Redmine\Entity\Collection\News', 'xml');

        $this->assertEquals(0, $entity->getLimit());
        $this->assertEquals(0, $entity->getTotalCount());
        $this->assertEquals(0, $entity->getOffset());
        $this->assertEmpty($entity->getNews());
        $this->assertEquals(0, $entity->count());
    }
}