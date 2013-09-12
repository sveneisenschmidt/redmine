<?php
/**
 * This file is part of the Redmine php library
 *
 * (c) Sven Eisenschmidt <sven.eisenschmidt@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace SE\Component\Redmine\Entity\Collection;

use \JMS\Serializer\Annotation as Serializer;

/**
 *
 * @package SE\Component\Redmine
 * @author Sven Eisenschmidt <sven.eisenschmidt@gmail.com>
 *
 * @Serializer\XmlRoot("issues")
 */
class Issues
{
    /**
     *
     * @Serializer\Expose
     * @Serializer\SerializedName("limit")
     * @Serializer\Type("integer")
     * @Serializer\XmlAttribute
     *
     * @Serializer\Groups({"default"})
     *
     * @var integer
     */
    protected $limit = 0;

    /**
     *
     * @Serializer\Expose
     * @Serializer\SerializedName("total_count")
     * @Serializer\Type("integer")
     * @Serializer\XmlAttribute
     *
     * @Serializer\Groups({"default"})
     *
     * @var integer
     */
    protected $totalCount = 0;

    /**
     *
     * @Serializer\Expose
     * @Serializer\SerializedName("offset")
     * @Serializer\Type("integer")
     * @Serializer\XmlAttribute
     *
     * @Serializer\Groups({"default"})
     *
     * @var integer
     */
    protected $offset = 0;

    /**
     *
     * @Serializer\Expose
     * @Serializer\SerializedName("issues")
     * @Serializer\Type("array<SE\Component\Redmine\Entity\Issue>")
     * @Serializer\XmlList(inline = true, entry="issue")
     *
     * @Serializer\Groups({"default"})
     *
     * @var \SE\Component\Redmine\Entity\Issues[]
     */
    protected $issues = array();

    /**
     * @param int $limit
     */
    public function setLimit($limit)
    {
        $this->limit = $limit;
    }

    /**
     * @return int
     */
    public function getLimit()
    {
        return $this->limit;
    }

    /**
     * @param \SE\Component\Redmine\Entity\Issue[] $issues
     */
    public function setIssues(array $issues)
    {
        $this->issues = $issues;
    }

    /**
     * @return \SE\Component\Redmine\Entity\Issue[]
     */
    public function getIssues()
    {
        return $this->issues;
    }

    /**
     * @param int $offset
     */
    public function setOffset($offset)
    {
        $this->offset = $offset;
    }

    /**
     * @return int
     */
    public function getOffset()
    {
        return $this->offset;
    }

    /**
     * @param int $totalCount
     */
    public function setTotalCount($totalCount)
    {
        $this->totalCount = $totalCount;
    }

    /**
     * @return int
     */
    public function getTotalCount()
    {
        return $this->totalCount;
    }

    /**
     *
     * @return integer
     */
    public function count()
    {
        return count($this->issues);
    }

}