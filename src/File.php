<?php
declare(strict_types=1);

namespace Fyre\FileSystem;

use finfo;
use Fyre\FileSystem\Exceptions\FileSystemException;
use Fyre\Utility\Path;

use const FILEINFO_MIME;
use const LOCK_EX;
use const LOCK_SH;
use const LOCK_UN;

use function chmod;
use function copy;
use function decoct;
use function fclose;
use function feof;
use function fgetcsv;
use function file_exists;
use function file_get_contents;
use function fileatime;
use function filegroup;
use function filemtime;
use function fileowner;
use function fileperms;
use function filesize;
use function finfo_close;
use function flock;
use function fopen;
use function fread;
use function fseek;
use function ftell;
use function ftruncate;
use function fwrite;
use function is_executable;
use function is_file;
use function is_readable;
use function is_writable;
use function rewind;
use function strtok;
use function time;
use function touch;
use function unlink;

/**
 * File
 */
class File
{

    const LOCK_SHARED = LOCK_SH;
    const LOCK_EXCLUSIVE = LOCK_EX;
    const UNLOCK = LOCK_UN;

    protected $handle = null;

    protected string $path;

    protected Folder $folder;

    /**
     * New File constructor.
     * @param string $path The file path.
     * @param bool $create Whether to create the file (if it doesn't exist).
     */
    public function __construct(string $path, bool $create = false)
    {
        $this->path = Path::resolve($path);

        $this->folder = new Folder($this->dirName(), $create);

        if ($create && !$this->exists()) {
            $this->create();
        }
    }

    /**
     * Get the file access time.
     * @return int The file access time.
     * @throws FileSystemException if the access time could not be retrieved.
     */
    public function accessTime(): int
    {
        $this->checkExists();

        $accessTime = fileatime($this->path);

        if ($accessTime === false) {
            throw FileSystemException::forLastError();
        }

        return $accessTime;
    }

    /**
     * Get the filename.
     * @return string The filename.
     */
    public function baseName(): string
    {
        return Path::baseName($this->path);
    }

    /**
     * Change the file permissions.
     * @param int $permissions The file permissions.
     * @return File The File.
     * @throws FileSystemException if the permissions could not be updated.
     */
    public function chmod(int $permissions): static
    {
        $this->checkExists();

        if (!@chmod($this->path, $permissions)) {
            throw FileSystemException::forLastError();
        }

        return $this;
    }

    /**
     * Close the file handle.
     * @return File The File.
     * @throws FileSystemException if the handle could not be closed.
     */
    public function close(): static
    {
        $this->checkHandle();

        if (!fclose($this->handle)) {
            throw FileSystemException::forLastError();
        }

        $this->handle = null;

        return $this;
    }

    /**
     * Get the contents of the file.
     * @return string The contents of the file.
     * @throws FileSystemException if the contents could not be read.
     */
    public function contents(): string
    {
        $this->checkExists();

        $contents = file_get_contents($this->path);

        if ($contents === false) {
            throw FileSystemException::forLastError();
        }

        return $contents;
    }

    /**
     * Copy the file to a new destination.
     * @param string $destination The destination.
     * @param bool $overwrite Whether to overwrite existing files.
     * @return File The File.
     * @throws FileSystemException if the file could not be copied.
     */
    public function copy(string $destination, bool $overwrite = true): static
    {
        if (file_exists($destination) && !$overwrite) {
            throw FileSystemException::forFileExists($destination);
        }

        if (!@copy($this->path, $destination)) {
            throw FileSystemException::forLastError();
        }

        $permissions = fileperms($this->path);
        chmod($destination, $permissions);

        $modifiedTime = $this->modifiedTime();
        $accessTime = $this->accessTime();
        touch($destination, $modifiedTime, $accessTime);

        return $this;
    }

    /**
     * Create the file.
     * @return File The File.
     * @throws FileSystemException if the file exists.
     */
    public function create(): static
    {
        if ($this->exists()) {
            throw FileSystemException::forFileExists($this->path);
        }

        if (!$this->folder->exists()) {
            $this->folder->create();
        }

        if (!$this->exists()) {
            $this->touch();
        }

        return $this;
    }

