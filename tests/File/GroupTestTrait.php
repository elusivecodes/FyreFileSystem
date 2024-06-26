<?php
declare(strict_types=1);

namespace Tests\File;

use Fyre\FileSystem\Exceptions\FileSystemException;
use Fyre\FileSystem\File;

use function filegroup;

trait GroupTestTrait
{
    public function testGroup(): void
    {
        $file = new File('tmp/test.txt', true);

        $this->assertSame(
            filegroup('tmp/test.txt'),
            $file->group()
        );
    }

    public function testGroupNotExists(): void
    {
        $this->expectException(FileSystemException::class);

        $file = new File('tmp/test.txt');
        $file->group();
    }
}
