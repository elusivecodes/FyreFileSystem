<?php
declare(strict_types=1);

namespace Tests\Folder;

use
    Fyre\FileSystem\Exceptions\FileSystemException,
    Fyre\FileSystem\File,
    Fyre\FileSystem\Folder;

trait IsEmptyTest
{

    public function testIsEmpty(): void
    {
        $folder = new Folder('tmp/test', true);

        $this->assertEquals(
            true,
            $folder->isEmpty()
        );
    }

    public function testIsEmptyNotEmpty(): void
    {
        $folder = new Folder('tmp/test', true);
        $folder2 = new Folder('tmp/test/deep', true);

        $this->assertEquals(
            false,
            $folder->isEmpty()
        );
    }

    public function testIsEmptyWithFile(): void
    {
        $folder = new Folder('tmp/test', true);
        $file = new File('tmp/test/test.txt', true);

        $this->assertEquals(
            false,
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
