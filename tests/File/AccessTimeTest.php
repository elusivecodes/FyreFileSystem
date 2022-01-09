<?php
declare(strict_types=1);

namespace Tests\File;

use
    Fyre\FileSystem\Exceptions\FileSystemException,
    Fyre\FileSystem\File;

use function
    time;

trait AccessTimeTest
{

    public function testAccessTime(): void
    {
        $time = time();

        $file = new File('tmp/test.txt', true);

        $file->touch($time, $time);

        $this->assertSame(
            $time,
            $file->accessTime()
        );
    }

    public function testAccessTimeNotExists(): void
    {
        $this->expectException(FileSystemException::class);

        $file = new File('tmp/test.txt');
        $file->accessTime();
    }

}
