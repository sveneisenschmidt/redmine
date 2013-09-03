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
     * @param \SE\Component\Redmine\Entity\Relation\Relation $author
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
}