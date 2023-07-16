<?php
declare(strict_types=1);

namespace Tests\Folder;

use Fyre\FileSystem\Exceptions\FileSystemException;
use Fyre\FileSystem\File;
use Fyre\FileSystem\Folder;
use Fyre\Utility\Path;

trait ContentsTestTrait
{

    public function testContents(): void
    {
        $folder = new Folder('tmp/test', true);

        $this->assertSame(
            [],
            $folder->contents()
        );
    }

    public function testContentsFolder(): void
    {
        $folder = new Folder('tmp/test', true);
        new Folder('tmp/test/deep', true);

        $contents = $folder->contents();

        $this->assertCount(
            1,
            $contents
        );

        $this->assertInstanceOf(
            Folder::class,
            $contents[0]
        );

        $this->assertSame(
            Path::resolve('tmp/test/deep'),
            $contents[0]->path()
        );
    }

    public function testContentsFile(): void
    {
        $folder = new Folder('tmp/test', true);
        $file = new File('tmp/test/test.txt', true);

        $contents = $folder->contents();

        $this->assertCount(
            1,
            $contents
        );

        $this->assertInstanceOf(
            File::class,
            $contents[0]
        );

        $this->assertSame(
            Path::resolve('tmp/test/test.txt'),
            $contents[0]->path()
        );
    }

    public function testContentsNotExists(): void
    {
        $this->expectException(FileSystemException::class);

        $folder = new Folder('tmp/test');
        $folder->contents();
    }

}
