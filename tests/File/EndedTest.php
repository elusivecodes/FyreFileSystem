<?php
declare(strict_types=1);

namespace Tests\File;

use
    Fyre\FileSystem\Exceptions\FileSystemException,
    Fyre\FileSystem\File;

trait EndedTest
{

    public function testEnded(): void
    {
        $file = new File('tmp/test/test.txt', true);
        $file->open('w+');
        $file->write('test');

        $this->assertEquals(
            false,
            $file->ended()
        );

        $file->read(1);

        $this->assertEquals(
            true,
            $file->ended()
        );
    }

    public function testEndedEmpty(): void
    {
        $file = new File('tmp/test/test.txt', true);
        $file->open('r');
        $file->read(1);

        $this->assertEquals(
            true,
            $file->ended()
        );
    }

    public function testEndedNoHandle(): void
    {
        $this->expectException(FileSystemException::class);

        $file = new File('tmp/test/test.txt', true);
        $file->ended();
    }

}
