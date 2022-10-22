<?php

declare(strict_types=1);

namespace src\traits;

use Exception;
use League\Flysystem\Local\LocalFilesystemAdapter;
use League\Flysystem\Filesystem;
use League\Flysystem\FilesystemException;
use League\Flysystem\UnableToCheckExistence;
use League\Flysystem\UnixVisibility\PortableVisibilityConverter;
use League\Flysystem\UnableToCreateDirectory;
use League\Flysystem\Visibility;

trait Files
{

    private function createAdpater(string $rootPath)
    {

        $adapter = new LocalFilesystemAdapter(
            $rootPath,
            PortableVisibilityConverter::fromArray(
                [
                    'file' => 'public',
                    'dir' => 'public',
                ],
                Visibility::PUBLIC
            )
        );

        return new Filesystem($adapter);
    }

    private function directoryExists(string $rootPath, string $path)
    {

        $filesystem = $this->createAdpater($rootPath);

        try {
            return $filesystem->directoryExists($path);
        } catch (FilesystemException | UnableToCheckExistence $exception) {
            return $exception;
        }
    }

    /**
     * @param string $directory Nome do diretorio que será criado 
     */
    public function createDirectory(string $rootPath, string $path)
    {

        $filesystem = $this->createAdpater($rootPath);

        if (!$this->directoryExists($rootPath, $path)) {
            try {
                $filesystem->createDirectory($path);
                return true;
            } catch (FilesystemException | UnableToCreateDirectory $exception) {
                return $exception;
            }
        } else {
            return "Directory Exist";
        }
    }

    /**
     *
     * @param string $filename Nome do arquivo JSON que será criado
     * @param array $data Dados que serão gravados no arquivo JSON
     *  
     */
    public function createJsonFile(string $filename, array $data)
    {

        try {
            return file_put_contents(
                $filename . ".json",
                json_encode(
                    $data,
                    JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES
                )
            );
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
