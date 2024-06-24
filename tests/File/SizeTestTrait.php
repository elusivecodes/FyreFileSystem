<?php
declare(strict_types=1);

namespace Tests\File;

use Fyre\FileSystem\Exceptions\FileSystemException;
use Fyre\FileSystem\File;

trait SizeTestTrait
{
    public function testSize(): void
    {
        $file = new File('tmp/test/test.txt', true);
        $file->open('w');
        $file->write('test');
        $file->close();

        $this->assertSame(
            4,
            $file->size()
        );
    }

    public function testSizeNotExists(): void
    {
        $this->expectException(FileSystemException::class);

        $file = new File('tmp/test/test.txt');
        $file->size();
    }
}
