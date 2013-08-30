<?php
/**
 * This file is part of the Redmine php library
 *
 * (c) Sven Eisenschmidt <sven.eisenschmidt@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace SE\Component\Redmine\Client\Rest;

use \SE\Component\Redmine\Client\ClientInterface;

/**
 *
 * @package SE\Component\Redmine
 * @author Sven Eisenschmidt <sven.eisenschmidt@gmail.com>
 */
class RestClient implements ClientInterface
{
    const CLIENT_NAME = 'redmine.client.rest';

    /**
     *
     * @return string
     */
    public function getName()
    {
        return self::CLIENT_NAME;
    }
} 