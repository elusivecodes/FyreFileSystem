<?php
declare(strict_types=1);

namespace Tests\Folder;

use
    Fyre\FileSystem\Exceptions\FileSystemException,
    Fyre\FileSystem\File,
    Fyre\FileSystem\Folder,
    Fyre\Utility\Path;

trait MoveTest
{

    public function testMove(): void
    {
        $folder = new Folder('tmp/test', true);

        $this->assertEquals(
            $folder,
            $folder->move('tmp/test2')
        );

        $folder2 = new Folder('tmp/test');

        $this->assertEquals(
            Path::resolve('tmp/test2'),
            $folder->path()
        );

        $this->assertEquals(
            true,
            $folder->exists()
        );

        $this->assertEquals(
            false,
            $folder2->exists()
        );
    }

    public function testMoveDeep(): void
    {
        $folder = new Folder('tmp/test', true);
        $file = new File('tmp/test/deep/test.txt', true);

        $folder->move('tmp/test2');

        $folder2 = new Folder('tmp/test');
        $file2 = new File('tmp/test2/deep/test.txt');

        $this->assertEquals(
            Path::resolve('tmp/test2'),
            $folder->path()
        );

        $this->assertEquals(
            false,
            $folder2->exists()
        );

        $this->assertEquals(
            true,
            $folder->exists()
        );

        $this->assertEquals(
            false,
            $file->exists()
        );

        $this->assertEquals(
            true,
            $file2->exists()
        );
    }

    public function testMoveNotOverwrite(): void
    {
        $this->expectException(FileSystemException::class);

        $folder = new Folder('tmp/test', true);
        new File('tmp/test/deep/test.txt', true);
        new File('tmp/test2/deep/test.txt', true);
        $folder->move('tmp/test2', false);
    }

    public function testMoveNotExists(): void
    {
        $this->expectException(FileSystemException::class);

        $folder = new Folder('tmp/test');
        $folder->move('tmp/test2');
    }

}
