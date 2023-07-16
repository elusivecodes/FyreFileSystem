<?php
declare(strict_types=1);

namespace Tests\File;

use Fyre\FileSystem\Exceptions\FileSystemException;
use Fyre\FileSystem\File;

trait CloseTestTrait
{

    public function testClose(): void
    {
        $this->expectException(FileSystemException::class);

        $file = new File('tmp/test/test.txt', true);
        $file->open('w');
        $file->close();
        $file->write('test');
    }

    public function testCloseNoHandle(): void
    {
        $this->expectException(FileSystemException::class);

        $file = new File('tmp/test/test.txt', true);
        $file->close();
    }

}
