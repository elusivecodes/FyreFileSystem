<?php
declare(strict_types=1);

namespace Tests\Folder;

use
    Fyre\FileSystem\Exceptions\FileSystemException,
    Fyre\FileSystem\File,
    Fyre\FileSystem\Folder,
    Fyre\Utility\Path;

trait CopyTest
{

    public function testCopy(): void
    {
        $folder = new Folder('tmp/test', true);

        $this->assertEquals(
            $folder,
            $folder->copy('tmp/test2')
        );

        $folder2 = new Folder('tmp/test2');

        $this->assertEquals(
            Path::resolve('tmp/test'),
            $folder->path()
        );

        $this->assertEquals(
            true,
            $folder->exists()
        );

        $this->assertEquals(
            true,
            $folder2->exists()
        );
    }

    public function testCopyDeep(): void
    {
        $folder = new Folder('tmp/test', true);
        $file = new File('tmp/test/deep/test.txt', true);

        $folder->copy('tmp/test2');

        $file2 = new File('tmp/test2/deep/test.txt');

        $this->assertEquals(
            true,
            $file->exists()
        );

        $this->assertEquals(
            true,
            $file2->exists()
        );
    }

    public function testCopyNotOverwrite(): void
    {
        $this->expectException(FileSystemException::class);

        $folder = new Folder('tmp/test', true);
        new File('tmp/test/deep/test.txt', true);
        new File('tmp/test2/deep/test.txt', true);
        $folder->copy('tmp/test2', false);
    }

    public function testCopyNotExists(): void
    {
        $this->expectException(FileSystemException::class);

        $folder = new Folder('tmp/test');
        $folder->copy('tmp/test2');
    }

}
