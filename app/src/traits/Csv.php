<?php

declare(strict_types=1);

namespace src\traits;

use League\Csv\Reader;
use League\Csv\CannotInsertRecord;
use League\Csv\Writer;
use League\Csv\Exception;
use League\Csv\Statement;
use League\Csv\TabularDataReader;
use League\Csv\CharsetConverter;
use stdClass;

trait Csv
{

    /**
     * @param string $file Path to CSV file
     * @return Reader
     */
    private function read(string $file)
    {

        $reader = Reader::createFromPath($file, 'r');
        $reader->setDelimiter(',');
        $reader->setHeaderOffset(0);

        $input_bom = $reader->getInputBOM();

        if ($input_bom === Reader::BOM_UTF16_LE || $input_bom === Reader::BOM_UTF16_BE) {
            CharsetConverter::addTo($reader, 'utf-16', 'utf-8');
        }

        return $reader;
    }
    /**
     * Retorna um objeto com o resultado da leitura do arquivo CSV
     *
     * @param string $fileName Nome do arquivo CSV
     * @return stdClass|Exception Objeto com o resultado da leitura do arquivo CSV ou Exception contendo o erro
     * 
     */
    public function csvReader(string $file): stdClass|Exception
    {

        try {

            $reader = $this->read($file);

            $response = new stdClass();

            $header = $reader->getHeader(); //returns the CSV header record
            $records = $reader->getRecords(); //returns all the CSV records as an Iterator object

            $response->header = $header;
            $response->records = $records;

            return $response;
        } catch (Exception $e) {
            return $e;
        }
    }

    /**
     * Retorna um objeto com o resultado da leitura do arquivo CSV
     *
     * @param string $fileName Nome do arquivo CSV
     * @param int $offset Início da leitura do arquivo CSV
     * @param int $limit Limite de registros a serem lidos
     * @return TabularDataReader|Exception Iteravel com o resultado da leitura do arquivo CSV ou Exception contendo o erro
     * 
     */
    public function getRecords(string $file, int $offset, int $limit)
    {
        try {

            $reader = $this->read($file);

            $stmt = Statement::create()
                ->offset($offset)
                ->limit($limit);

            return $stmt->process($reader);
        } catch (Exception $e) {
            return $e;
        }
    }

    /**
     * Retorna um objeto com o resultado da leitura do arquivo CSV
     *
     * @param string $fileName Nome do arquivo CSV que será criado
     * @param array $data Dados que serão gravados no arquivo CSV
     * @param bool $header Quando for true, cria o cabeçalho do arquivo CSV
     * @param string $mode Modo de gravação do arquivo CSV (w para sobrescrever ou a para adicionar)
     * @return bool|array True ou Registro que não foi inserido
     *
     * Example:
     * $csv = $this->createCSV(
     *       'filename.csv',
     *       $records = [
     *           ['name', 'surname', 'email'],
     *           ['john', 'doe', 'john.doe@example.com'],
     *       ],
     *       'w'
     *   );
     *  
     */
    public function createCSV(string $filename, array $data, bool $header = false, string $mode = 'w' | 'a'): bool|array
    {
        try {
            $writer = Writer::createFromPath(CONF_CSV_RIDERS . $filename, $mode);
            $writer->setDelimiter(',');

            if ($header == true && $mode == 'w') {
                $writer->insertOne($data);
                return true;
            }

            if ($header == false && $mode == 'a') {

                $writer->insertAll($data);
                return true;
            }
        } catch (CannotInsertRecord $e) {
            return $e->getMessage();
        }
        return 'Problema na inserção do registro, verifique $header ou $mode';
    }
}
