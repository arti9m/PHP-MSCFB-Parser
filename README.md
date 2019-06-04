# PHP MSCFB Parser
Microsoft Compound Binary File PHP Parser: a PHP class for parsing MS compound files (version 3 only).

[MS-CFB]: Compound File Binary File Format: 
https://docs.microsoft.com/en-us/openspecs/windows_protocols/MS-CFB/53989ce4-7b05-4f8d-829b-d08d6148375b

Some of the files related to Microsoft software are stored as a special file format called Compound File. This parser can be used to get information about streams and storages, and also to extract streams. Only Compound File version 3 is supported. Created for my XLS (Excel 95, 97-2003) parser to extract main Excel "Workbook" stream.

Quick Start:
1. Download MSCFB.PHP and put it to your PHP include directory, to your script directory or anywhere else.
2. Add the following line to the beginning of your PHP script (specify full path if needed):

require_once "MSCFB.php";

3. Create instance of our class (open Compound File): 

$file = new MSCFB("path_to_cfb_file.bin");

4. (Optional) Print information about storages and streams (Directory Entries):

var_dump($file->DE);

5. Get stream ID by name:

$id = $file->get_by_name("\001CompObj");

6. Extract stream to variable:

$stream = $file->extract_stream($id); //$stream now contains extracted stream binary data

7. Or extract stream to other file:

$other_file = fopen('other_file.bin', 'wb');

$file->extract_stream($id, $other_file);

fclose($other_file); //other_file.bin now contains extracted stream binary data

8. (Optional) Free memory:

$file->free(); unset($file);


See example.php for more usage examples and information about how it all works.
