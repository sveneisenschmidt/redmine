<?php
/**
 * This file is part of the Redmine php library
 *
 * (c) Sven Eisenschmidt <sven.eisenschmidt@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace SE\Component\Redmine\Repository;

use \SE\Component\Redmine\Repository\AbstractRepository;

/**
 *
 * @package SE\Component\Redmine
 * @author Sven Eisenschmidt <sven.eisenschmidt@gmail.com>
 */
class NewsRepository extends AbstractRepository implements FindAllInterface
{
    /**
     *
     * @param array $criteria
     * @return \SE\Component\Redmine\Entity\Collection\News
     */
    public function findAll(array $criteria = array())
    {
        return $this->client->findAll(
            'news',
            $criteria,
            'SE\Component\Redmine\Entity\Collection\News'
        );
    }
}