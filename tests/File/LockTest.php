<?php
declare(strict_types=1);

namespace Tests\File;

use
    Fyre\FileSystem\Exceptions\FileSystemException,
    Fyre\FileSystem\File;

trait LockTest
{

    public function testLock(): void
    {
        $file = new File('tmp/test.txt', true);
        $file->open('r');

        $this->assertEquals(
            $file,
            $file->lock()
        );
    }

    public function testUnlock(): void
    {
        $file = new File('tmp/test.txt', true);
        $file->open('r');

        $this->assertEquals(
            $file,
            $file->unlock()
        );
    }

    public function testLockNoHandle(): void
    {
        $this->expectException(FileSystemException::class);

        $file = new File('tmp/test.txt');
        $file->lock();
    }

    public function testUnlockNoHandle(): void
    {
        $this->expectException(FileSystemException::class);

        $file = new File('tmp/test.txt');
        $file->unlock();
    }

}
