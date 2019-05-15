<?php


namespace Academy;

use CodaPHP;

class CodaClass
{
    protected $client;
    protected $doc;
    protected $table;

    /**
     * CodaClass constructor.
     * @param string $token Токен
     * @param string $doc ID документа
     * @param string $table Таблица, в которую будет выгружена информация
     */
    public function __construct(string $token, string $doc, string $table)
    {
        $this->client = new CodaPHP\CodaPHP($token);
        $this->doc = $doc;
        $this->table = $table;
    }

    /**
     * @param array $data Массив данных, полученных с Redmine
     * @return bool
     */
    public function addData(array $data) : bool
    {
        $arCodaTimes = $this->client->listRows($this->doc, $this->table);

        foreach ($arCodaTimes['items'] as $items)
        {
            $id = $items["values"]["ID"];
            if ($id && $data[$id]) {
                unset($data[$id]);
            }
        }

        $ins = $this->client->insertRows(
            $this->doc,
            $this->table,
            $data
        );

        return $ins;
    }
}
