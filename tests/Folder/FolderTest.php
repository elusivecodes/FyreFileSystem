<?php
declare(strict_types=1);

namespace Tests\Folder;

use
    Fyre\FileSystem\File,
    Fyre\FileSystem\Folder,
    Fyre\Utility\Path,
    PHPUnit\Framework\TestCase;

final class FolderTest extends TestCase
{

    use
        ContentsTest,
        CopyTest,
        CreateTest,
        DeleteTest,
        EmptyTest,
        IsEmptyTest,
        MoveTest,
        SizeTest;

    public function testFolder(): void
    {
        $folder = new Folder('tmp/test');

        $this->assertEquals(
            false,
            $folder->exists()
        );
    }

    public function testCreateNew(): void
    {
        $folder = new Folder('tmp/test', true);

        $this->assertEquals(
            true,
            $folder->exists()
        );
    }

    public function testPath(): void
    {
        $folder = new Folder('tmp/test', true);

        $this->assertEquals(
            Path::resolve('tmp/test'),
            $folder->path()
        );
    }

    public function testPathDots(): void
    {
        $folder = new Folder('tmp/test/../test2', true);

        $this->assertEquals(
            Path::resolve('tmp/test2'),
            $folder->path()
        );
    }

    protected function setUp(): void
    {
        new Folder('tmp', true);
    }

    protected function tearDown(): void
    {
        $folder = new Folder('tmp');
        $folder->delete();
    }

}
