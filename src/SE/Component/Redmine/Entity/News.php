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

use \SE\Component\Redmine\Entity\AuthorRelation;
use \SE\Component\Redmine\Entity\ProjectRelation;

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
     * @var integer
     */
    protected $id;

    /**
     *
     * @Serializer\Expose
     * @Serializer\Type("SE\Component\Redmine\Entity\ProjectRelation")
     *
     * @var array
     */
    protected $project;

    /**
     *
     *
     * @Serializer\Expose
     * @Serializer\SerializedName("author")
     * @Serializer\Type("SE\Component\Redmine\Entity\AuthorRelation")
     *
     * @var array
     */
    protected $author;

    /**
     *
     * @Serializer\Expose
     * @Serializer\SerializedName("title")
     * @Serializer\Type("string")
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
     * @var string
     */
    protected $summary;

    /**
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
     * @Serializer\Expose
     * @Serializer\SerializedName("created_on")
     * @Serializer\Type("datetime")
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
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param \DateTime $createdOn
     */
    public function setCreatedOn(\DateTime $createdOn)
    {
        $this->createdOn = $createdOn;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedOn()
    {
        return $this->createdOn;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $summary
     */
    public function setSummary($summary)
    {
        $this->summary = $summary;
    }

    /**
     * @return string
     */
    public function getSummary()
    {
        return $this->summary;
    }

    /**
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
     * @param \SE\Component\Redmine\Entity\AuthorRelation $author
     */
    public function setAuthor(AuthorRelation $author)
    {
        $this->author = $author;
    }

    /**
     * @return array
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @param \SE\Component\Redmine\Entity\ProjectRelation $project
     */
    public function setProject(ProjectRelation $project)
    {
        $this->project = $project;
    }

    /**
     * @return array
     */
    public function getProject()
    {
        return $this->project;
    }




}