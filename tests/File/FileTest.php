<?php
declare(strict_types=1);

namespace Tests\File;

use
    Fyre\FileSystem\File,
    Fyre\FileSystem\Folder,
    Fyre\Utility\Path,
    PHPUnit\Framework\TestCase;

final class FileTest extends TestCase
{

    use
        AccessTimeTest,
        ChmodTest,
        CloseTest,
        ContentsTest,
        CopyTest,
        CreateTest,
        CsvTest,
        DeleteTest,
        EndedTest,
        GroupTest,
        LockTest,
        MimeTypeTest,
        ModifiedTimeTest,
        OwnerTest,
        PermissionsTest,
        ReadTest,
        RewindTest,
        SeekTest,
        SizeTest,
        TruncateTest,
        WriteTest;

    public function testFile(): void
    {
        $file = new File('tmp/test.txt');

        $this->assertFalse(
            $file->exists()
        );
    }

    public function testCreateNew(): void
    {
        $file = new File('tmp/test.txt', true);

        $this->assertTrue(
            $file->exists()
        );
    }

    public function testCreateNewDeep(): void
    {
        $file = new File('tmp/test/test.txt', true);

        $this->assertTrue(
            $file->exists()
        );
    }

    public function testBaseName(): void
    {
        $file = new File('tmp/test/test.txt');

        $this->assertSame(
            'test.txt',
            $file->baseName()
        );
    }

    public function testDirName(): void
    {
        $file = new File('tmp/test/test.txt');

        $this->assertSame(
            Path::resolve('tmp/test'),
            $file->dirName()
        );
    }

    public function testExtension(): void
    {
        $file = new File('tmp/test/test.txt');

        $this->assertSame(
            'txt',
            $file->extension()
        );
    }

    public function testFileName(): void
    {
        $file = new File('tmp/test/test.txt');

        $this->assertSame(
            'test',
            $file->fileName()
        );
    }

    public function testFolder(): void
    {
        $file = new File('tmp/test/test.txt');

        $this->assertInstanceOf(
            Folder::class,
            $file->folder()
        );

        $this->assertSame(
            Path::resolve('tmp/test'),
            $file->folder()->path()
        );
    }

    public function testIsExecutable(): void
    {
        $file = new File('tmp/test/test.txt', true);

        $this->assertTrue(
            $file->isExecutable()
        );
    }

    public function testIsReadable(): void
    {
        $file = new File('tmp/test/test.txt', true);

        $this->assertTrue(
            $file->isReadable()
        );
    }

    public function testIsWritable(): void
    {
        $file = new File('tmp/test/test.txt', true);

        $this->assertTrue(
            $file->isWritable()
        );
    }

    public function testPath(): void
    {
        $file = new File('tmp/test/test.txt');

        $this->assertSame(
            Path::resolve('tmp/test/test.txt'),
            $file->path()
        );
    }

    public function testPathDots(): void
    {
        $file = new File('tmp/test/../test.txt');

        $this->assertSame(
            Path::resolve('tmp/test.txt'),
            $file->path()
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
