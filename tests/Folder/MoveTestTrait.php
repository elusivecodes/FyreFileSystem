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
        $folder1 = new Folder('tmp/test', true);
        $folder2 = $folder1->move('tmp/test2');

        $this->assertNotSame(
            $folder1,
            $folder2
        );

        $this->assertFalse(
            $folder1->exists()
        );

        $this->assertSame(
            Path::resolve('tmp/test2'),
            $folder2->path()
        );

        $this->assertTrue(
            $folder2->exists()
        );
    }

    public function testMoveDeep(): void
    {
        $folder1 = new Folder('tmp/test', true);
        $file1 = new File('tmp/test/deep/test.txt', true);

        $folder2 = $folder1->move('tmp/test2');
        $file2 = new File('tmp/test2/deep/test.txt');

        $this->assertFalse(
            $folder1->exists()
        );

        $this->assertFalse(
            $file1->exists()
        );

        $this->assertSame(
            Path::resolve('tmp/test2'),
            $folder2->path()
        );

        $this->assertTrue(
            $folder2->exists()
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
