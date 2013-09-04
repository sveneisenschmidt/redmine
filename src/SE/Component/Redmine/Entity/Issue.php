<?php
/**
 * This file is part of the Redmine php library
 *
 * (c) Sven Eisenschmidt <sven.eisenschmidt@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace SE\Component\Redmine\Entity;

use \JMS\Serializer\Annotation as Serializer;

use \SE\Component\Redmine\Entity\Relation\Author;
use \SE\Component\Redmine\Entity\Relation\Project;
use \SE\Component\Redmine\Entity\Relation\Status;
use \SE\Component\Redmine\Entity\Relation\Tracker;
use \SE\Component\Redmine\Entity\Relation\Priority;
use \SE\Component\Redmine\Entity\Relation\Category;
use \SE\Component\Redmine\Entity\Relation\AssignedTo;

/**
 *
 * @package SE\Component\Redmine
 * @author Sven Eisenschmidt <sven.eisenschmidt@gmail.com>
 *
 * @Serializer\XmlRoot("issue")
 */
class Issue
{
    /**
     *
     * @Serializer\Expose
     * @Serializer\SerializedName("id")
     * @Serializer\Type("integer")
     *
     * @var integer
     */
    protected $id;

    /**
     *
     *
     * @Serializer\Expose
     * @Serializer\SerializedName("author")
     * @Serializer\Type("SE\Component\Redmine\Entity\Relation\Author")
     *
     * @var \SE\Component\Redmine\Entity\Relation\Author
     */
    protected $author;

    /**
     *
     *
     * @Serializer\Expose
     * @Serializer\SerializedName("assigned_to")
     * @Serializer\Type("SE\Component\Redmine\Entity\Relation\AssignedTo")
     *
     * @var \SE\Component\Redmine\Entity\Relation\AssignedTo
     */
    protected $assignedTo;

    /**
     *
     *
     * @Serializer\Expose
     * @Serializer\SerializedName("status")
     * @Serializer\Type("SE\Component\Redmine\Entity\Relation\Status")
     *
     * @var \SE\Component\Redmine\Entity\Relation\Status
     */
    protected $status;

    /**
     *
     *
     * @Serializer\Expose
     * @Serializer\SerializedName("project")
     * @Serializer\Type("SE\Component\Redmine\Entity\Relation\Project")
     *
     * @var \SE\Component\Redmine\Entity\Relation\Project
     */
    protected $project;

    /**
     *
     *
     * @Serializer\Expose
     * @Serializer\SerializedName("priority")
     * @Serializer\Type("SE\Component\Redmine\Entity\Relation\Priority")
     *
     * @var \SE\Component\Redmine\Entity\Relation\Priority
     */
    protected $priority;

    /**
     *
     *
     * @Serializer\Expose
     * @Serializer\SerializedName("category")
     * @Serializer\Type("SE\Component\Redmine\Entity\Relation\Category")
     *
     * @var \SE\Component\Redmine\Entity\Relation\Category
     */
    protected $category;

    /**
     *
     *
     * @Serializer\Expose
     * @Serializer\SerializedName("tracker")
     * @Serializer\Type("SE\Component\Redmine\Entity\Relation\Tracker")
     *
     * @var \SE\Component\Redmine\Entity\Relation\Tracker
     */
    protected $tracker;

    /**
     *
     *
     * @Serializer\Expose
     * @Serializer\SerializedName("subject")
     * @Serializer\Type("string")
     *
     * @var string
     */
    protected $subject;

    /**
     *
     *
     * @Serializer\Expose
     * @Serializer\SerializedName("description")
     * @Serializer\Type("string")
     *
     * @var string
     */
    protected $description;

    /**
     *
     *
     * @Serializer\Expose
     * @Serializer\SerializedName("done_ratio")
     * @Serializer\Type("integer")
     *
     * @var integer
     */
    protected $doneRatio;

    /**
     *
     *
     * @Serializer\Expose
     * @Serializer\SerializedName("estimated_hours")
     * @Serializer\Type("float")
     *
     * @var float
     */
    protected $estimatedHours;

    /**
     *
     *
     * @Serializer\Expose
     * @Serializer\SerializedName("custom_fields")
     * @Serializer\Type("array<SE\Component\Redmine\Entity\CustomField>")
     * @Serializer\XmlList(entry="custom_field")
     *
     * @var \SE\Component\Redmine\Entity\CustomField[]
     */
    protected $customFields;

    /**
     *
     *
     * @Serializer\Expose
     * @Serializer\SerializedName("start_date")
     * @Serializer\Type("string")
     *
     * @var string
     */
    protected $startDate;

    /**
     *
     *
     * @Serializer\Expose
     * @Serializer\SerializedName("due_date")
     * @Serializer\Type("string")
     *
     * @var string
     */
    protected $dueDate;

