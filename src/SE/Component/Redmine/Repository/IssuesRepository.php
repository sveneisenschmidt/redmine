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
use \SE\Component\Redmine\Repository\FindAllInterface;
use \SE\Component\Redmine\Repository\FindOneInterface;

/**
 *
 * @package SE\Component\Redmine
 * @author Sven Eisenschmidt <sven.eisenschmidt@gmail.com>
 */
class IssuesRepository extends AbstractRepository implements FindAllInterface, FindOneInterface
{
    /**
     *
     * @param array $criteria
     * @return \SE\Component\Redmine\Entity\Collection\Issues
     */
    public function findAll(array $criteria = array())
    {
        return $this->client->findAll(
            'issues',
            $criteria,
            'SE\Component\Redmine\Entity\Collection\Issues'
        );
    }

    /**
     * @param $id
     * @return \SE\Component\Redmine\Entity\Issue
     */
    public function find($id)
    {
        return $this->client->find(
            'issues',
            $id,
            'SE\Component\Redmine\Entity\Issue'
        );
    }
}