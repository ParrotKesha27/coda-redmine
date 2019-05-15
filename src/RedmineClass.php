<?php


namespace Academy;

use Redmine;

class RedmineClass
{
    protected $period;
    protected $limit;
    protected $client;

    /**
     * RedmineClass constructor.
     * @param string $period Период, за который нужно получить данные
     * @param int $limit Количество получаемых строк
     * @param string $url URL Redmine
     * @param string $key Ключ доступа
     */
    public function __construct(string $period, int $limit, string $url, string $key)
    {
        $this->period = $period;
        $this->limit = $limit;
        $this->client = new Redmine\Client($url, $key);
    }

    /**
     * @return array
     * @throws \Exception
     */
    public function getData() : array
    {
        $allTimes = $this->client->time_entry->all(['spent_on'=>$this->period, 'limit' => $this->limit]);

        if (count($allTimes) <= 0)
        {
            return null;
        }

        $currentDate = new \DateTime();
        foreach ($allTimes["time_entries"] as $time)
        {
            $arTimes[$time['id']] = [
                'ID' => $time['id'],
                'Пользователь' => $time['user']['name'],
                'Списано' => $time['hours'],
                'Проект' => $time['project']['name'],
                'Задача' => $time['issue']['id'] ?? 0,
                'Коммент' => $time['comments'],
                'Списано за' => $time['spent_on'],
                'Создано' => $time['created_on'],
                'Время импорта' => $currentDate->format('Y-m-d H:i:s')
            ];
        }

        return $arTimes;
    }
}
