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

/**
 *
 * @package SE\Component\Redmine
 * @author Sven Eisenschmidt <sven.eisenschmidt@gmail.com>
 *
 * @Serializer\XmlRoot("news")
 */
class News
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
     * @Serializer\Type("SE\Component\Redmine\Entity\Relation\Project")
     *
     * @Serializer\Groups({"default"})
     *
     * @var \SE\Component\Redmine\Entity\Relation\Project
     */
    protected $project;

    /**
     *
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
     * @Serializer\SerializedName("title")
     * @Serializer\Type("string")
     *
     * @Serializer\Groups({"default"})
     *
     * @var string
     */
    protected $title;

    /**
     *
     * @Serializer\Expose
     * @Serializer\SerializedName("summary")
     * @Serializer\Type("string")
     *
     * @Serializer\Groups({"default"})
     *
     * @var string
     */
    protected $summary;

    /**
     *
     * @Serializer\Expose
     * @Serializer\SerializedName("description")
     * @Serializer\Type("string")
     *
     * @Serializer\Groups({"default"})
     *
     * @var string
     */
    protected $description;

    /**
     *
     * @Serializer\Expose
     * @Serializer\SerializedName("created_on")
     * @Serializer\Type("DateTime<'Y-m-d\TG:i:sP'>")
     *
     * @Serializer\Groups({"default"})
     *
     * @var \DateTime
     */
    protected $createdOn;

    /**
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
     * @param \DateTime $createdOn
     * @throws \BadMethodCallException
     */
    public function setCreatedOn(\DateTime $createdOn)
    {
        if($this->createdOn !== null) {
            throw new \BadMethodCallException('Property id can not be set.');
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
     * @param string $summary
     */
    public function setSummary($summary)
    {
        $this->summary = $summary;
    }

    /**
     *
     * @return string
     */
    public function getSummary()
    {
        return $this->summary;
    }

    /**
     *
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
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
     * @param \SE\Component\Redmine\Entity\Relation\Project $project
     */
    public function setProject(Project $project)
    {
        $this->project = $project;
    }

    /**
     *
     * @return array
     */
    public function getProject()
    {
        return $this->project;
    }
}