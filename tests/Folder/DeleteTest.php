<?php
declare(strict_types=1);

namespace Tests\Folder;

use
    Fyre\FileSystem\Exceptions\FileSystemException,
    Fyre\FileSystem\File,
    Fyre\FileSystem\Folder;

trait DeleteTest
{

    public function testDelete(): void
    {
        $folder = new Folder('tmp/test2', true);

        $this->assertSame(
            $folder,
            $folder->delete()
        );

        $this->assertFalse(
            $folder->exists()
        );
    }

    public function testDeleteDeep(): void
    {
        $folder = new Folder('tmp/test', true);
        $file = new File('tmp/test/file/test.txt', true);

        $folder->delete();

        $this->assertFalse(
            $file->exists()
        );

        $this->assertFalse(
            $folder->exists()
        );
    }

    public function testDeleteNotExists(): void
    {
        $this->expectException(FileSystemException::class);

        $folder = new Folder('tmp/test2');
        $folder->delete();
    }

}
