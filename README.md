# PHP MSCFB Parser
Microsoft Compound Binary File PHP Parser: a PHP class for parsing MS compound files (version 3 only).

[MS-CFB]: Compound File Binary File Format: 
https://docs.microsoft.com/en-us/openspecs/windows_protocols/MS-CFB/53989ce4-7b05-4f8d-829b-d08d6148375b

Some of the files related to Microsoft software are stored as a special file format called Compound File. This parser can be used to get information about streams and storages, and also to extract streams. Only Compound File version 3 is supported. Created for my XLS (Excel 95, 97-2003) parser to extract main Excel stream.

See example.php for usage examples ("quick-start" and advanced).
