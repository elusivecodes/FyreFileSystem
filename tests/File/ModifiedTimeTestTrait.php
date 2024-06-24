<?php
declare(strict_types=1);

namespace Tests\File;

use Fyre\FileSystem\Exceptions\FileSystemException;
use Fyre\FileSystem\File;

use function time;

trait ModifiedTimeTestTrait
{
    public function testModifiedTime(): void
    {
        $time = time();

        $file = new File('tmp/test.txt', true);

        $file->touch($time);

        $this->assertSame(
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
