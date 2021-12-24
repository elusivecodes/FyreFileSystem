<?php
declare(strict_types=1);

namespace Tests\File;

use
    Fyre\FileSystem\Exceptions\FileSystemException,
    Fyre\FileSystem\File;

use function
    time;

trait ModifiedTimeTest
{

    public function testModifiedTime(): void
    {
        $time = time();

        $file = new File('tmp/test.txt', true);

        $file->touch($time);

        $this->assertEquals(
            $time,
            $file->modifiedTime()
        );
    }

    public function testModifiedTimeNotExists(): void
    {
        $this->expectException(FileSystemException::class);

        $file = new File('tmp/test.txt');
        $file->modifiedTime();
    }

}
