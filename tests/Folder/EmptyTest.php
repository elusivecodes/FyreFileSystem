<?php
declare(strict_types=1);

namespace Tests\Folder;

use
    Fyre\FileSystem\Exceptions\FileSystemException,
    Fyre\FileSystem\File,
    Fyre\FileSystem\Folder;

trait EmptyTest
{

    public function testEmpty(): void
    {
        $folder = new Folder('tmp/test', true);

        $this->assertEquals(
            $folder,
            $folder->empty()
        );

        $this->assertEquals(
            true,
            $folder->exists()
        );
    }

    public function testEmptyDeep(): void
    {
        $folder = new Folder('tmp/test', true);
        $file = new File('tmp/test/deep/test.txt', true);

        $this->assertEquals(
            $folder,
            $folder->empty()
        );

        $this->assertEquals(
            true,
            $folder->exists()
        );

        $this->assertEquals(
            true,
            $folder->isEmpty()
        );
    }

    public function testEmptyNotExists(): void
    {
        $this->expectException(FileSystemException::class);

        $folder = new Folder('tmp/test2');
        $folder->empty();
    }

}
