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
 * @group issues
 */
class IssueTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $builder = \JMS\Serializer\SerializerBuilder::create()->configureListeners(function($dispatcher) {
            $dispatcher->addSubscriber(new \SE\Component\Redmine\Client\Rest\EventSubscriber());
        });
        $this->serializer = $builder->build();
    }

    /**
     *
     * @test
     * @expectedException \BadMethodCallException
     */
    public function Get_Set_Id()
    {
        $entity = new \SE\Component\Redmine\Entity\Issue;
        $value = rand(1,100);

        $this->assertNull($entity->getId());
        $entity->setId($value);
        $this->assertEquals($value, $entity->getId());
        $entity->setId($value);
    }

    /**
     *
     * @test
     */
    public function Get_Set_Subject()
    {
        $entity = new \SE\Component\Redmine\Entity\Issue;
        $value = sha1(uniqid(microtime(true), true));

        $this->assertNull($entity->getSubject());
        $entity->setSubject($value);
        $this->assertEquals($value, $entity->getSubject());
    }

    /**
     *
     * @test
     */
    public function Get_Set_Description()
    {
        $entity = new \SE\Component\Redmine\Entity\Issue;
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
        $entity = new \SE\Component\Redmine\Entity\Issue;
        $author = new \SE\Component\Redmine\Entity\Relation\Author;

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
        $entity = new \SE\Component\Redmine\Entity\Issue;
        $value = new \SE\Component\Redmine\Entity\Relation\Project;

        $this->assertNull($entity->getProject());
        $entity->setProject($value);
        $this->assertSame($value, $entity->getProject());
    }

    /**
     *
     * @test
     */
    public function Get_Set_Status()
    {
        $entity = new \SE\Component\Redmine\Entity\Issue;
        $value = new \SE\Component\Redmine\Entity\Relation\Status;

        $this->assertNull($entity->getStatus());
        $entity->setStatus($value);
        $this->assertSame($value, $entity->getStatus());
    }

    /**
     *
     * @test
     */
    public function Get_Set_Category()
    {
        $entity = new \SE\Component\Redmine\Entity\Issue;
        $value = new \SE\Component\Redmine\Entity\Relation\Category;

        $this->assertNull($entity->getCategory());
        $entity->setCategory($value);
        $this->assertSame($value, $entity->getCategory());
    }

    /**
     *
     * @test
     */
    public function Get_Set_Tracker()
    {
        $entity = new \SE\Component\Redmine\Entity\Issue;
        $value = new \SE\Component\Redmine\Entity\Relation\Tracker;

        $this->assertNull($entity->getTracker());
        $entity->setTracker($value);
        $this->assertSame($value, $entity->getTracker());
    }

    /**
     *
     * @test
     */
    public function Get_Set_Priority()
    {
        $entity = new \SE\Component\Redmine\Entity\Issue;
        $value = new \SE\Component\Redmine\Entity\Relation\Priority;

        $this->assertNull($entity->getProject());
        $entity->setPriority($value);
        $this->assertSame($value, $entity->getPriority());
    }


    /**
     *
     * @test
     * @expectedException \BadMethodCallException
     */
    public function Get_Set_Created_On()
    {
        $entity = new \SE\Component\Redmine\Entity\Issue;
        $value = new \DateTime('2013-01-01 00:00:00 +00:00');

        $this->assertNull($entity->getCreatedOn());
        $entity->setCreatedOn($value);
        $this->assertSame($value, $entity->getCreatedOn());
        $entity->setCreatedOn($value);
    }

    /**
     *
     * @test
     * @expectedException \BadMethodCallException
     */
    public function Get_Set_Updated_On()
    {
        $entity = new \SE\Component\Redmine\Entity\Issue;
        $value = new \DateTime('2013-01-01 00:00:00 +00:00');

        $this->assertNull($entity->getUpdatedOn());
        $entity->setUpdatedOn($value);
        $this->assertSame($value, $entity->getUpdatedOn());
        $entity->setUpdatedOn($value);
    }

    /**
     *
     * @test
     */
    public function Get_Set_Start_Date()
    {
        $entity = new \SE\Component\Redmine\Entity\Issue;
        $value = '2013-01-01';

        $this->assertNull($entity->getStartDate());
        $entity->setStartDate($value);
        $this->assertSame($value, $entity->getStartDate());
    }

    /**
     *
     * @test
     */
    public function Get_Set_Due_Date()
    {
        $entity = new \SE\Component\Redmine\Entity\Issue;
        $value = '2013-08-01';

        $this->assertNull($entity->getDueDate());
        $entity->setDueDate($value);
        $this->assertSame($value, $entity->getDueDate());
    }

    /**
     *
     * @test
     */
    public function Get_Set_Done_Ratio()
    {
        $entity = new \SE\Component\Redmine\Entity\Issue;
        $value = rand(1,100);

        $this->assertNull($entity->getDoneRatio());
        $entity->setDoneRatio($value);
        $this->assertSame($value, $entity->getDoneRatio());
    }

    /**
     *
     * @test
     */
    public function Get_Set_Estimated_Hours()
    {
        $entity = new \SE\Component\Redmine\Entity\Issue;
        $value = rand(1,10);

        $this->assertNull($entity->getEstimatedHours());
        $entity->setEstimatedHours($value);
        $this->assertSame($value, $entity->getEstimatedHours());
    }

    /**
     *
     * @test
     */
    public function Get_Set_Custom_Fields()
    {
        $entity = new \SE\Component\Redmine\Entity\Issue;
        $value = new \SE\Component\Redmine\Entity\Collection\CustomFields(array(
            new \SE\Component\Redmine\Entity\CustomField\ScalarField,
            new \SE\Component\Redmine\Entity\CustomField\ListField,
            new \SE\Component\Redmine\Entity\CustomField\ListField
        ));

        $this->assertEmpty($entity->getCustomFields());
        $entity->setCustomFields($value);
        $this->assertSame($value, $entity->getCustomFields());
    }

    /**
     *
     * @test
     */
    public function Serialize_Default()
    {
        $entity = new \SE\Component\Redmine\Entity\Issue;

        $entity->setId(99);
        $entity->setSubject('Test Issue #1');
        $entity->setDescription('Test Description #2');
        $entity->setEstimatedHours(60);
        $entity->setDoneRatio(50);
        $entity->setStartDate('2013-01-01');
        $entity->setDueDate('2013-08-01');
        $entity->setCreatedOn(new \DateTime('2013-01-01 00:00:00 +00:00'));
        $entity->setUpdatedOn(new \DateTime('2013-08-01 00:00:00 +00:00'));

        $author = new \SE\Component\Redmine\Entity\Relation\Author;
        $author->setId(99);
        $author->setName('Jon Smith');
        $entity->setAuthor($author);

        $assignedTo = new \SE\Component\Redmine\Entity\Relation\AssignedTo;
        $assignedTo->setId(52);
        $assignedTo->setName('Jane Doe');
        $entity->setAssignedTo($assignedTo);

        $project = new \SE\Component\Redmine\Entity\Relation\Project;
        $project->setId(98);
        $project->setName('Test Project');
        $entity->setProject($project);

        $tracker = new \SE\Component\Redmine\Entity\Relation\Tracker;
        $tracker->setId(97);
        $tracker->setName('Ticket');
        $entity->setTracker($tracker);

        $status = new \SE\Component\Redmine\Entity\Relation\Status;
        $status->setId(1);
        $status->setName('New');
        $entity->setStatus($status);

        $priority = new \SE\Component\Redmine\Entity\Relation\Priority;
        $priority->setId(4);
        $priority->setName('High');
        $entity->setPriority($priority);

        $category = new \SE\Component\Redmine\Entity\Relation\Category;
        $category->setId(12);
        $category->setName('Bugfix');
        $entity->setCategory($category);

        $scalar = new \SE\Component\Redmine\Entity\CustomField\ScalarField();
        $scalar->setId(99);
        $scalar->setName('Resolution');
        $scalar->setValue('Duplicate');

        $array = new \SE\Component\Redmine\Entity\CustomField\ListField();
        $array->setId(12);
        $array->setName('Level');
        $array->setValue(new \SE\Component\Redmine\Entity\CustomField\ValueList(array(1,2,3)));

        $customFields = new \SE\Component\Redmine\Entity\Collection\CustomFields(array(
            $scalar, $array
        ));

        $entity->setCustomFields($customFields);

        $expected = file_get_contents(__DIR__.'/Fixtures/issue_default.xml');
        $actual = $this->serializer->serialize(
            $entity,
            'xml',
            \JMS\Serializer\SerializationContext::create()->setGroups(array('default'))
        );

        $this->assertEquals($expected, $actual);
    }

    /**
     *
     * @test
     */
    public function Serialize_Default_Empty()
    {
        $entity = new \SE\Component\Redmine\Entity\Issue;

        $expected = file_get_contents(__DIR__.'/Fixtures/issue_default_empty.xml');
        $actual = $this->serializer->serialize(
            $entity,
            'xml',
            \JMS\Serializer\SerializationContext::create()->setGroups(array('default'))
        );

        $this->assertEquals($expected, $actual);
    }

    /**
     *
     * @test
     */
    public function Deserialize_Default()
    {
        $entity = $this->serializer->deserialize(
            file_get_contents(__DIR__.'/Fixtures/issue_default.xml'),
            'SE\Component\Redmine\Entity\Issue',
            'xml',
            \JMS\Serializer\DeserializationContext::create()->setGroups(array('default'))
        );

        $this->assertEquals(99, $entity->getId());
        $this->assertEquals('Test Issue #1', $entity->getSubject());
        $this->assertEquals('Test Description #2', $entity->getDescription());
        $this->assertEquals(60, $entity->getEstimatedHours());
        $this->assertEquals(50, $entity->getDoneRatio());
        $this->assertEquals('2013-01-01', $entity->getStartDate());
        $this->assertEquals('2013-08-01', $entity->getDueDate());
        $this->assertEquals(new \DateTime('2013-01-01 00:00:00 +00:00'), $entity->getCreatedOn());
        $this->assertEquals(new \DateTime('2013-08-01 00:00:00 +00:00'), $entity->getUpdatedOn());

        $this->assertInstanceOf('SE\Component\Redmine\Entity\Relation\Author', $entity->getAuthor());
        $this->assertEquals(99, $entity->getAuthor()->getId());
        $this->assertEquals('Jon Smith', $entity->getAuthor()->getName());

        $this->assertInstanceOf('SE\Component\Redmine\Entity\Relation\Project', $entity->getProject());
        $this->assertEquals(98, $entity->getProject()->getId());
        $this->assertEquals('Test Project', $entity->getProject()->getName());

        $this->assertInstanceOf('SE\Component\Redmine\Entity\Relation\Status', $entity->getStatus());
        $this->assertEquals(1, $entity->getStatus()->getId());
        $this->assertEquals('New', $entity->getStatus()->getName());

        $this->assertInstanceOf('SE\Component\Redmine\Entity\Relation\Tracker', $entity->getTracker());
        $this->assertEquals(97, $entity->getTracker()->getId());
        $this->assertEquals('Ticket', $entity->getTracker()->getName());

        $this->assertInstanceOf('SE\Component\Redmine\Entity\Relation\Category', $entity->getCategory());
        $this->assertEquals(12, $entity->getCategory()->getId());
        $this->assertEquals('Bugfix', $entity->getCategory()->getName());

        $this->assertInstanceOf('SE\Component\Redmine\Entity\Relation\Priority', $entity->getPriority());
        $this->assertEquals(4, $entity->getPriority()->getId());
        $this->assertEquals('High', $entity->getPriority()->getName());

        $this->assertInstanceOf('SE\Component\Redmine\Entity\Relation\AssignedTo', $entity->getAssignedTo());
        $this->assertEquals(52, $entity->getAssignedTo()->getId());
        $this->assertEquals('Jane Doe', $entity->getAssignedTo()->getName());

        $customFields = $entity->getCustomFields()->all();
        $customField = array_shift($customFields);

        $this->assertEquals(99, $customField->getId());
        $this->assertEquals('Resolution', $customField->getName());
        $this->assertEquals('Duplicate', $customField->getValue());
        $this->assertFalse($customField->getMultiple());
    }

    /**
     *
     * @test
     */
    public function Deserialize_Default_Empty()
    {
        $entity = $this->serializer->deserialize(
            file_get_contents(__DIR__.'/Fixtures/issue_default_empty.xml'),
            'SE\Component\Redmine\Entity\Issue',
            'xml',
            \JMS\Serializer\DeserializationContext::create()->setGroups(array('default'))
        );

        $this->assertNull($entity->getId());
        $this->assertNull($entity->getSubject());
        $this->assertNull($entity->getDescription());
        $this->assertNull($entity->getCreatedOn());
        $this->assertNull($entity->getUpdatedOn());
        $this->assertNull($entity->getAuthor());
        $this->assertNull($entity->getProject());
        $this->assertNull($entity->getStatus());
        $this->assertNull($entity->getCategory());
        $this->assertNull($entity->getPriority());
        $this->assertNull($entity->getTracker());
        $this->assertNull($entity->getAssignedTo());
        $this->assertEmpty($entity->getCustomFields());
    }

    /**
     *
     * @test
     */
    public function Serialize_Persist()
    {
        $entity = new \SE\Component\Redmine\Entity\Issue;

        $entity->setId(99);
        $entity->setSubject('Test Issue #1');
        $entity->setDescription('Test Description #2');
        $entity->setEstimatedHours(60);
        $entity->setDoneRatio(50);
        $entity->setStartDate('2013-01-01');
        $entity->setDueDate('2013-08-01');
        $entity->setCreatedOn(new \DateTime('2013-01-01 00:00:00 +00:00'));
        $entity->setUpdatedOn(new \DateTime('2013-08-01 00:00:00 +00:00'));

        $author = new \SE\Component\Redmine\Entity\Relation\Author;
        $author->setId(99);
        $author->setName('Jon Smith');
        $entity->setAuthor($author);

        $assignedTo = new \SE\Component\Redmine\Entity\Relation\AssignedTo;
        $assignedTo->setId(52);
        $assignedTo->setName('Jane Doe');
        $entity->setAssignedTo($assignedTo);

        $project = new \SE\Component\Redmine\Entity\Relation\Project;
        $project->setId(98);
        $project->setName('Test Project');
        $entity->setProject($project);

        $tracker = new \SE\Component\Redmine\Entity\Relation\Tracker;
        $tracker->setId(97);
        $tracker->setName('Ticket');
        $entity->setTracker($tracker);

        $status = new \SE\Component\Redmine\Entity\Relation\Status;
        $status->setId(1);
        $status->setName('New');
        $entity->setStatus($status);

        $priority = new \SE\Component\Redmine\Entity\Relation\Priority;
        $priority->setId(4);
        $priority->setName('High');
        $entity->setPriority($priority);

        $category = new \SE\Component\Redmine\Entity\Relation\Category;
        $category->setId(12);
        $category->setName('Bugfix');
        $entity->setCategory($category);

        $scalar = new \SE\Component\Redmine\Entity\CustomField\ScalarField();
        $scalar->setId(99);
        $scalar->setName('Resolution');
        $scalar->setValue('Duplicate');

        $array = new \SE\Component\Redmine\Entity\CustomField\ListField();
        $array->setId(12);
        $array->setName('Level');
        $array->setValue(new \SE\Component\Redmine\Entity\CustomField\ValueList(array(1,2,3)));

        $customFields = new \SE\Component\Redmine\Entity\Collection\CustomFields(array(
            $scalar, $array
        ));

        $entity->setCustomFields($customFields);



        $expected = file_get_contents(__DIR__.'/Fixtures/issue_persist.xml');
        $actual = $this->serializer->serialize(
            $entity,
            'xml',
            \JMS\Serializer\SerializationContext::create()->setGroups(array('persist'))
        );

        $this->assertEquals($expected, $actual);
    }

    /**
     *
     * @test
     */
    public function Serialize_Persist_Empty()
    {
        $entity = new \SE\Component\Redmine\Entity\Issue;

        $expected = file_get_contents(__DIR__.'/Fixtures/issue_persist_empty.xml');
        $actual = $this->serializer->serialize(
            $entity,
            'xml',
            \JMS\Serializer\SerializationContext::create()->setGroups(array('persist'))
        );

        $this->assertEquals($expected, $actual);
    }
}