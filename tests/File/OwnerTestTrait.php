<?php
declare(strict_types=1);

namespace Tests\File;

use Fyre\FileSystem\Exceptions\FileSystemException;
use Fyre\FileSystem\File;

use function fileowner;

trait OwnerTestTrait
{

    public function testOwner(): void
    {
        $file = new File('tmp/test.txt', true);

        $this->assertSame(
            fileowner('tmp/test.txt'),
            $file->owner()
        );
    }

    public function testOwnerNotExists(): void
    {
        $this->expectException(FileSystemException::class);

        $file = new File('tmp/test.txt');
        $file->owner();
    }

}
