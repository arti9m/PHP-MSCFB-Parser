# PHP MSCFB Parser
Microsoft Compound Binary File PHP Parser: a pure PHP class for parsing MS compound files (version 3 only).

At least PHP 5.6 32-bit is required. Untested with PHP versions prior to 5.6.

Works best with PHP 7.x 64-bit (more than two times faster than 5.6 32-bit)!

[MS-CFB]: Compound File Binary File Format: 
https://docs.microsoft.com/en-us/openspecs/windows_protocols/MS-CFB/53989ce4-7b05-4f8d-829b-d08d6148375b

Some of the files related to Microsoft software are stored as a special file format called Compound File. This parser can be used to get information about streams and storages, and also to extract streams. Only Compound File version 3 is supported. Created for my XLS (Excel 95, 97-2003) parser to extract main Excel "Workbook" stream.

## Quick Start:
1. Download __MSCFB.php__ and put it to your PHP include directory, or to your script directory, or anywhere else.
2. Add the following line to the beginning of your PHP script (specify full path if needed):
```PHP
require_once "MSCFB.php";
```
3. Create instance of our class (open Compound File): 
```PHP
$file = new MSCFB("path_to_cfb_file.bin");
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
## Advanced
### Debug Mode
Debug mode enables output (echo) of all error and warning messages. To enable debug mode, set 2nd parameter to `true` in constructor:
```PHP
$file = new MSCFB("path_to_cfb_file.bin", true);
```
**Warning!** PHP function name in which error occured is displayed alongside the actual message. Do not enable debug mode in your production code since it may pose a security risk!
### Limit memory for temporary files
MSCFB may use temporary stream resource for storing some data (eg. miniStream) during its work. It is stored either in memory or as a temporary file, depending on data size. By default, data that exceeds 2MiB in size is stored in a temporary file.

You can control this threshold by specifying the size in bytes as the 3rd parameter to constructor:
```PHP
$file = new MSCFB("path_to_cfb_file.bin", false, 1024); //data with size > 1KiB is stored in a temp file
```
You can instruct PHP not to use a temporary file (thus always storing temporary data in memory) by setting the argument to zero:
```PHP
$file = new MSCFB("path_to_cfb_file.bin", false, 0); //temporary data always stored in memory
```

Notice: temporary files are automatically created and deleted by PHP.
