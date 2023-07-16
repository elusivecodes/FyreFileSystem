<?php
declare(strict_types=1);

namespace Tests\Folder;

use Fyre\FileSystem\Exceptions\FileSystemException;
use Fyre\FileSystem\File;
use Fyre\FileSystem\Folder;

trait SizeTestTrait
{

    public function testSize(): void
    {
        $folder = new Folder('tmp/test', true);

        $this->assertSame(
            0,
            $folder->size()
        );
    }

    public function testSizeDeep(): void
    {
        $folder = new Folder('tmp/test', true);

        $file = new File('tmp/test/deep/test.txt', true);
        $file->open('wssss');
        $file->write('test');
        $file->close();

        $this->assertSame(
            4100,
            $folder->size()
        );
    }

    public function testSizeNotExists(): void
    {
        $this->expectException(FileSystemException::class);

        $folder = new Folder('tmp/test');
        $folder->size();
    }

}
