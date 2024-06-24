<?php
declare(strict_types=1);

namespace Tests\File;

use Fyre\FileSystem\Exceptions\FileSystemException;
use Fyre\FileSystem\File;

trait DeleteTestTrait
{
    public function testDelete(): void
    {
        $file = new File('tmp/test/test.txt', true);

        $this->assertSame(
            $file,
            $file->delete()
        );

        $this->assertFalse(
            $file->exists()
        );
    }

    public function testDeleteNotExists(): void
    {
        $this->expectException(FileSystemException::class);

        $file = new File('tmp/test/test.txt');
        $file->delete();
    }
}
