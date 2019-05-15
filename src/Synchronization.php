<?php


namespace Academy;

use Symfony\Component\Yaml\Yaml;

class Synchronization
{
    protected $codaClient;
    protected $redmineClient;

    public function __construct($config)
    {
        $arConfig = Yaml::parseFile($config);
        $redmineConfig = $arConfig['redmine'];
        $codaConfig = $arConfig['coda'];

        $this->redmineClient = new RedmineClass(
            $redmineConfig['period'],
            $redmineConfig['limit'],
            $redmineConfig['url'],
            $redmineConfig['key']
        );

        $this->codaClient = new CodaClass(
            $codaConfig['token'],
            $codaConfig['doc'],
            $codaConfig['table']
        );
    }

    public function syncData()
    {
        $data = $this->redmineClient->getData();
        return $this->codaClient->addData($data);
    }
}
