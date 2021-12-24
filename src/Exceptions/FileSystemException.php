<?php
declare(strict_types=1);

namespace Fyre\FileSystem\Exceptions;

use
    RuntimeException;

use function
    error_get_last;

class FileSystemException extends RuntimeException
{

    public static function forFileExists(string $path): self
    {
        return new static('File already exists: '.$path);
    }

    public static function forFileNotExists(string $path): self
    {
        return new static('File does not exist: '.$path);
    }

    public static function forFolderExists(string $path): self
    {
        return new static('Folder already exists: '.$path);
    }

    public static function forFolderNotExists(string $path): self
    {
        return new static('Folder does not exist: '.$path);
    }

    public static function forInvalidHandle(): self
    {
        return new static('Invalid file handle');
    }

    public static function forLastError(): self
    {
        $error = error_get_last();

        return new static($error['message'] ?? '');
    }

}
