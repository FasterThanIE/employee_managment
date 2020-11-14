<?php

namespace App\Models;


/**
 * Description: Oh well, this is somewhat of a "pool" for building log data. I'm not sure if I can even call this pool entirely but yeah. TBR at later date
 * Class LogPool
 */
class LogPool
{

    const TYPE_OLD_DATA = "old_data";
    const TYPE_NEW_DATA = "new_data";

    /**
     * @var array
     */
    private $data;

    /**
     * @var array
     */
    private $keys;

    public function __construct(array $data)
    {
        foreach ($data as $key => $value) {
            $this->setPoolData($key, $value[0], self::TYPE_OLD_DATA);
            $this->setPoolData($key, $value[1], self::TYPE_NEW_DATA);
            $this->addKey($key);
        }
    }

    /**
     * @param string $key
     * @param $value
     * @param string $type
     */
    private function setPoolData(string $key, $value, string $type): void
    {
        $this->data[$key][$type] = $value;
    }

    /**
     * @param string $key
     */
    private function addKey(string $key): void
    {
        $this->keys[] = $key;
    }

    /**
     * @return array[]
     */
    public function getPool(): array
    {
        return [
            $this->getData(),
            $this->getKeys()
        ];
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * @return array
     */
    public function getKeys(): array
    {
        return $this->keys;
    }


}