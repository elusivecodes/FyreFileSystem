<?php
declare(strict_types=1);

namespace Tests\Folder;

use Fyre\FileSystem\Exceptions\FileSystemException;
use Fyre\FileSystem\File;
use Fyre\FileSystem\Folder;
use Fyre\Utility\Path;

trait MoveTestTrait
{
    public function testMove(): void
    {
        $folder = new Folder('tmp/test', true);

        $this->assertSame(
            $folder,
            $folder->move('tmp/test2')
        );

        $folder2 = new Folder('tmp/test');

        $this->assertSame(
            Path::resolve('tmp/test2'),
            $folder->path()
        );

        $this->assertTrue(
            $folder->exists()
        );

        $this->assertFalse(
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

        $this->assertSame(
            Path::resolve('tmp/test2'),
            $folder->path()
        );

        $this->assertFalse(
            $folder2->exists()
        );

        $this->assertTrue(
            $folder->exists()
        );

        $this->assertFalse(
            $file->exists()
        );

        $this->assertTrue(
            $file2->exists()
        );
    }

    public function testMoveNotExists(): void
    {
        $this->expectException(FileSystemException::class);

        $folder = new Folder('tmp/test');
        $folder->move('tmp/test2');
    }

    public function testMoveNotOverwrite(): void
    {
        $this->expectException(FileSystemException::class);

        $folder = new Folder('tmp/test', true);
        new File('tmp/test/deep/test.txt', true);
        new File('tmp/test2/deep/test.txt', true);
        $folder->move('tmp/test2', false);
    }
}
