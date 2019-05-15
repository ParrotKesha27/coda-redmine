<?php


namespace Academy;

use Symfony\Component\Yaml\Yaml;

class Synchronization
{
    protected $codaClient;
    protected $redmineClient;

    /**
     * Synchronization constructor.
     * @param string $config Путь к yaml-файлу с конфигурацией
     */
    public function __construct(string $config)
    {
        // Парсинг yaml-файла
        $arConfig = Yaml::parseFile($config);
        $redmineConfig = $arConfig['redmine'];
        $codaConfig = $arConfig['coda'];

        // Создание объекта класса RedmineClass
        $this->redmineClient = new RedmineClass(
            $redmineConfig['period'],
            $redmineConfig['limit'],
            $redmineConfig['url'],
            $redmineConfig['key']
        );

        // Создание объекта класса CodaClass
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
