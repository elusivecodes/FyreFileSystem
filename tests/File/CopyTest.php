<?php
declare(strict_types=1);

namespace Tests\File;

use
    Fyre\FileSystem\Exceptions\FileSystemException,
    Fyre\FileSystem\File;

trait CopyTest
{

    public function testCopy(): void
    {
        $file = new File('tmp/test.txt', true);

        $this->assertSame(
            $file,
            $file->copy('tmp/test2.txt')
        );

        $file2 = new File('tmp/test2.txt');

        $this->assertTrue(
            $file2->exists()
        );
    }

    public function testCopyNotOverwrite(): void
    {
        $this->expectException(FileSystemException::class);

        $file = new File('tmp/test.txt', true);
        new File('tmp/test2.txt', true);
        $file->copy('tmp/test2.txt', false);
    }

    public function testCopyNotExists(): void
    {
        $this->expectException(FileSystemException::class);

        $file = new File('tmp/test.txt');
        $file->copy('tmp/test2.txt');
    }

    public function testCopyFolderNotExists(): void
    {
        $this->expectException(FileSystemException::class);

        $file = new File('tmp/test.txt', true);
        $file->copy('tmp/test/test2.txt');
    }

}
