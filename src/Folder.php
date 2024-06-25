<?php
declare(strict_types=1);

namespace Fyre\FileSystem;

use FileSystemIterator;
use Fyre\FileSystem\Exceptions\FileSystemException;
use Fyre\Utility\Path;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

use function chmod;
use function copy;
use function file_exists;
use function fileatime;
use function filemtime;
use function fileperms;
use function is_dir;
use function mkdir;
use function rmdir;
use function str_replace;
use function touch;
use function unlink;

/**
 * Folder
 */
class Folder
{
    protected string $path;

    /**
     * New Folder constructor.
     *
     * @param string $path The folder path.
     * @param bool $create Whether to create the folder (if it doesn't exist).
     * @param int $permissions The permissions.
     */
    public function __construct(string $path, bool $create = false, int $permissions = 0755)
    {
        $this->path = Path::resolve($path);

        if ($create && !$this->exists()) {
            $this->create($permissions);
        }
    }

    /**
     * Get the contents of the folder.
     *
     * @return array The contents of the folder.
     */
    public function contents(): array
    {
        $this->checkExists();

        $iterator = new FileSystemIterator($this->path);

        $contents = [];

        foreach ($iterator as $item) {
            $filePath = $item->getPathname();

            if ($item->isDir()) {
                $contents[] = new static($filePath);
            } else {
                $contents[] = new File($filePath);
            }
        }

        return $contents;
    }

    /**
     * Copy the folder to a new destination.
     *
     * @param string $destination The destination.
     * @param bool $overwrite Whether to overwrite existing files.
     * @return Folder The Folder.
     *
     * @throws FileSystemException if the folder could not be copied.
     */
    public function copy(string $destination, bool $overwrite = true): static
    {
        $this->checkExists();

        $destination = Path::resolve($destination);

        $permissions = fileperms($this->path);

        if (!file_exists($destination) && !is_dir($destination) && !@mkdir($destination, $permissions, true)) {
            throw FileSystemException::forLastError();
        }

        foreach ($this->getIterator(RecursiveIteratorIterator::SELF_FIRST) as $item) {
            $filePath = $item->getPathname();
            $newPath = str_replace($this->path, $destination, $filePath);

            $permissions = fileperms($filePath);

            if ($item->isDir()) {
                if (!is_dir($newPath) && !@mkdir($newPath, $permissions, true)) {
                    throw FileSystemException::forLastError();
                }
            } else {
                if (!$overwrite && file_exists($newPath)) {
                    throw FileSystemException::forFileExists($newPath);
                }

                if (!@copy($filePath, $newPath)) {
                    throw FileSystemException::forLastError();
                }

                chmod($newPath, $permissions);

                $modifiedTime = filemtime($filePath);
                $accessTime = fileatime($filePath);
                touch($newPath, $modifiedTime, $accessTime);
            }
        }

        return $this;
    }

    /**
     * Create the folder.
     *
     * @param int $permissions The permissions.
     * @return Folder The Folder.
     *
     * @throws FileSystemException if the folder exists or creation fails.
     */
    public function create(int $permissions = 0755): static
    {
        if ($this->exists()) {
            throw FileSystemException::forFolderExists($this->path);
        }

        if (!@mkdir($this->path, $permissions, true)) {
            throw FileSystemException::forLastError();
        }

        return $this;
    }

    /**
     * Delete the folder.
     *
     * @return Folder The Folder.
     *
     * @throws FileSystemException if the folder could not be removed.
     */
    public function delete(): static
    {
        $this->empty();

        if (!@rmdir($this->path)) {
            throw FileSystemException::forLastError();
        }

        return $this;
    }

    /**
     * Empty the folder.
     *
     * @return Folder The Folder.
     *
     * @throws FileSystemException if the folder could not be emptied.
     */
    public function empty(): static
    {
        foreach ($this->getIterator(RecursiveIteratorIterator::CHILD_FIRST) as $item) {
            $filePath = $item->getPathname();

            if ($item->isDir()) {
                if (!@rmdir($filePath)) {
                    throw FileSystemException::forLastError();
                }
            } else {
                if (!@unlink($filePath)) {
                    throw FileSystemException::forLastError();
                }
            }
        }

        return $this;
    }

    /**
     * Determine if the folder exists.
     *
     * @return bool TRUE if the folder exists, otherwise FALSE.
     */
    public function exists(): bool
    {
        return $this->path && file_exists($this->path) && is_dir($this->path);
    }

    /**
     * Determine if the folder is empty.
     *
     * @return bool TRUE if the folder is empty, otherwise FALSE.
     */
    public function isEmpty(): bool
    {
        $this->checkExists();

        return !(new FileSystemIterator($this->path))->valid();
    }

    /**
     * Move the folder to a new destination.
     *
     * @param string $destination The destination.
     * @param bool $overwrite Whether to overwrite existing files.
     * @return Folder The Folder.
     */
    public function move(string $destination, bool $overwrite = true): static
    {
        $this->copy($destination, $overwrite);
        $this->delete();

        $this->path = Path::resolve($destination);

        return $this;
    }

    /**
     * Get the folder name.
     *
     * @return string The folder name.
     */
    public function name(): string
    {
        return Path::baseName($this->path);
    }

    /**
     * Get the full path to the folder.
     *
     * @return string The full path.
     */
    public function path(): string
    {
        return $this->path;
    }

    /**
     * Get the size of the folder (in bytes).
     *
     * @return int The size of the folder (in bytes).
     */
    public function size(): int
    {
        $size = 0;
        foreach ($this->getIterator(RecursiveIteratorIterator::SELF_FIRST) as $item) {
            $size += $item->getSize();
        }

        return $size;
    }

    /**
     * Check the folder exists.
     *
     * @throws FileSystemException if the folder doesn't exist.
     */
    protected function checkExists(): void
    {
        if (!$this->exists()) {
            throw FileSystemException::forFolderNotExists($this->path);
        }
    }

    /**
     * Get a recursive iterator for the folder.
     *
     * @param int $mode The iterator mode.
     * @return RecursiveIteratorIterator The recursive iterator.
     */
    protected function getIterator(int $mode): RecursiveIteratorIterator
    {
        $this->checkExists();

        $directory = new RecursiveDirectoryIterator($this->path, RecursiveDirectoryIterator::SKIP_DOTS);

        return new RecursiveIteratorIterator($directory, $mode);
    }
}
