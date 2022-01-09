<?php
declare(strict_types=1);

namespace Tests\File;

use
    Fyre\FileSystem\Exceptions\FileSystemException,
    Fyre\FileSystem\File;

trait RewindTest
{

    public function testRewind(): void
    {
        $file = new File('tmp/test/test.txt', true);
        $file->open('w');
        $file->write('test');

        $this->assertSame(
            $file,
            $file->rewind()
        );

        $this->assertSame(
            0,
            $file->tell()
        );
    }

    public function testRewindNoHandle(): void
    {
        $this->expectException(FileSystemException::class);

        $file = new File('tmp/test/test.txt', true);
        $file->rewind();
    }

}
