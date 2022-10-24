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
use League\Flysystem\UnableToDeleteDirectory;
use League\Flysystem\UnableToReadFile;
use League\Flysystem\UnableToDeleteFile;
use League\Flysystem\Visibility;
use src\traits\GetNames;

trait Files
{

    use GetNames;

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

    private function fileExists(string $rootPath, string $path)
    {

        $filesystem = $this->createAdpater($rootPath);

        try {
            return $filesystem->fileExists($path);
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
     * @param string $directory Nome do diretorio que será deletado
     */
    public function deleteDirectory(string $rootPath, string $path)
    {

        $filesystem = $this->createAdpater($rootPath);

        if ($this->directoryExists($rootPath, $path)) {
            try {
                $filesystem->deleteDirectory($path);
                return true;
            } catch (FilesystemException | UnableToDeleteDirectory $exception) {
                return $exception;
            }
        } else {
            return "Directory don't exist";
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

    /**
     *
     * @param string $filename Nome do arquivo JSON que será apagado
     *  
     */
    public function deleteJsonFile(string $rootPath, string $path)
    {

        $filesystem = $this->createAdpater($rootPath);

        if ($this->fileExists($rootPath, $path)) {
            try {
                //$filesystem->delete($path);
                return $path;
            } catch (FilesystemException | UnableToDeleteFile $exception) {
                return $exception;
            }
        } else {
            return "File don't exist";
        }
    }
    /**
     *
     * @param string $filename Nome do arquivo JSON que será lido
     *  
     */
    public function readJsonFile(string $rootPath, string $path)
    {

        $filesystem = $this->createAdpater($rootPath);

        if ($this->fileExists($rootPath, $path)) {
            try {
                return $filesystem->read($path);
            } catch (FilesystemException | UnableToReadFile $exception) {
                return $exception;
            }
        } else {
            return "File don't exist";
        }
    }
}
