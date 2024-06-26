<?php

/**
 * Joomla! Content Management System
 *
 * @copyright  (C) 2024 Open Source Matters, Inc. <https://www.joomla.org>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Joomla\CMS\TUF;

use GuzzleHttp\Promise\Create;
use GuzzleHttp\Promise\PromiseInterface;
use Joomla\Http\Http;
use Tuf\Exception\RepoFileNotFound;
use Tuf\Loader\LoaderInterface;

/**
 * @since  5.1.0
 */
class HttpLoader implements LoaderInterface
{
    public function __construct(private readonly string $repositoryPath, private readonly Http $http)
    {
    }

    public function load(string $locator, int $maxBytes): PromiseInterface
    {
        /** @var Http $client */
        $response = $this->http->get($this->repositoryPath . $locator);

        if ($response->code !== 200) {
            throw new RepoFileNotFound();
        }

        // Rewind to start
        $response->getBody()->rewind();

        // Return response
        return Create::promiseFor($response->getBody());
    }
}
