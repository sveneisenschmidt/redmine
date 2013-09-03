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
     * @var array
     */
    protected $author;
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
     * @param \SE\Component\Redmine\Entity\Relation\Relation $author
     */
    public function setAuthor(Author $author)
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
}