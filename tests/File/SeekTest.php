<?php
declare(strict_types=1);

namespace Tests\File;

use
    Fyre\FileSystem\Exceptions\FileSystemException,
    Fyre\FileSystem\File;

trait SeekTest
{

    public function testSeek(): void
    {
        $file = new File('tmp/test/test.txt', true);
        $file->open('w');
        $file->write('test');

        $this->assertSame(
            $file,
            $file->seek(2)
        );

        $this->assertSame(
            2,
            $file->tell()
        );
    }

    public function testSeekNoHandle(): void
    {
        $this->expectException(FileSystemException::class);

        $file = new File('tmp/test/test.txt', true);
        $file->seek(0);
    }

}