    /**
     * Parse CSV values from a file.
     * @param int $length The maximum length to parse.
     * @param string $separator The field separator.
     * @param string $enclosure The field enclosure character.
     * @param string $escape The escape character.
     * @return array The parsed CSV values.
     * @throws FileSystemException if the file could not be parsed.
     */
    public function csv(int $length = 0, string $separator = ',', string $enclosure = '"', string $escape = '\\'): array
    {
        $this->checkHandle();

        $data = @fgetcsv($this->handle, $length, $separator, $enclosure, $escape);

        if ($data === false) {
            throw FileSystemException::forLastError();
        }

        return $data;
    }

    /**
     * Delete the file.
     * @return File The File.
     * @throws FileSystemException if the file could not be deleted.
     */
    public function delete(): static
    {
        $this->checkExists();

        if (!@unlink($this->path)) {
            throw FileSystemException::forLastError();
        }

        return $this;
    }

    /**
     * Get the directory name.
     * @return string The directory name.
     */
    public function dirName(): string
    {
        return Path::dirName($this->path);
    }

    /**
     * Determine if the pointer is at the end of the file.
     * @return bool TRUE if the pointer is at the end of the file, otherwise FALSE.
     */
    public function ended(): bool
    {
        $this->checkHandle();

        return feof($this->handle);
    }

    /**
     * Determine if the file exists.
     * @return bool TRUE if the file exists, otherwise FALSE.
     */
    public function exists(): bool
    {
        return $this->path && file_exists($this->path) && is_file($this->path);
    }

    /**
     * Get the file extension.
     * @return string The file extension.
     */
    public function extension(): string
    {
        return Path::extension($this->path);
    }

    /**
     * Get the filename (without extension).
     * @return string The filename (without extension).
     */
    public function fileName(): string
    {
        return Path::fileName($this->path);
    }

    /**
     * Get the Folder.
     * @return Folder The Folder.
     */
    public function folder(): Folder
    {
        return $this->folder;
    }

    /**
     * Get the file group.
     * @return int The file group.
     * @throws FileSystemException if the group could not be retrieved.
     */
    public function group(): int
    {
        $this->checkExists();

        $group = filegroup($this->path);

        if ($group === false) {
            throw FileSystemException::forLastError();
        }

        return $group;
    }

    /**
     * Determine if the file is executable.
     * @return bool TRUE if the file is executable, otherwise FALSE.
     */
    public function isExecutable(): bool
    {
        return is_executable($this->path);
    }

    /**
     * Determine if the file is readable.
     * @return bool TRUE if the file is readable, otherwise FALSE.
     */
    public function isReadable(): bool
    {
        return is_readable($this->path);
    }

    /**
     * Determine if the file is writable.
     * @return bool TRUE if the file is writable, otherwise FALSE.
     */
    public function isWritable(): bool
    {
        return is_writable($this->path);
    }

    /**
     * Lock the file handle.
     * @param int|null $operation The lock operation.
     * @return File The File.
     * @throws FileSystemException if the lock could not be acquired.
     */
    public function lock(int|null $operation = null): static
    {
        $this->checkHandle();

        if (!flock($this->handle, $operation ?? static::LOCK_SHARED)) {
            throw FileSystemException::forLastError();
        }

        return $this;
    }

    /**
     * Get the MIME content type.
     * @return string The MIME content type.
     */
    public function mimeType(): string
    {
        $this->checkExists();

        $finfo = new finfo(FILEINFO_MIME);
        $type = $finfo->file($this->path);
        finfo_close($finfo);

        return strtok($type ?: '', ';');
    }

    /**
     * Get the file modified time.
     * @return int The file modified time.
     * @throws FileSystemException if the modified time could not be retrieved.
     */
    public function modifiedTime(): int
    {
        $this->checkExists();

        $modifiedTime = filemtime($this->path);

        if ($modifiedTime === false) {
            throw FileSystemException::forLastError();
        }

        return $modifiedTime;
    }

    /**
     * Open a file handle.
     * @param string $mode The access mode.
     * @return File The File.
     * @throws FileSystemException if the handle could not be opened.
     */
    public function open(string $mode = 'r'): static
    {
        $this->handle = fopen($this->path, $mode);

        if (!$this->handle) {
            throw FileSystemException::forLastError();
        }

        return $this;
    }

