# PHP MSCFB Parser
Microsoft Compound Binary File PHP Parser: a pure PHP class for parsing MS compound files (version 3 only).

Some of the files related to Microsoft software are stored using a special file format called Compound File. This parser can be used to get information about streams and storages, and also to extract streams. Only Compound File version 3 is supported. Created for my [XLS (Excel 95, 97-2003) parser](https://github.com/arti9m/PHP-XLS-Excel-Parser) to extract main Excel "Workbook" stream.

## Table of Contents
1. [Requirements](#1-requirements)
2. [Basic usage](#2-basic-usage)
3. [More options](#3-more-options)
4. [How it works](#4-how-it-works)
5. [Public properties and methods](#5-public-properties-and-methods)
6. [Error handling](#6-error-handling)
7. [Security considerations](#7-security-considerations)
8. [Performance and memory](#8-performance-and-memory)
9. [More documentation](#9-more-documentation)

## 1. Requirements

At least PHP 5.6 32-bit is required. Untested with PHP versions prior to 5.6.

Works best with PHP 7.x 64-bit (more than two times faster than 5.6 32-bit)!

## 2. Basic usage
1. Download __MSCFB.php__ and put it to your PHP include directory, or to your script directory, or anywhere else.
2. Add the following line to the beginning of your PHP script (specify full path if needed):
```PHP
require_once 'MSCFB.php';
```
3. Create instance of our class (open Compound File): 
```PHP
$file = new MSCFB('path_to_cfb_file.bin');
```
4. (Optional) Print information about storages and streams (Directory Entries):
```PHP
var_dump($file->DE);
```
5. Get stream ID by name (`\001CompObj` provided as example. Since `\001` is a special unprintable character, use double quotes to expand the character to actual data: `"\001CompObj"`):
```PHP
$id = $file->get_by_name("\001CompObj");
```
6. Extract stream to variable:
```PHP
$stream = $file->extract_stream($id); //$stream now contains extracted stream binary data
```
7. Or extract stream to other file:
```PHP
$other_file = fopen('other_file.bin', 'wb');

$file->extract_stream($id, $other_file);

fclose($other_file); //other_file.bin now contains extracted stream binary data
```
8. (Optional) Free memory:
```PHP
$file->free();
unset($file);
```
## 3. More options

### Debug Mode

Debug mode enables output (echo) of all error and warning messages. To enable Debug mode, set the 2nd parameter to `true` in constructor:
```PHP
$file = new MSCFB("path_to_cfb_file.bin", true);
```
**Warning!** PHP function name in which error occured is displayed alongside the actual message. Do not enable Debug mode in your production code since it may pose a security risk!

### Temporary files and memory

MSCFB may need to use temporary PHP stream resource for storing some data (eg. miniStream) during its work. It is stored either in memory or as a temporary file, depending on data size. By default, data that exceeds 2MiB (PHP's default value) in size is stored as a temporary file.

You can control this threshold by specifying the size in bytes as the 3rd parameter to constructor:
```PHP
$file = new MSCFB("path_to_cfb_file.bin", false, 1024); //data with size > 1KiB is stored in a temp file
```
You can instruct PHP not to use a temporary file (thus always storing temporary data in memory) by setting the argument to zero:
```PHP
$file = new MSCFB("path_to_cfb_file.bin", false, 0); //temporary data always stored in memory
```
Set this parameter to `null` to use default value:
```PHP
$file = new MSCFB("path_to_cfb_file.bin", false, null); //default temp file settings
```

_Note:_ temporary files are automatically created and deleted by PHP.

## 4. How it works

1. File is opened for reading when MSCFB class is instantiated.
2. File header is parsed and checked for errors (eg. whether it is actually a Compound File).
3. First portion of DIFAT is read from header. (Please, refer to MS documentation linked above if you don't know what DIFAT, FAT and other terms mean).
4. If needed, the rest of DIFAT is read from file. At this point `$DIFAT` array property exists which represents DIFAT.
5. FAT is read using DIFAT information. FAT is stored in `$FAT` array property. When FAT is built, `$DIFAT` property is deleted (assigned to empty array) since it's not needed anymore.
6. Directory Entries are read and parsed using the information from header and FAT. At this point, `$DE` property (public) will be created and will have all necessary information about every Directory Entry in the file: name, siblings, size, starting sector, etc.
7. If necessary, miniStream (storage for streams less than 4096 bytes) will be created and saved into a temporary stream resource.
8. At this point, the user can extract any stream using `extract_stream($stream_id, $ext_file = null)` method. If `$ext_file` is provided and it is a PHP stream resource, the specified Directory Entry will be read into it, otherwise the data will be returned as a string. `$stream_id` is the key of `$DE` array property element, which corresponds to the Directroy Entry needed to be extracted. The user can obtain Directory Entry index by using `get_by_name($name)` method, where `$name` is Directory Entry name.

## 5. Public properties and methods

### Properties

__`(boolean) $debug`__ — whether or not to display error and warning messages;

__`(string) $err_msg`__ — a string that contains all error messages concatenated into one;

__`(string) $warn_msg`__ — same as above, but for warnings;

__`(array) $error`__ — array of error codes, empty if no errors occured;

__`(array) $warn`__ — array of warning codes, empty if no warnings occured;

__`(array) $DE`__ — array of Directory Entries. You should never modify it manually! It's provided as a public property only because of potential memory and speed concerns.

__`(string) $DE_enc`__ — encoding for mb_convert_encoding, which is automatically set to the return value of _mb_internal_encoding()_ in the constructor. It is used to convert Directory Entries names to active or default PHP encoding from UTF-16LE. Conversion is done using _mb_convert_encoding()_ function.

### Methods (functions)

__`constructor($filename, $debug = false, $mem = null)`__ — creates an instance of MSCFB class. `$filename` is path to your Compound File, `$debug` enables or disables [Debug mode](#debug-mode), `$mem` controls when a [temporary file is used instead of memory](#temporary-files-and-memory).

__`(int) get_by_name($name, $is16 = false)`__ — returns ID of Directory Entry that can be used for stream extracting, or `-1`, if specified Directory Entry is not found. `$name` is the Directory Entry name without null termination character. If `$is16` evaluates to `true`, `$name` must be a complete _UTF-16LE_ name of the Directory Entry without null termination character.

_Note:_ If you have a Directory Entry name like `\001CompObj`, where `\001` is the character with the binary value `0x01`, not the string literal `\001`, you should provide it in double quotes so `\001` is expanded to the correct value, like so:
```PHP
$index = $file->get_by_name("\001CompObj"); //$file is MSCFB instance
```

__`(mixed) extract_stream($stream_id, $ext_file = null)`__ — Extract Directory Entry (stream only!). `$stream_id` is a value returned by `get_by_name()` method or a valid stream index of `$DE` property. If `$ext_file` is set and is a valid PHP stream resource, the data will be extracted to it, otherwise the data will be returned as a string. Will return `false` on error, `true` if a stream has been successfully written to external stream, or a _string_ with data is returned if no external stream supplied.

## 6. Error handling

Each time an _error_ occures, the script places an error code into `$error` array property and appends an error message to `$err_msg` string property. If an error occures, it prevents execution of parts of the script that depend on successful execution of the part where the error occured. _Warnings_ work similarly to errors except they do not prevent execution of other parts of the script, since they always occur in non-critical places. Warnings use `$warn` property to store warning codes and `$warn_msg` property for warning texts.

If an error occurs in constructor and Debug mode is disabled, the user should check if `$error` property evaluates to `true` (for example, `if($file->error){ /*error processing here*/ }`, in which case error text can be read from `$err_msg` and the most recent error code can be obtained as the last element of `$error` array. Same applies to Warnings, which use `$warn_msg` and `$warn`, respectively.

_Note:_ `get_by_name()` method will return `-1` if the specified entry name is not found, but it will __not__ emit an error or a warning.

_Note:_ If an error occurs in `extract_stream()` method, it will return `false` and emit an error.

If Debug mode is enabled, all errors and warnings are printed (echoed) to standart output.

## 7. Security considerations

There are extensive error checks in every function that should prevent any potential problems no matter what file is supplied to the constructor. The only potential security risk can come from the Debug mode, which prints a function name in which an error or a warning has occured, but even then I do not see how such information can lead to problems with this particular class. It's pretty safe to say that this code can be safely run in (automated) production of any kind.

## 8. Performance and memory

The MSCFB class has been optimized for fast parsing and data extraction, while still performing error checks for safety. It is possible to marginally increase constructor performance by leaving those error checks out, but I would strongly advise against it, because if a specially crafted mallicious file is supplied, it becomes possible to cause a memory hog or an infinite loop.

Here are some numbers obtained on a Windows machine (AMD Phenom II x4 940), with a 97.0MiB test XLS file (96.2MiB stream extracted) using WAMP server:


| Time|   Memory|     Time |  Memory|Action|
|:-:|:-:|:-:|:-:|:-:|
 |0.52s|  27.6 MiB |  0.37s | 10.7 MiB | Open file and parse its structure
|26.66s| 128.6 MiB |  5.41s |113.4 MiB |Extract stream to string
| 8.48s|  27.6 MiB |  4.19s  |10.7 MiB | Extract stream to file
 | __5.6.25 32-bit__ |  __5.6.25 32-bit__ | __7.0.10 64-bit__ |  __7.0.10 64-bit__ | __PHP Version__


Notice that extracting stream to a temporary file is much faster than extracting to string in PHP 5.6, and is much more memory efficient overall.

## 9. More documentation

All the code in __MSCFB.php__ file is heavily commented, feel free to explore it! To understand how MS Compound File is structured, please refer to [MS documentation](https://docs.microsoft.com/en-us/openspecs/windows_protocols/MS-CFB/ "Open official Microsoft Compound Binary File Format documentation on Microsoft website"), or to [OpenOffice.org's Documentation of MS Compound File](https://www.openoffice.org/sc/compdocfileformat.pdf "Open OpenOffice.org's Documentation of Microsoft Compound Binary File Format (PDF)") (also provided as a PDF file in this repository).
