<?php
declare(strict_types=1);

namespace Tests\File;

use Fyre\FileSystem\Exceptions\FileSystemException;
use Fyre\FileSystem\File;

trait CsvTestTrait
{

    public function testCsv(): void
    {
        $file = new File('tmp/test/test.txt', true);
        $file->open('w+');
        $file->write('1,2,3,4');
        $file->write("\n");
        $file->write('5,6,7,8');
        $file->rewind();

        $this->assertSame(
            ['1','2','3','4'],
            $file->csv()
        );

        $this->assertSame(
            ['5','6','7','8'],
            $file->csv()
        );
    }

    public function testCsvNoHandle(): void
    {
        $this->expectException(FileSystemException::class);

        $file = new File('tmp/test/test.txt', true);
        $file->csv(4);
    }

    public function testCsvInvalidHandle(): void
    {
        $this->expectException(FileSystemException::class);

        $file = new File('tmp/test/test.txt', true);
        $file->open('w');
        $file->csv();
    }

}
