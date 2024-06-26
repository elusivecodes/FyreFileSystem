<?php
declare(strict_types=1);

namespace Tests\File;

use Fyre\FileSystem\Exceptions\FileSystemException;
use Fyre\FileSystem\File;

trait ChmodTestTrait
{
    public function testChmod(): void
    {
        $file = new File('tmp/test.txt', true);

        $this->assertSame(
            $file,
            $file->chmod(777)
        );
    }

    public function testChmodNotExists(): void
    {
        $this->expectException(FileSystemException::class);

        $file = new File('tmp/test.txt');
        $file->chmod(777);
    }
}
