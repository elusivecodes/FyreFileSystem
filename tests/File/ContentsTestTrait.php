<?php
declare(strict_types=1);

namespace Tests\File;

use Fyre\FileSystem\Exceptions\FileSystemException;
use Fyre\FileSystem\File;

trait ContentsTestTrait
{

    public function testContents(): void
    {
        $file = new File('tmp/test/test.txt', true);
        $file->open('w');
        $file->write('test');
        $file->close();

        $this->assertSame(
            'test',
            $file->contents()
        );
    }

    public function testContentsNotExists(): void
    {
        $this->expectException(FileSystemException::class);

        $file = new File('tmp/test/test.txt');
        $file->contents();
    }

}
