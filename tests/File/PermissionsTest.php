<?php
declare(strict_types=1);

namespace Tests\File;

use
    Fyre\FileSystem\Exceptions\FileSystemException,
    Fyre\FileSystem\File;

use function
    decoct,
    fileperms;

trait PermissionsTest
{

    public function testPermissions(): void
    {
        $file = new File('tmp/test.txt', true);

        $perms = fileperms('tmp/test.txt');

        $this->assertEquals(
            decoct($perms & 0777),
            $file->permissions()
        );
    }

    public function testPermissionsNotExists(): void
    {
        $this->expectException(FileSystemException::class);

        $file = new File('tmp/test.txt');
        $file->permissions();
    }

}
