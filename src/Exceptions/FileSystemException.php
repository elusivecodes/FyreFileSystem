<?php
declare(strict_types=1);

namespace Fyre\FileSystem\Exceptions;

use
    Fyre\Error\Exceptions\Exception;

use function
    error_get_last;

/**
 * FileSystemException
 */
class FileSystemException extends Exception
{

    public static function forFileExists(string $path): static
    {
        return new static('File already exists: '.$path);
    }

    public static function forFileNotExists(string $path): static
    {
        return new static('File does not exist: '.$path);
    }

    public static function forFolderExists(string $path): static
    {
        return new static('Folder already exists: '.$path);
    }

    public static function forFolderNotExists(string $path): static
    {
        return new static('Folder does not exist: '.$path);
    }

    public static function forInvalidHandle(): static
    {
        return new static('Invalid file handle');
    }

    public static function forLastError(): static
    {
        $error = error_get_last();

        return new static($error['message'] ?? '');
    }

}
