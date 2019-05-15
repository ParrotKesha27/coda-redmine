<?php


namespace Academy;

use CodaPHP;

class CodaClass
{
    protected $client;
    protected $doc;
    protected $table;

    public function __construct(string $token, string $doc, string $table)
    {
        $this->client = new CodaPHP\CodaPHP($token);
        $this->doc = $doc;
        $this->table = $table;
    }

    public function addData(array $data)
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
