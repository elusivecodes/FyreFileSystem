<?php
declare(strict_types=1);

namespace Tests\File;

use
   Fyre\FileSystem\Exceptions\FileSystemException,
   Fyre\FileSystem\File;

trait ReadTest
{

    public function testRead(): void
    {
        $file = new File('tmp/test/test.txt', true);
        $file->open('w+');
        $file->write('test');
        $file->rewind();

        $this->assertSame(
            'te',
            $file->read(2)
        );
    }

    public function testReadNoHandle(): void
    {
        $this->expectException(FileSystemException::class);

        $file = new File('tmp/test/test.txt', true);
        $file->read(4);
    }

    public function testReadInvalidHandle(): void
    {
        $this->expectException(FileSystemException::class);

        $file = new File('tmp/test/test.txt', true);
        $file->open('w');
        $file->read(4);
    }

}
