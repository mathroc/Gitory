<?php

namespace Gitory\Gitory\Managers;

use Gitory\Gitory\Entities\Repository;

interface RepositoryManager
{
    /**
     * Find all repositories
     * @return array array of Gitory\Gitory\Entities\Repository
     */
    public function findAll();

    /**
     * Save a repository
     * @param  Repository $repository
     * @return Repository saved repository
     * @throws ExistingRepositoryIdentifierException If a repository with the same identifier already exists
     */
    public function save(Repository $repository);
}
