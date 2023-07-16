<?php
declare(strict_types=1);

namespace Tests\Folder;

use Fyre\FileSystem\Exceptions\FileSystemException;
use Fyre\FileSystem\File;
use Fyre\FileSystem\Folder;

trait IsEmptyTestTrait
{

    public function testIsEmpty(): void
    {
        $folder = new Folder('tmp/test', true);

        $this->assertTrue(
            $folder->isEmpty()
        );
    }

    public function testIsEmptyNotEmpty(): void
    {
        $folder = new Folder('tmp/test', true);
        $folder2 = new Folder('tmp/test/deep', true);

        $this->assertFalse(
            $folder->isEmpty()
        );
    }

    public function testIsEmptyWithFile(): void
    {
        $folder = new Folder('tmp/test', true);
        $file = new File('tmp/test/test.txt', true);

        $this->assertFalse(
            $folder->isEmpty()
        );
    }

    public function testIsEmptyNotExists(): void
    {
        $this->expectException(FileSystemException::class);

        $folder = new Folder('tmp/test');
        $folder->isEmpty();
    }

}
