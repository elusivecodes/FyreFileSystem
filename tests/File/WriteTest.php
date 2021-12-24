<?php
declare(strict_types=1);

namespace Tests\File;

use
    Fyre\FileSystem\Exceptions\FileSystemException,
    Fyre\FileSystem\File;

trait WriteTest
{

    public function testWrite(): void
    {
        $file = new File('tmp/test/test.txt', true);
        $file->open('w');

        $this->assertEquals(
            $file,
            $file->write('test')
        );

        $file->close();

        $this->assertEquals(
            'test',
            $file->contents()
        );
    }

    public function testWriteAppends(): void
    {
        $file = new File('tmp/test/test.txt', true);
        $file->open('w');
        $file->write('test');
        $file->write('1');
        $file->close();

        $this->assertEquals(
            'test1',
            $file->contents()
        );
    }

    public function testWriteNoHandle(): void
    {
        $this->expectException(FileSystemException::class);

        $file = new File('tmp/test/test.txt', true);
        $file->write('test');
    }

    public function testWriteInvalidHandle(): void
    {
        $this->expectException(FileSystemException::class);

        $file = new File('tmp/test/test.txt', true);
        $file->open('r');
        $file->write('test');
    }

}
