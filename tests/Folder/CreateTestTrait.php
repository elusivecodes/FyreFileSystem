<?php
declare(strict_types=1);

namespace Tests\Folder;

use Fyre\FileSystem\Exceptions\FileSystemException;
use Fyre\FileSystem\File;
use Fyre\FileSystem\Folder;

trait CreateTestTrait
{
    public function testCreate(): void
    {
        $folder = new Folder('tmp/test');

        $this->assertSame(
            $folder,
            $folder->create()
        );

        $this->assertTrue(
            $folder->exists()
        );
    }

    public function testCreateExists(): void
    {
        $this->expectException(FileSystemException::class);

        $folder = new Folder('tmp/test', true);
        $folder->create();
    }

    public function testCreateExistsFile(): void
    {
        $this->expectException(FileSystemException::class);

        new File('tmp/test', true);
        $folder = new Folder('tmp/test', true);
        $folder->create();
    }
}
