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

use \SE\Component\Redmine\Entity\Collection\CustomFields;

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
     * @Serializer\Groups({"default"})
     *
     * @var integer
     */
    protected $id;

    /**
     *
     * @Serializer\Expose
     * @Serializer\SerializedName("author")
     * @Serializer\Type("SE\Component\Redmine\Entity\Relation\Author")
     *
     * @Serializer\Groups({"default"})
     *
     * @var \SE\Component\Redmine\Entity\Relation\Author
     */
    protected $author;

    /**
     *
     * @Serializer\Expose
     * @Serializer\SerializedName("assigned_to")
     * @Serializer\Type("SE\Component\Redmine\Entity\Relation\AssignedTo")
     *
     * @Serializer\Groups({"default"})
     *
     * @var \SE\Component\Redmine\Entity\Relation\AssignedTo
     */
    protected $assignedTo;

    /**
     *
     * @Serializer\Expose
     * @Serializer\SerializedName("status")
     * @Serializer\Type("SE\Component\Redmine\Entity\Relation\Status")
     *
     * @Serializer\Groups({"default"})
     *
     * @var \SE\Component\Redmine\Entity\Relation\Status
     */
    protected $status;

    /**
     *
     * @Serializer\Expose
     * @Serializer\SerializedName("project")
     * @Serializer\Type("SE\Component\Redmine\Entity\Relation\Project")
     *
     * @Serializer\Groups({"default"})
     *
     * @var \SE\Component\Redmine\Entity\Relation\Project
     */
    protected $project;

    /**
     *
     * @Serializer\Expose
     * @Serializer\SerializedName("priority")
     * @Serializer\Type("SE\Component\Redmine\Entity\Relation\Priority")
     *
     * @Serializer\Groups({"default"})
     *
     * @var \SE\Component\Redmine\Entity\Relation\Priority
     */
    protected $priority;

    /**
     *
     * @Serializer\Expose
     * @Serializer\SerializedName("category")
     * @Serializer\Type("SE\Component\Redmine\Entity\Relation\Category")
     *
     * @Serializer\Groups({"default"})
     *
     * @var \SE\Component\Redmine\Entity\Relation\Category
     */
    protected $category;

    /**
     *
     * @Serializer\Expose
     * @Serializer\SerializedName("tracker")
     * @Serializer\Type("SE\Component\Redmine\Entity\Relation\Tracker")
     *
     * @Serializer\Groups({"default"})
     *
     * @var \SE\Component\Redmine\Entity\Relation\Tracker
     */
    protected $tracker;

    /**
     *
     * @Serializer\Expose
     * @Serializer\SerializedName("subject")
     * @Serializer\Type("string")
     *
     * @Serializer\Groups({"default", "persist"})
     *
     * @var string
     */
    protected $subject;

    /**
     *
     * @Serializer\Expose
     * @Serializer\SerializedName("description")
     * @Serializer\Type("string")
     *
     * @Serializer\Groups({"default", "persist"})
     *
     * @var string
     */
    protected $description;

    /**
     *
     * @Serializer\Expose
     * @Serializer\SerializedName("done_ratio")
     * @Serializer\Type("integer")
     *
     * @Serializer\Groups({"default", "persist"})
     *
     * @var integer
     */
    protected $doneRatio;

    /**
     *
     * @Serializer\Expose
     * @Serializer\SerializedName("estimated_hours")
     * @Serializer\Type("float")
     *
     * @Serializer\Groups({"default", "persist"})
     *
     * @var float
     */
    protected $estimatedHours;

    /**
     *
     * @Serializer\Expose
     * @Serializer\SerializedName("custom_fields")
     * @Serializer\Type("SE\Component\Redmine\Entity\Collection\CustomFields")
     *
     * @Serializer\Groups({"default", "persist"})
     *
     * @var \SE\Component\Redmine\Entity\Collection\CustomFields
     */
    protected $customFields;

    /**
     *
     * @Serializer\Expose
     * @Serializer\SerializedName("start_date")
     * @Serializer\Type("string")
     *
     * @Serializer\Groups({"default", "persist"})
     *
     * @var string
     */
    protected $startDate;

    /**
     *
     * @Serializer\Expose
     * @Serializer\SerializedName("due_date")
     * @Serializer\Type("string")
     *
     * @Serializer\Groups({"default", "persist"})
     *
     * @var string
     */
    protected $dueDate;

    /**
     *
     * @Serializer\Expose
     * @Serializer\SerializedName("updated_on")
     * @Serializer\Type("DateTime")
     *
     * @Serializer\Groups({"default"})
     *
     * @var \DateTime
     */
    protected $updatedOn;

    /**
     *
     * @Serializer\Expose
     * @Serializer\SerializedName("created_on")
     * @Serializer\Type("DateTime")
     *
     * @Serializer\Groups({"default"})
     *
     * @var \DateTime
     */
    protected $createdOn;

    /**
     *
     * @param integer $id
     * @throws \BadMethodCallException
     */
    public function setId($id)
    {
        if($this->id !== null) {
            throw new \BadMethodCallException('Property id can not be set.');
        }

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
     * @param \SE\Component\Redmine\Entity\Collection\CustomFields $customFields
     */
    public function setCustomFields(CustomFields $customFields)
    {
        $this->customFields = $customFields;
    }

    /**
     *
     * @return \SE\Component\Redmine\Entity\Collection\CustomFields
     */
    public function getCustomFields()
    {
        return $this->customFields;
    }

    /**
     *
     * @param \DateTime $createdOn
     * @throws \BadMethodCallException
     */
    public function setCreatedOn(\DateTime $createdOn)
    {
        if($this->createdOn !== null) {
            throw new \BadMethodCallException('Property createdOn can not be set.');
        }

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
     * @throws \BadMethodCallException
     */
    public function setUpdatedOn(\DateTime $updatedOn)
    {
        if($this->updatedOn !== null) {
            throw new \BadMethodCallException('Property createdOn can not be set.');
        }

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


    /**
     *
     * @Serializer\SerializedName("author_id")
     * @Serializer\Type("integer")
     * @Serializer\VirtualProperty
     *
     * @Serializer\Groups({"persist"})
     *
     * @var string
     */
    public function getAuthorId()
    {
        if($this->author !== null) {
            return $this->author->getId();
        }

        return null;
    }


    /**
     *
     * @Serializer\SerializedName("assigned_to_id")
     * @Serializer\Type("integer")
     * @Serializer\VirtualProperty
     *
     * @Serializer\Groups({"persist"})
     *
     * @var string
     */
    public function getAssignedToId()
    {
        if($this->assignedTo !== null) {
            return $this->assignedTo->getId();
        }

        return null;
    }

    /**
     *
     * @Serializer\SerializedName("project_id")
     * @Serializer\Type("integer")
     * @Serializer\VirtualProperty
     *
     * @Serializer\Groups({"persist"})
     *
     * @var string
     */
    public function getProjectId()
    {
        if($this->project !== null) {
            return $this->project->getId();
        }

        return null;
    }

    /**
     *
     * @Serializer\SerializedName("tracker_id")
     * @Serializer\Type("integer")
     * @Serializer\VirtualProperty
     *
     * @Serializer\Groups({"persist"})
     *
     * @var string
     */
    public function getTrackerId()
    {
        if($this->tracker !== null) {
            return $this->tracker->getId();
        }

        return null;
    }

    /**
     *
     * @Serializer\SerializedName("priority_id")
     * @Serializer\Type("integer")
     * @Serializer\VirtualProperty
     *
     * @Serializer\Groups({"persist"})
     *
     * @var string
     */
    public function getPriorityId()
    {
        if($this->priority !== null) {
            return $this->priority->getId();
        }

        return null;
    }

    /**
     *
     * @Serializer\SerializedName("status_id")
     * @Serializer\Type("integer")
     * @Serializer\VirtualProperty
     *
     * @Serializer\Groups({"persist"})
     *
     * @var string
     */
    public function getStatusId()
    {
        if($this->status !== null) {
            return $this->status->getId();
        }

        return null;
    }

    /**
     *
     * @Serializer\SerializedName("category_id")
     * @Serializer\Type("integer")
     * @Serializer\VirtualProperty
     *
     * @Serializer\Groups({"persist"})
     *
     * @var string
     */
    public function getCategoryId()
    {
        if($this->category !== null) {
            return $this->category->getId();
        }

        return null;
    }
}