<?php
declare(strict_types=1);

namespace Tests\File;

use
    Fyre\FileSystem\Exceptions\FileSystemException,
    Fyre\FileSystem\File;

trait CreateTest
{

    public function testCreate(): void
    {
        $file = new File('tmp/test.txt');

        $this->assertSame(
            $file,
            $file->create()
        );

        $this->assertTrue(
            $file->exists()
        );
    }

    public function testCreateFolder(): void
    {
        $file = new File('tmp/test/test.txt');

        $file->create();

        $this->assertTrue(
            $file->exists()
        );
    }

    public function testCreateExists(): void
    {
        $this->expectException(FileSystemException::class);

        $file = new File('tmp/test.txt', true);
        $file->create();
    }

}
