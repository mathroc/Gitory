<?php

namespace Gitory\Gitory\CLI;

use Dflydev\Cilex\Provider\DoctrineOrm\DoctrineOrmServiceProvider;
use Saxulum\DoctrineOrmManagerRegistry\Doctrine\ManagerRegistry;
use Cilex\Provider\DoctrineServiceProvider;
use Gitory\Gitory\Managers\Doctrine\DoctrineRepositoryManager;
use Gitory\Gitory\GitElephantGitHosting;

trait DI
{
    /**
     * Initialize services for dependency injection
     * @param  array $values config
     */
    private function initDI($values)
    {
        $this->register(new DoctrineServiceProvider, array(
            "db.options" => array(
                "driver" => "pdo_sqlite",
                "path" => $values['privateDirectoryPath'].'gitory.db',
            ),
        ));

        $this->register(new DoctrineOrmServiceProvider, array(
            "orm.proxies_dir" => $values['privateDirectoryPath'].'/doctrine/proxies/',
            "orm.em.options" => array(
                "mappings" => array(
                    array(
                        "type" => "annotation",
                        "namespace" => "Gitory\Gitory\Entities",
                        "path" => __DIR__.'/../Entities',
                    ),
                ),
            ),
        ));

        $this['debug'] = $values['debug'];

        $this['doctrine'] = function ($container) {
            return new ManagerRegistry($container);
        };

        $this['repository.manager'] = function ($c) {
            return new DoctrineRepositoryManager($c['doctrine']);
        };

        $this['repository.hosting'] = function () {
            return new GitElephantGitHosting($this['repositories.directory-path']);
        };
    }

    abstract public function register($provider, array $values = []);
}