    /**
     * Get the file owner.
     * @return int The file owner.
     * @throws FileSystemException if the owner could not be retrieved.
     */
    public function owner(): int
    {
        $this->checkExists();

        $owner = fileowner($this->path);

        if ($owner === false) {
            throw FileSystemException::forLastError();
        }

        return $owner;
    }

    /**
     * Get the full path to the file.
     * @return string The full path.
     */
    public function path(): string
    {
        return $this->path;
    }

    /**
     * Get the file permissions.
     * @return string The file permissions.
     * @throws FileSystemException if the permissions could not be retrieved.
     */
    public function permissions(): string
    {
        $this->checkExists();

        $permissions = fileperms($this->path);

        if ($permissions === false) {
            throw FileSystemException::forLastError();
        }

        return decoct($permissions & 0777);
    }

    /**
     * Read file data.
     * @param int $length The number of bytes to read.
     * @return string The data.
     * @throws FileSystemException if the data could not be read.
     */
    public function read(int $length): string
    {
        $this->checkHandle();

        $data = @fread($this->handle, $length);

        if ($data === false) {
            throw FileSystemException::forLastError();
        }

        return $data;
    }

    /**
     * Rewind the pointer position.
     * @return File The File.
     * @throws FileSystemException if the handle could not be rewound.
     */
    public function rewind(): static
    {
        $this->checkHandle();

        if (!rewind($this->handle)) {
            throw FileSystemException::forLastError();
        }

        return $this;
    }

    /**
     * Move the pointer position.
     * @param int $offset The new pointer position.
     * @return File The File.
     * @throws FileSystemException if the seek fails.
     */
    public function seek(int $offset): static
    {
        $this->checkHandle();

        if (fseek($this->handle, $offset) !== 0) {
            throw FileSystemException::forLastError();
        }

        return $this;
    }

    /**
     * Get the size of the file (in bytes).
     * @return int The size of the file (in bytes).
     * @throws FileSystemException if the size could not be read.
     */
    public function size(): int
    {
        $this->checkExists();

        $size = filesize($this->path);

        if ($size === false) {
            throw FileSystemException::forLastError();
        }

        return $size;
    }

    /**
     * Get the current pointer position.
     * @return int The current pointer position.
     * @throws FileSystemException if the offset could not be read.
     */
    public function tell(): int
    {
        $this->checkHandle();

        $offset = ftell($this->handle);

        if ($offset === false) {
            throw FileSystemException::forLastError();
        }

        return $offset;
    }

    /**
     * Touch the file.
     * @param int|null $time The touch time.
     * @param int|null $accessTime The access time.
     * @return File The File.
     * @throws FileSystemException if the file could not be touched.
     */
    public function touch(int|null $time = null, int|null $accessTime = null): static
    {
        $time ??= time();

        if (!touch($this->path, $time, $accessTime ?? $time)) {
            throw FileSystemException::forLastError();
        }

        return $this;
    }

    /**
     * Truncate the file.
     * @param int $size The size to truncate to.
     * @return File The File.
     * @throws FileSystemException if the file could not be truncated.
     */
    public function truncate(int $size = 0): static
    {
        $this->checkHandle();

        if (!ftruncate($this->handle, $size)) {
            throw FileSystemException::forLastError();
        }

        return $this;
    }

    /**
     * Unlock the file handle.
     * @return File The File.
     */
    public function unlock(): static
    {
        return $this->lock(static::UNLOCK);
    }

    /**
     * Write data to the file.
     * @param string $data The data to write.
     * @return File The File.
     * @throws FileSystemException if the data could not be written.
     */
    public function write(string $data): static
    {
        $this->checkHandle();

        if (@fwrite($this->handle, $data) === false) {
            throw FileSystemException::forLastError();
        }

        return $this;
    }

    /**
     * Check the file exists.
     * @throws FileSystemException if the file doesn't exist.
     */
    protected function checkExists(): void
    {
        if (!$this->exists()) {
            throw FileSystemException::forFileNotExists($this->path);
        }
    }

    /**
     * Check the file handle.
     * @throws FileSytemException if there's no file handle.
     */
    protected function checkHandle(): void
    {
        if (!$this->handle) {
            throw FileSystemException::forInvalidHandle();
        }
    }

}
