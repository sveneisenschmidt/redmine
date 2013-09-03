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
 * @Serializer\XmlRoot("news")
 */
class News
{
    /**
     *
     * @Serializer\Expose
     * @Serializer\SerializedName("limit")
     * @Serializer\Type("integer")
     * @Serializer\XmlAttribute
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
     * @var integer
     */
    protected $offset = 0;

    /**
     *
     * @Serializer\Expose
     * @Serializer\SerializedName("news")
     * @Serializer\Type("array<SE\Component\Redmine\Entity\News>")
     * @Serializer\XmlList(inline = true, entry="news")
     *
     * @var \SE\Component\Redmine\Entity\News[]
     */
    protected $news = array();

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
     * @param \SE\Component\Redmine\Entity\News[] $news
     */
    public function setNews(array $news)
    {
        $this->news = $news;
    }

    /**
     * @return \SE\Component\Redmine\Entity\News[]
     */
    public function getNews()
    {
        return $this->news;
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
        return count($this->news);
    }

}