# FyreFileSystem

**FyreFileSystem** is a free, open-source file/folder library for *PHP*.


## Table Of Contents
- [Installation](#installation)
- [Files](#files)
- [Folders](#folders)



## Installation

**Using Composer**

```
composer require fyre/filesystem
```

In PHP:

```php
use Fyre\FileSystem\File;
use Fyre\FileSystem\Folder;
```


## Files

- `$path` is a string representing the file path.
- `$create` is a boolean indicating whether to create the file if it doesn't exist, and will default to *false*.

```php
$file = new File($path, $create);
```

**Access Time**

Get the file access time.

```php
$accessTime = $file->accessTime();
```

**Base Name**

Get the filename.

```php
$baseName = $file->baseName();
```

**Chmod**

Change the file permissions.

- `$permissions` is a number representing the file permissions.

```php
$file->chmod($permissions);
```

**Close**

Close the file handle.

```php
$file->close();
```

**Contents**

Get the contents of the file.

```php
$contents = $file->contents();
```

**Copy**

Copy the file to a new destination.

- `$destination` is a string representing the destination path.
- `$overwrite` is a boolean indicating whether to overwrite an existing file, and will default to *true*.

```php
$file->copy($destination, $overwrite);
```

**Create**

Create the file.

```php
$file->create();
```

**Csv**

Parse CSV values from a file.

- `$length` is a number representing the maximum line length, and will default to *0*.
- `$separator` is a string representing the field separator, and will default to "*,*".
- `$enclosure` is a string representing the field enclosure character, and will default to "*"*".
- `$escape` is a string representing the escape character, and will default to "*\\*".

```php
$data = $file->csv($length, $separator, $enclosure, $escape);
```

**Delete**

Delete the file.

```php
$file->delete();
```

**Dir Name**

Get the directory name.

```php
$dirName = $file->dirName();
```

**Ended**

Determine if the pointer is at the end of the file.

```php
$ended = $file->ended();
```

**Exists**

Determine if the file exists.

```php
$exists = $file->exists();
```

**Extension**

Get the file extension.

```php
$extension = $file->extension();
```

**File Name**

Get the filename (without extension).

```php
$fileName = $file->fileName();
```

**Folder**

Get the *Folder*.

```php
$folder = $file->folder();
```

**Group**

Get the file group.

```php
$group = $file->group();
```

**Is Executable**

Determine if the file is executable.

```php
$isExecutable = $file->isExecutable();
```

**Is Readable**

Determine if the file is readable.

```php
$isReadable = $file->isReadable();
```

**Is Writable**

Determine if the file is writable.

```php
$isWritable = $file->isWritable();
```

**Lock**

Lock the file handle.

- `$operation` is a number representing the lock operation, and will default to *LOCK_SH*.

```php
$lock = $file->lock($operation);
```

**MIME Type**

Get the MIME content type.

```php
$mimeType = $file->mimeType();
```

**Modified Time**

Get the file modified time.

```php
$modifiedTime = $file->modifiedTime();
```

**Open**

Open a file handle.

- `$mode` is a string representing the access mode, and will default to "*r*".

```php
$open = $file->open($mode);
```

**Owner**

Get the file owner.

```php
$owner = $file->owner();
```

**Path**

Get the full path to the file.

```php
$path = $file->path();
```

**Permissions**

Get the file permissions.

```php
$permissions = $file->permissions();
```

**Read**

Read file data.

- `$length` is a number representing the number of bytes to read.

```php
$data = $file->read($length);
```

**Rewind**

Rewind the pointer position.

```php
$file->rewind();
```

**Seek**

Move the pointer position.

- `$offset` is a number representing the pointer position.

```php
$file->seek($offset);
```

**Size**

Get the size of the file (in bytes).

```php
$size = $file->size();
```

**Tell**

Get the current pointer position.

```php
$offset = $file->tell();
```

**Touch**

Touch the file.

- `$time` is a number representing the modified timestamp, and will default to `time()`.
- `$accessTime` is a number representing the access timestamp, and will default to `$time`.

```php
$file->touch($time, $accessTime);
```

**Truncate**

Truncate the file.

- `$size` is a number representing the size to truncate to, and will default to *0*.

```php
$file->truncate($size);
```

**Unlock**

Unlock the file handle.

```php
$file->unlock();
```

**Write**

Write data to the file.

- `$data` is a string representing the data to write.

```php
$file->write($data);
```


## Folders

- `$path` is a string representing the folder path.
- `$create` is a boolean indicating whether to create the folder if it doesn't exist, and will default to *false*.
- `$permissions` is a number representing the permissions to create the folder with, and will default to *0755*.

```php
$folder = new Folder($path, $create, $permissions);
```

**Contents**

Get the contents of the folder.

```php
$contents = $folder->contents();
```

This method will return an array containing the contents of the folder, as *File* and *Folder* objects.

**Copy**

Copy the folder to a new destination.

- `$destination` is a string representing the destination path.
- `$overwrite` is a boolean indicating whether to overwrite existing files, and will default to *true*.

```php
$folder->copy($destination, $overwrite);
```

**Create**

Create the folder.

- `$permissions` is a number representing the permissions to create the folder with, and will default to *0755*.

```php
$folder->create($permissions);
```

**Delete**

Delete the folder (including all contents).

```php
$folder->delete();
```

**Empty**

Empty the folder.

```php
$folder->empty();
```

**Exists**

Determine if the folder exists.

```php
$exists = $folder->exists();
```

**Is Empty**

Determine if the folder is empty.

```php
$isEmpty = $folder->isEmpty();
```

**Move**

Move the folder to a new destination.

- `$destination` is a string representing the destination path.
- `$overwrite` is a boolean indicating whether to overwrite existing files, and will default to *true*.

```php
$folder->move($destination, $overwrite);
```

**Name**

Get the folder name.

```php
$name = $folder->name();
```

**Path**

Get the full path to the folder.

```php
$path = $folder->path();
```

**Size**

Get the size of the folder (in bytes).

```php
$size = $folder->size();
```