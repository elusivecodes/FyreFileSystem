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

        $this->assertEquals(
            $file,
            $file->seek(2)
        );

        $this->assertEquals(
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
