<?php
declare(strict_types=1);

namespace Tests\File;

use Fyre\FileSystem\Exceptions\FileSystemException;
use Fyre\FileSystem\File;

trait TruncateTestTrait
{
    public function testTruncate(): void
    {
        $file = new File('tmp/test/test.txt', true);
        $file->open('w');
        $file->write('test');

        $this->assertSame(
            $file,
            $file->truncate()
        );

        $file->close();

        $this->assertSame(
            '',
            $file->contents()
        );
    }

    public function testTruncateInvalidHandle(): void
    {
        $this->expectException(FileSystemException::class);

        $file = new File('tmp/test/test.txt', true);
        $file->open('r');
        $file->truncate();
    }

    public function testTruncateNoHandle(): void
    {
        $this->expectException(FileSystemException::class);

        $file = new File('tmp/test/test.txt', true);
        $file->truncate();
    }

    public function testTruncateSize(): void
    {
        $file = new File('tmp/test/test.txt', true);
        $file->open('w');
        $file->write('test');
        $file->truncate(2);
        $file->close();

        $this->assertSame(
            'te',
            $file->contents()
        );
    }
}
