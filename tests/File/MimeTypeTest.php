<?php
declare(strict_types=1);

namespace Tests\File;

use
    Fyre\FileSystem\Exceptions\FileSystemException,
    Fyre\FileSystem\File;

trait MimeTypeTest
{

    public function testMimeType(): void
    {
        $file = new File('tmp/test/test.txt', true);
        $file->open('w');
        $file->write('test');
        $file->close();

        $this->assertSame(
            'text/plain',
            $file->mimeType()
        );
    }

    public function testMimeTypeNotExists(): void
    {
        $this->expectException(FileSystemException::class);

        $file = new File('tmp/test/test.txt');
        $file->mimeType();
    }

}
