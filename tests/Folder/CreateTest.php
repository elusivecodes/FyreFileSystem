<?php
declare(strict_types=1);

namespace Tests\Folder;

use
    Fyre\FileSystem\Exceptions\FileSystemException,
    Fyre\FileSystem\File,
    Fyre\FileSystem\Folder;

trait CreateTest
{

    public function testCreate(): void
    {
        $folder = new Folder('tmp/test');

        $this->assertEquals(
            $folder,
            $folder->create()
        );

        $this->assertEquals(
            true,
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
