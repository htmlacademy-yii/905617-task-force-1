<?php
declare(strict_types=1);

namespace taskforce\loader;

use taskforce\exception\SourceFileException;
use taskforce\exception\FileFormatException;

class DbLoader
{
    private $filename;
    private $fileObject;

    public function __construct(string $filename, string $table, array $columns = [])
    {
        $this->filename = $filename;
        $this->table = $table;
        $this->columns = $columns;
    }

    public function import(): void
    {
        if (!file_exists($this->filename)) {
            throw new SourceFileException("Файл не существует");
        }

        try {
            $this->fileObject = new \SplFileObject($this->filename);
        } catch (RuntimeException $exception) {
            throw new SourceFileException("Не удалось открыть файл на чтение");
        }

        $columns = '';
        $data = '';
        $dataSql = $this->getDataSql($columns, $data, $this->columns);
        $columns = $dataSql['columns'];
        $data = $dataSql['data'];

        file_put_contents('/domains/task-force/fixtures/bd.sql', "INSERT INTO `" . $this->table . "`(" . $columns . ") VALUES " . substr($data, 0, -1) . ";" . PHP_EOL, FILE_APPEND);
    }


    private function getDataSql($columns, $data, $arrayColumns)
    {

        foreach ($this->getNextLine() as $line) {

            if ($this->fileObject->key() === 0) {
                if ($arrayColumns !== []) {
                    $line = array_merge($line, $arrayColumns);
                }
                $columns .= implode(",", $line);

            } else {
                $data .= "('" . implode("', '", $line) . "'";
                if ($arrayColumns !== []) {

                    $count = count($arrayColumns);

                    for ($i = 1; $i <= $count; $i++) {
                        $data .= ", " . random_int(1, 8);
                    }
                }
                $data .= "),";

            }
        }

        return ['columns' => $columns, 'data' => $data];
    }

    private function getNextLine(): ?iterable
    {
        $this->fileObject->rewind();
        while (!$this->fileObject->eof()) {
            yield $this->fileObject->fgetcsv();
        }
    }

}
