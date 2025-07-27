<?php
declare(strict_types=1);

namespace Tests\Folder;

use Fyre\FileSystem\Folder;
use Fyre\Utility\Path;
use Fyre\Utility\Traits\MacroTrait;
use PHPUnit\Framework\TestCase;

use function class_uses;

final class FolderTest extends TestCase
{
    use ContentsTestTrait;
    use CopyTestTrait;
    use CreateTestTrait;
    use DeleteTestTrait;
    use EmptyTestTrait;
    use IsEmptyTestTrait;
    use MoveTestTrait;
    use SizeTestTrait;

    public function testCreateNew(): void
    {
        $folder = new Folder('tmp/test', true);

        $this->assertTrue(
            $folder->exists()
        );
    }

    public function testFolder(): void
    {
        $folder = new Folder('tmp/test');

        $this->assertFalse(
            $folder->exists()
        );
    }

    public function testMacroable(): void
    {
        $this->assertContains(
            MacroTrait::class,
            class_uses(Folder::class)
        );
    }

    public function testName(): void
    {
        $folder = new Folder('tmp/test', true);

        $this->assertSame(
            'test',
            $folder->name()
        );
    }

    public function testPath(): void
    {
        $folder = new Folder('tmp/test', true);

        $this->assertSame(
            Path::resolve('tmp/test'),
            $folder->path()
        );
    }

    public function testPathDots(): void
    {
        $folder = new Folder('tmp/test/../test2', true);

        $this->assertSame(
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