    /**
     *
     *
     * @Serializer\Expose
     * @Serializer\SerializedName("updated_on")
     * @Serializer\Type("DateTime")
     *
     * @var \DateTime
     */
    protected $updatedOn;

    /**
     *
     *
     * @Serializer\Expose
     * @Serializer\SerializedName("created_on")
     * @Serializer\Type("DateTime")
     *
     * @var \DateTime
     */
    protected $createdOn;

    /**
     * @param integer $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     *
     * @param \SE\Component\Redmine\Entity\Relation\Author $author
     */
    public function setAuthor(Author $author)
    {
        $this->author = $author;
    }

    /**
     *
     * @return array
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     *
     * @param \SE\Component\Redmine\Entity\Relation\Category $category
     */
    public function setCategory(Category $category)
    {
        $this->category = $category;
    }

    /**
     *
     * @return \SE\Component\Redmine\Entity\Relation\Category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     *
     * @param \SE\Component\Redmine\Entity\Relation\Priority $priority
     */
    public function setPriority(Priority $priority)
    {
        $this->priority = $priority;
    }

    /**
     *
     * @return \SE\Component\Redmine\Entity\Relation\Priority
     */
    public function getPriority()
    {
        return $this->priority;
    }

    /**
     *
     * @param \SE\Component\Redmine\Entity\Relation\Project $project
     */
    public function setProject(Project $project)
    {
        $this->project = $project;
    }

    /**
     *
     * @return \SE\Component\Redmine\Entity\Relation\Project
     */
    public function getProject()
    {
        return $this->project;
    }

    /**
     *
     * @param \SE\Component\Redmine\Entity\Relation\Status $status
     */
    public function setStatus(Status $status)
    {
        $this->status = $status;
    }

    /**
     *
     * @return \SE\Component\Redmine\Entity\Relation\Status
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     *
     * @param \SE\Component\Redmine\Entity\Relation\Tracker $tracker
     */
    public function setTracker(Tracker $tracker)
    {
        $this->tracker = $tracker;
    }

    /**
     *
     * @return \SE\Component\Redmine\Entity\Relation\Tracker
     */
    public function getTracker()
    {
        return $this->tracker;
    }

    /**
     *
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     *
     * @param string $subject
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;
    }

    /**
     *
     * @return string
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     *
     * @param int $doneRatio
     */
    public function setDoneRatio($doneRatio)
    {
        $this->doneRatio = $doneRatio;
    }

    /**
     *
     * @return int
     */
    public function getDoneRatio()
    {
        return $this->doneRatio;
    }

    /**
     *
     * @param string $dueDate
     */
    public function setDueDate($dueDate)
    {
        $this->dueDate = $dueDate;
    }

    /**
     *
     * @return string
     */
    public function getDueDate()
    {
        return $this->dueDate;
    }

    /**
     * @param
     * float $estimatedHours
     */
    public function setEstimatedHours($estimatedHours)
    {
        $this->estimatedHours = $estimatedHours;
    }

    /**
     *
     * @return float
     */
    public function getEstimatedHours()
    {
        return $this->estimatedHours;
    }

    /**
     *
     * @param string $startDate
     */
    public function setStartDate($startDate)
    {
        $this->startDate = $startDate;
    }

    /**
     *
     * @return string
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     *
     * @param \SE\Component\Redmine\Entity\CustomField[] $customFields
     */
    public function setCustomFields(array $customFields)
    {
        $this->customFields = $customFields;
    }

    /**
     *
     * @return \SE\Component\Redmine\Entity\CustomField[]
     */
    public function getCustomFields()
    {
        return $this->customFields;
    }

    /**
     *
     * @param \DateTime $createdOn
     */
    public function setCreatedOn(\DateTime $createdOn)
    {
        $this->createdOn = $createdOn;
    }

    /**
     *
     * @return \DateTime
     */
    public function getCreatedOn()
    {
        return $this->createdOn;
    }

    /**
     *
     * @param \DateTime $updatedOn
     */
    public function setUpdatedOn(\DateTime $updatedOn)
    {
        $this->updatedOn = $updatedOn;
    }

    /**
     *
     * @return \DateTime
     */
    public function getUpdatedOn()
    {
        return $this->updatedOn;
    }

    /**
     *
     * @param \SE\Component\Redmine\Entity\Relation\AssignedTo $assignedTo
     */
    public function setAssignedTo(AssignedTo $assignedTo)
    {
        $this->assignedTo = $assignedTo;
    }

    /**
     *
     * @return \SE\Component\Redmine\Entity\Relation\AssignedTo
     */
    public function getAssignedTo()
    {
        return $this->assignedTo;
    }
}