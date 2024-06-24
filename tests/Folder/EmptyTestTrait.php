<?php
declare(strict_types=1);

namespace Tests\Folder;

use Fyre\FileSystem\Exceptions\FileSystemException;
use Fyre\FileSystem\File;
use Fyre\FileSystem\Folder;

trait EmptyTestTrait
{
    public function testEmpty(): void
    {
        $folder = new Folder('tmp/test', true);

        $this->assertSame(
            $folder,
            $folder->empty()
        );

        $this->assertTrue(
            $folder->exists()
        );
    }

    public function testEmptyDeep(): void
    {
        $folder = new Folder('tmp/test', true);
        $file = new File('tmp/test/deep/test.txt', true);

        $this->assertSame(
            $folder,
            $folder->empty()
        );

        $this->assertTrue(
            $folder->exists()
        );

        $this->assertTrue(
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
