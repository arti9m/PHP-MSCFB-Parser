<?php
class MSCFB{

  // ERROR CODES
  const E_EOF = 0;
  const E_SEEK = 1;
  const E_TELL = 2; // not used
  const E_OPEN = 3;
  const E_CLOSE = 4;
  const E_PREV = 5; // not used
  const E_H_SIGN = 6;
  const E_H_CSLID = 7;
  const E_H_VMAJ = 8;
  const E_H_ORDER = 9;
  const E_H_SECSIZE = 10;
  const E_H_MINISIZE = 11;
  const E_H_RESERV = 12;
  const E_H_DIRSEC3 = 13;
  const E_H_FATCOUNT = 14;
  const E_H_DIRFIRST = 15;
  const E_H_CUTOFF = 16;
  const E_H_MFATCOUNT = 17;
  const E_H_DIFATFIRST = 18;
  const E_H_DIFATCOUNT = 19;
  const E_H_MFATFIRST = 20;
  const E_EXIST = 21;
  const E_SIZE = 22;
  const E_H_DIFATBOUNDS = 23;
  const E_DIFATBOUNDS = 24;
  const E_FATBOUNDS = 25;
  const E_FATEMPTY = 26;
  const E_DIFATEMPTY = 27;
  const E_DIRSECBOUNDS = 28; //not used due to FAT error handling
  const E_DIRCNTBOUNDS = 29;
  const E_DE_NOROOT = 30;
  const E_FATLOOP = 31;
  const E_DIFATLOOP = 32;
  const E_H_FAIL = 33;
  const E_FAT_FAIL = 34;
  const E_DE_FAIL = 35;
  const E_MINIFATOUB = 36;
  const E_MINIFATLOOP = 37;
  const E_TEMP = 38;
  const E_TWRITE = 39;
  const E_FATNOFOUND = 40;
  const E_MSTREAMREAD = 41;
  const E_MFATNOFOUND = 42;
  const E_NOMSTREAM = 43;
  const E_FATTOOMUCH = 44;
  const E_NOMINIFAT = 45;
  const E_MINIFATTOOMUCH = 46;
  const E_DE_SIZE = 47;
  const E_DE_SECT = 48;
  const E_DE_TYPE = 49;
  const E_H_DIFATLOOP = 50;
  const E_STREX_NOSUCH = 51;
  const E_STREX_NOTSTR = 52;
  const E_GENERAL = 53;

  // ERROR TEXTS
  private $E = array(
    self::E_EOF => 'Unexpected EOF or stream read error!',
    self::E_SEEK => 'Unable to set stream position!',
    self::E_TELL => 'Unable to get current stream position!',
    self::E_OPEN => 'Unable to open file (stream)!',
    self::E_CLOSE => 'Unable to close file (stream)!',
    self::E_PREV => 'Function exited because of previous error.',
    self::E_H_SIGN => 'Wrong header signature!',
    self::E_H_CSLID => 'Wrong Header CLSID value (must be zeroes)!',
    self::E_H_VMAJ => 'Major version may be 3 or 4, but version 4 is unsupported!',
    self::E_H_ORDER => 'Byte order must be little-endian (-2)!',
    self::E_H_SECSIZE => 'Sector size for v3 must be 2^9 (512) bytes!',
    self::E_H_MINISIZE => 'Mini-sector size must always be 2^6 (64) bytes!',
    self::E_H_RESERV => 'Header reserved value must be zeroes!',
    self::E_H_DIRSEC3 => 'Directory sector count for v3 file must be zero!',
    self::E_H_FATCOUNT => 'FAT sector count in header out of range!',
    self::E_H_DIRFIRST => 'First directory sector number in header out of range!',
    self::E_H_CUTOFF => 'Cutoff size for streams must be 4096 bytes!',
    self::E_H_MFATFIRST => 'First miniFAT sector number in header out of range!',
    self::E_H_MFATCOUNT => 'miniFAT sector count in header out of range!',
    self::E_H_DIFATFIRST => 'First external DIFAT sector out of range!',
    self::E_H_DIFATCOUNT => 'External DIFAT sector count in header out of range!',
    self::E_EXIST => 'File does not exist!',
    self::E_SIZE => 'File size must be at least 1.5 KiB and less or equal than 2GiB!',
    self::E_H_DIFATBOUNDS => 'DIFAT in header points to out-of-range sector number!',
    self::E_DIFATBOUNDS => 'DIFAT points to out-of-range sector number!',
    self::E_FATBOUNDS => 'FAT points to out-of-range sector number!',
    self::E_FATEMPTY => 'FAT is empty!',
    self::E_DIFATEMPTY => 'DIFAT is empty!',
    self::E_DIRSECBOUNDS => 'Sector number out of range while reading Directory Entries!',
    self::E_DIRCNTBOUNDS => 'Directory Entries count out of range!',
    self::E_DE_NOROOT => 'First Directory Entry is not Root Entry!',
    self::E_FATLOOP => 'FAT duplicate sector number found while building FAT table!',
    self::E_DIFATLOOP => 'DIFAT duplicate sector number found!',
    self::E_H_FAIL => 'Error while parsing header!',
    self::E_FAT_FAIL => 'FAT building failure!',
    self::E_DE_FAIL => 'Error while reading Directory Entries!',
    self::E_MINIFATOUB => 'MiniFAT sector number out of bounds!',
    self::E_MINIFATLOOP => 'Duplicate MiniFAT sector number found!',
    self::E_TEMP => 'Failed to create temporary file or stream!',
    self::E_TWRITE => 'Error writing to file or stream!',
    self::E_FATNOFOUND  => 'Error while reading  required next sector in FAT chain!',
    self::E_MSTREAMREAD => 'Failed to read miniStream from compound file!',
    self::E_MFATNOFOUND  => 'Error while reading next sector in mini-FAT chain!',
    self::E_NOMSTREAM => 'No miniStream exists when it is needed!',
    self::E_FATTOOMUCH => 'FAT sector count in header mismatches actual processed FAT sectors!',
    self::E_NOMINIFAT => 'miniFAT is empty when it is required!',
    self::E_MINIFATTOOMUCH => 'There are more miniFAT enties than specified in header!',
    self::E_DE_SIZE => 'Invalid Directory Entry size!',
    self::E_DE_SECT => 'Invalid Directory Entry sector number!',
    self::E_DE_TYPE => 'Unknown Directory Entry type!',
    self::E_H_DIFATLOOP => 'DIFAT duplicate sector number found in header!',
    self::E_STREX_NOSUCH => 'Invalid Directory Entry index!',
    self::E_STREX_NOTSTR => 'Selected Directory Entry is not a stream!',
    self::E_GENERAL => 'Unable to process compound file! See previous error.',
  );

  /* PROPERTIES */

  public $debug = false; // wether or not errors and warnings are echoed

  // file related
  private $filesize = 0;
  private $file = null; // file stream will be stored here as PHP stream resource

  // errors, warnings
  public $err_msg = ''; // error messages storage
  public $warn_msg = ''; // warning message storage
  public $error = array(); // active error codes container
  public $warn = array(); // active warning codes container

  // DIFAT
  private $DIFAT = array(); // storage for DIFAT
  private $DIFAT_first = -2; // -2 if no external DIFAT used, first external DIFAT sector otherwise
  private $DIFAT_count = 0; // count of external DIFAT sectors

  // Directory Entries
  public $DE = array(); // storage for Directory Entries
  private $DE_count = 0; // count of all Directory Enties
  private $DE_first = 0; // first Directory Entries sector

  // encoding for DE names decoding.
  // This is set to mb_internal_encoding in constructor.
  public $DE_enc = '';

  // mini-stream relayed
  private $MSTREAM = null; // mini-stream will be stored here as PHP stream resource
  private $MSTREAM_first = -2; // first sector of miniFAT container stream
  private $MSTREAM_size = 0; // byte size of miniFAT container stream

  private $miniFAT = array(); // miniFAT storage
  private $MFAT_first = -2; // first miniFAT sector (they describe mini-sectors in mini-stream)
  private $MFAT_count = 0; // count of miniFAT sectors

  // FAT
  private $FAT = array(); // FAT storage
  private $FAT_count = 0; // total number of FAT sectors

  // RAM/temp.file threshold , 2MB is default value.
  // Streams more than this value are stored in temp files.
  // set this to 0 to always store temporary streams in RAM
  private $tmp_ram_size = 2*1024*1024;

  // other
  private $unpack_str = ''; // helper for unpack_add()


  /* __________________ METHODS __________________ */


  /* General functions */

  // Generate error or warning message and set error or warning flag.
  // If Debug mode enabled, function name from which error originates is appended to error message
  private function gen_err($code, $func_name = 'general', $warn = false){
    $h = $warn ? 'WARNING: ' : 'ERROR: '; //heading for the message

    // if $code is integer, get error text using $code
    if(gettype($code)==='integer') $txt = $this->E[$code];
    else { // otherwise assume that $code is error text itself
      $txt = $code;
      $code = -1;
    }

    //if Debug mode enabled, create html formatted message
    if($this->debug){
      $html = '<br>'.$h.'<b>['.$func_name.']</b> '.$txt.'<br>';
      $txt = '['.$func_name.'] '.$txt;
    }

    $txt = preg_replace('/\s+/',' ', $txt); //replace all whitespaces with ' '
    if($this->debug) echo $html; //if Debug mode enabled, echo message

    if($warn){
      $this->warn_msg = $txt.' '.$this->err_msg; //append warning to warnings string
      $this->warn[] = $code; //add code to active codes list
    } else {
      $this->err_msg = $txt.' '.$this->err_msg; //append error to errors string
      $this->error[] = $code; //add code to active codes list
    }
    return $txt;
  }

  private function unpack_add($title,$action){ //helper for unpack2()
    $this->unpack_str .= $action.$title.'/';
    //example: unpack_add('id', 'V') --> 'Vid/'
  }

  private function unpack2($binary){ //more convenient wrapper for unpack()
    $ret = unpack($this->unpack_str, $binary); //unpack!
    $this->unpack_str = ''; //clear helper string
    return $ret; //return unpacked data
  }


  /* Get Stream entry by Name */

  // Get Directory Entry stream ID (index) by its name.
  // WARNING! Actual name may contain unprintable characters,
  // in which case, you should read documentation for your file format.
  // Example name: \001CompObj. Should be passed in double quotes: get_by_name("\001CompObj");
  // $name: Directory Entry name, should be in double quotes if contains special characters;
  // $name must NOT contain null-terminator.
  // $is16: if true, $name is UTF-16LE string WITHOUT null-terminator;
  // if $is16 is false, name is converted to UTF16-LE.
  // Returns index for $this->DE array.

  public function get_by_name($name, $is16 = false){
    if(!$is16) $name = mb_convert_encoding($name, 'UTF-16LE', mb_internal_encoding());
    foreach($this->DE as $index => $de){
      if($de['type']!==2) continue;
      if($de['name16']===$name) return $index;
    }
    return -1;
  }


  /* Stream reader */

  // Read regular stream from compound file.
  // $sectorN: first sector of stream;
  // $left: stream bytes left to read (stream byte length);
  // $stream - if specified, must be PHP stream resource, function will write to it instead
  // of outputting result as a string.
  // Returns string with stream data or 'true', if $stream is specified,
  // 'false' on error.

  private function read_stream($sectorN, $left, &$stream = null){
    if($this->error){
      $this->gen_err(self::E_GENERAL, __FUNCTION__);
      return false;
    }

    if($sectorN<0 || $sectorN > 0x3FFFFE){ // bounds check
      return false;
    }

    if($left<1 || $left > ($this->filesize - 512*3)){// bounds check
      return false;
    }

    if(!$stream) $ret = ''; // initialize return string if non-stream mode

    while($left>512){ // while we must read more than sector size

      $file_offset = ($sectorN+1) * 512; // generate file offset

      // seek to offset
      if(-1 === fseek($this->file, $file_offset)){
        $this->gen_err(self::E_SEEK, __FUNCTION__);
        return false;
      }

      // read sector
      $bin = fread($this->file, 512);
      if(false === $bin || strlen($bin)!==512){
        $this->gen_err(self::E_EOF, __FUNCTION__);
        return false;
      }

      $left -= 512; // keep track of how much did we read

      // if in stream mode, dump read data to stream
      if($stream){
        $written = fwrite($stream, $bin);
        if($written!==512){
          $this->gen_err(self::E_TWRITE, __FUNCTION__);
          return false;
        }
      } else { // else append data to return string
        $ret .= $bin;
      }

      // check if next sector exists in FAT
      if(!isset($this->FAT[$sectorN])){
        $this->gen_err(self::E_FATNOFOUND, __FUNCTION__);
        return false;
      }
      $sectorN = $this->FAT[$sectorN]; // get next sector number from FAT
    }

    // if at this point there are bytes left to read
    // everything here happens just as above
    if($left>0){

      $file_offset = ($sectorN+1) * 512;

      // seek to offset
      if(-1 === fseek($this->file, $file_offset)){
        $this->gen_err(self::E_SEEK, __FUNCTION__);
        return false;
      }

      $bin = fread($this->file, $left);
      if(false === $bin || strlen($bin)!==$left){
        $this->gen_err(self::E_EOF, __FUNCTION__);
        return false;
      }
      if($stream){
        $written = fwrite($stream, $bin);
        if($written!==$left){
          $this->gen_err(self::E_TWRITE, __FUNCTION__);
          return false;
        }
      } else {
        $ret .= $bin;
      }
    }

    if($stream) return true;
    else return $ret;
  }


  /* [4] Process Directory Entry (helper) */

  // parses binary data of single directory entry
  // returns Directory Entry array with data, false on error

  private function process_dir_entry($dir_bin){
    if($this->error){
      $this->gen_err(self::E_GENERAL, __FUNCTION__);
      return false;
    }
    $this->unpack_add('name','a64'); // name in UTF-16LE + NULL char (max 31 actual chars)
    $this->unpack_add('name_length','v'); // byte size of (name + null char), max = 64
    $this->unpack_add('type','c'); // 0(empty),1(storage),2(stream) or 5(root)
    $this->unpack_add('','x1'); // 8-bit number, node color, 0 (red) or 1 (black)
    $this->unpack_add('left','V'); // 32-bit int, left ID
    $this->unpack_add('right','V'); // 32-bit int, right ID
    $this->unpack_add('child','V'); // 32-bit int, child ID
    $this->unpack_add('','x16'); // CLSID, not used
    $this->unpack_add('','x4'); // state flags, not used
    $this->unpack_add('','x8'); // creation time, not used
    $this->unpack_add('','x8'); // midified time, not used
    $this->unpack_add('sector','V'); // starting sector (first minifat for root, zeroes for storage)
    $this->unpack_add('sizeL','V'); // size of stream LOW, actual stream size in bytes
    // unp_add($unp, 'sizeH','V'); // size of stream HIGH, should be zeroes for <2gb file, don't care
    $u = $this->unpack2($dir_bin);

    if($u['type']===0) return false; //type 0 means unknown or unallocated, skip it


    // name cannot be less than 2 bytes in length: null terminator (00 00) always present!
    // type must be 1 (storage), 2 (stream) or 5 (root entry)
    if($u['name_length']===0 || !in_array($u['type'],array(1,2,5),true)){
      $this->gen_err(self::E_DE_TYPE, __FUNCTION__, true);
      return false;
    }

    // convert values to 32-bit signed int
    if($u['sector']>0x7FFFFFFF) $u['sector'] -= 0x100000000;
    if($u['left']>0x7FFFFFFF) $u['left'] -= 0x100000000;
    if($u['right']>0x7FFFFFFF) $u['right'] -= 0x100000000;
    if($u['child']>0x7FFFFFFF) $u['child'] -= 0x100000000;

    // size bounds check, generate warning on failure
    if($u['sizeL'] < 0 || $u['sizeL'] > $this->filesize-512*3){
      $this->gen_err(self::E_DE_SIZE, __FUNCTION__, true);
      return false;
    }

    // 1st sector bounds check, generate warning on failure
    // -2 is acceptable if it's root entry (means there's no mini-stream in file)
    if(($u['sector'] < 0 && $u['sector'] !== -2) || $u['sector'] > 0x3FFFFE){
      $this->gen_err(self::E_DE_SECT, __FUNCTION__, true);
      return false;
    }

    $u['name16'] = substr($u['name'],0,$u['name_length']-2); // -2 for null haracter terminator
    $u['name'] = mb_convert_encoding($u['name16'], $this->DE_enc, 'UTF-16LE');

    return $u;
  }


  /* [3] Read Directory Entries */

  // Read Directory Entries! Also fill info for miniStream (from Root Entry).
  // Valid non-empty Directory Entries are added to $this->DE.
  // Returns 'false' on error, 'true' on success.
  private function read_DE(){
    if($this->error){
      $this->gen_err(self::E_GENERAL, __FUNCTION__);
      return false;
    }
    $sectorN = $this->DE_first; // sector number with first portion of DE

    $dir_index = 0; // helper for error checking, also index of current DE
    $this->DE_count = 0; // reset DE count
    $this->DE = array(); // initialize DE storage

    while(true){
      $file_offset = ($sectorN+1) * 512; //generate file offset

      //seek to sector position
      if(-1 === fseek($this->file, $file_offset)){
        $this->gen_err(self::E_SEEK, __FUNCTION__);
        return false;
      }

      //There are max 4 dir entries per sector (dir size is 128B, sector is 512B)
      for($i=0; $i<4; $i++){

        if($dir_index>0xFFFFF8){ //dir count out of bounds
          $this->gen_err(self::E_DIRCNTBOUNDS, __FUNCTION__);
          return false;
        }

        $dir_bin = fread($this->file, 128); //DIR SIZE is 128
        if(false === $dir_bin || strlen($dir_bin)!==128){
          $this->gen_err(self::E_EOF, __FUNCTION__);
          return false;
        }

        if($t = $this->process_dir_entry($dir_bin)){
          if($dir_index===0){ //this is the very first entry, must be Root!
            // If not Root Entry, file is not valid!
            if($t['type']!==5||$t['name']!=='Root Entry'){
              $this->gen_err(self::E_DE_NOROOT, __FUNCTION__);
              return false;
            }

            //fill miniStream info
            $this->MSTREAM_first = $t['sector'];
            $this->MSTREAM_size = $t['sizeL'];
          }
          $this->DE[$dir_index] = $t; // add current entry to $this->DE storage
          ++$dir_index;
          ++$this->DE_count; // Directory Entries counter
        }
      }

      //try to find next sector; if there's no next sector, we are done
      if(!isset($this->FAT[$sectorN])) break;

      $sectorN = $this->FAT[$sectorN]; //get next sector number from FAT
    }
    return true;
  }


  /* [1] Read headers and DIFAT */

  // Parse and check header, get info about file system, etc.
  // Returns 'false' on error, 'true' on success.
  private function read_header(){
    if($this->error){
      $this->gen_err(self::E_GENERAL, __FUNCTION__);
      return false;
    }
    // 1. Read and parse info from header
    $hdr_str = fread($this->file,512); //read first 512 bytes
    if(false===$hdr_str || strlen($hdr_str)!==512){
      $this->gen_err(self::E_EOF, __FUNCTION__);
      return false;
    }

    //SIGNATURE: must be D0 CF 11 E0 A1 B1 1A E1 (SIC)
    $this->unpack_add('signature','H16');

    //CLSID: must be zeroes
    $this->unpack_add('CLSID','H32');

    //MINOR_VER: SHOULD (not MUST) be 0x003e (62) if major is 0x0003 or 0x0004
    $this->unpack_add('minor_ver','v');

    //MAJOR_VER: must be 0x0003 or 0x0004
    $this->unpack_add('major_ver','v');

    //BYTE ORDER: must be 0xfffe (-2) (means 'little endian')
    $this->unpack_add('byte_order','v');

    //SECTOR SHIFT: must be 0x0009 (9)(ver3) or 0x000c (12)(ver4), 2^this = sector size
    $this->unpack_add('sector_shift','v');

    //MINI-SECTOR SHIFT: must be 0x0006. 2^this = mini stream sector size
    $this->unpack_add('mini_shift','v');

    //RESERVED, must be zeroes
    $this->unpack_add('reserved','H12');

    //DIRECTORY SECTOR COUNT: must be zero for v3
    $this->unpack_add('dir_count','V');

    //FAT SECTOR COUNT
    $this->unpack_add('FAT_count','V');

    //DIR_FIRST: starting sector number for directory stream
    $this->unpack_add('dir_first','V');

    //TRANSACTION: unused in XLS, don't care
    $this->unpack_add('','x4');

    //MINI-STREAM CUTOFF VALUE: cutoff value for mini streams, must be 0x00001000 (4096)
    $this->unpack_add('mini_cutoff','V');

    //first miniFAT sector number. If 0xFFFFFFFE, then no miniFAT
    $this->unpack_add('miniFAT_first','V');

    //minFAT sector count
    $this->unpack_add('miniFAT_count','V');

    //DIFAT first sector number, if 0xFFFFFFFE, then no external DIFAT
    $this->unpack_add('DIFAT_first','V');

    //DIFAT external sector count
    $this->unpack_add('DIFAT_count','V');

    $h = $this->unpack2($hdr_str);
    // $this->unpack_str = '';

    //convert numbers to 32-bit and 16-bit signed integers. Needed for 32/64 bit stuff.
    if($h['DIFAT_first']>0x7FFFFFFF) $h['DIFAT_first'] -= 0x100000000;
    if($h['miniFAT_first']>0x7FFFFFFF) $h['miniFAT_first'] -= 0x100000000;

    if($h['signature']!=='d0cf11e0a1b11ae1'){
      $this->gen_err(self::E_H_SIGN, __FUNCTION__);
      return false;
    }
    if($h['CLSID']!=='00000000000000000000000000000000'){
      $this->gen_err(self::E_H_CSLID, __FUNCTION__);
      return false;
    }
    if($h['major_ver']!==3){
      $this->gen_err(self::E_H_VMAJ, __FUNCTION__);
      return false;
    }
    if($h['byte_order']!==0xFFFE){
      $this->gen_err(self::E_H_ORDER, __FUNCTION__);
      return false;
    }
    if($h['sector_shift']!==9){
      $this->gen_err(self::E_H_SECSIZE, __FUNCTION__);
      return false;
    }
    if($h['mini_shift']!==6){
      $this->gen_err(self::E_H_MINISIZE, __FUNCTION__);
      return false;
    }
    if($h['reserved']!=='000000000000'){
      $this->gen_err(self::E_H_RESERV, __FUNCTION__);
      return false;
    }
    if($h['dir_count']!==0){
      $this->gen_err(self::E_H_DIRSEC3, __FUNCTION__);
      return false;
    }
    if($h['FAT_count']<1||$h['FAT_count']>0x003FFFFE){ //400000h -1(hdr) -1(dir)
      $this->gen_err(self::E_H_FATCOUNT, __FUNCTION__);
      return false;
    }
    //max sector number is 3ffffe (total addresable sectors count: 3fffff)
    if($h['dir_first']<0||$h['dir_first']>0x003FFFFE){
      $this->gen_err(self::E_H_DIRFIRST, __FUNCTION__);
      return false;
    }
    if($h['mini_cutoff']!==4096){
      $this->gen_err(self::E_H_CUTOFF, __FUNCTION__);
      return false;
    }
    if($h['miniFAT_first']>0x003FFFFE ||
      ($h['miniFAT_first']!==-2&&$h['miniFAT_first']<0)
    ){
      $this->gen_err(self::E_H_MFATFIRST, __FUNCTION__);
      return false;
    }
    if($h['miniFAT_count']<0||$h['miniFAT_count']>0x003FFFFD){ //400000-1hdr-1fat-1dir
      $this->gen_err(self::E_H_MFATCOUNT, __FUNCTION__);
      return false;
    }
    if($h['DIFAT_first']>0x003FFFFE ||
      ($h['DIFAT_first']!==-2&&$h['DIFAT_first']<0)
    ){
      $this->gen_err(self::E_H_DIFATFIRST, __FUNCTION__);
      return false;
    }
    if($h['DIFAT_count']<0 || $h['DIFAT_count']>0x003FFFFD){ //this is not very realistic... :)
      $this->gen_err(self::E_H_DIFATCOUNT, __FUNCTION__);
      return false;
    }

    // Fill info
    $this->DIFAT_first = $h['DIFAT_first'];
    $this->DIFAT_count = $h['DIFAT_count'];
    $this->MFAT_first = $h['miniFAT_first'];
    $this->MFAT_count = $h['miniFAT_count'];
    $this->DE_first = $h['dir_first'];
    $this->FAT_count = $h['FAT_count'];

    // 2. Read and parse DIFAT from header

    $this->DIFAT = array(); //initialize DIFAT storage

    //[76 ... 511] is first part of DIFAT
    //109 4-byte integers = 436 bytes of data
    $difat_hdr = unpack('x76/V109', $hdr_str);
    unset($hdr_str); //free up some memory

    $difats = array(); //helper for duplicate checking

    foreach($difat_hdr as $value){
      if($value > 0x7FFFFFFF) $value -= 0x100000000; //"convert" number to 32-bit signed
      if($value===-1) break; //-1 means no more DIFAT sectors

      //any sector location can be from 0 to 3FFFFE ("-1" is header)
      //because max file size is 2GB (last byte @ 0x7FFFFFFF)
      //and max 512-byte sector (excl. header) @ 0x3FFFFE
      if($value<0 || $value > 0x3FFFFE){
        $this->gen_err(self::E_H_DIFATBOUNDS, __FUNCTION__, true);
        break;
      }

      //if there's $value key in $difats, this value is duplicate, file is invalid!
      //this is MUCH faster than adding $value to some array and use in_array()
      if(isset($difats[$value])){
        $this->gen_err(self::E_H_DIFATLOOP, __FUNCTION__);
        return false;
      }

      $difats[$value] = false; //set our helper array['value'] to false, so isset() works
      $this->DIFAT[] = $value; //add FAT sector number to DIFAT storage
    }
    unset($difat_hdr); //free up some memory

    // 3. Read external DIFAT, if any

    if($this->DIFAT_count>0){
      $next_sectorN = $this->DIFAT_first; //set next sector to read

      for($i=0; true || $i<$this->DIFAT_count; $i++){ //loop

        //if next_sector = -2 or -1, then it is end-of-chain or empty
        //Theoretically, we shouldn't have this condition as we initially have
        //total count of DIFAT sectors and we use it as loop breaker.
        if($next_sectorN<0) break; //just in case

        $file_offset = ($next_sectorN+1) * 512; //next offset to read

        //seek to offset
        if(-1 === fseek($this->file, $file_offset)){
          $this->gen_err(self::E_SEEK, __FUNCTION__);
          return false;
        }

        //read sector
        $bin_part = fread($this->file, 512);
        if(false === $bin_part || strlen($bin_part)!==512){
          $this->gen_err(self::E_EOF, __FUNCTION__);
          return false;
        }

        $difat_portion = unpack('V128', $bin_part); //unpack DIFAT addresses from this sector

        foreach($difat_portion as $key => $value){ //process entries
          if($value > 0x7FFFFFFF) $value -= 0x100000000; //"convert" number to 32-bit signed

          if($value < -2 || $value > 0x3FFFFE){ //bounds check
            $this->gen_err(self::E_DIFATBOUNDS, __FUNCTION__, true);
            break 2;
          }

          if($key===128){ //if this is 128th entry then it is next DIFAT sector number
            $next_sectorN = $value;
            break;
          }


          // If value here <0 then either it is empty (-1) or end-of-chain (-2).
          // Since DIFAT is continuous, -1 is treated as end-of-chain, too.
          if($value<0) break 2;

          if(isset($difats[$value])){
            $this->gen_err(self::E_DIFATLOOP, __FUNCTION__);
            return false;
          }
          $difats[$value] = false;

          $this->DIFAT[] = $value; //add entry to DIFAT array
        }
      }
    }

    if(!$this->DIFAT){ //DIFAT must never be completely empty!
      $this->gen_err(self::E_DIFATEMPTY, __FUNCTION__);
      return false;
    }
    return true;
  }

  /* [2] Create FAT */

  // Create FAT table
  // Returns 'false' on error, 'true' on success.
  private function create_FAT(){
    if($this->error){
      $this->gen_err(self::E_GENERAL, __FUNCTION__);
      return false;
    }
    $this->FAT = array(); // initialize FAT storage
    $sect = 0; // sector number that is being processed

    $fats = array(); // for duplicate checking

    foreach($this->DIFAT as $sectorN){

      $file_offset = ($sectorN+1) * 512; // generate offset

      if(-1 === fseek($this->file, $file_offset)){ // seek to offset
        $this->gen_err(self::E_SEEK, __FUNCTION__);
        return false;
      }

      $bin = fread($this->file, 512); // read sector
      if(false === $bin || strlen($bin)!==512){
        $this->gen_err(self::E_EOF, __FUNCTION__);
        return false;
      }

      $FAT_part = unpack('V128', $bin); // unpack part of FAT

      foreach($FAT_part as $entry){
        if($entry > 0x7FFFFFFF) $entry -= 0x100000000; //"convert" number to 32-bit signed

        if($entry < -4 || $entry > 0x3FFFFE){ //-4: DIFAT, -3: FAT, -2: EndOfChain, -1: Free
          $this->gen_err(self::E_FATBOUNDS, __FUNCTION__);
          return false;
        }

        //we don't care about any special values
        if($entry<0){
          ++$sect; //just increment counter ($this->FAT key)
          continue;
        }

        // Duplicate checking. Duplicates means file is invalid!
        if(isset($fats[$entry])){
          $this->gen_err(self::E_FATLOOP, __FUNCTION__);
          return false;
        }

        $fats[$entry] = false; // set $fats[$entry] to something, so isset() works
        $this->FAT[$sect] = $entry; // add entry to FAT
        ++$sect; // increment counter
      }
    }

    // FAT must never be empty!
    if(!$this->FAT){
      $this->gen_err(self::E_FATEMPTY, __FUNCTION__);
      return false;
    }

    // Check if our FAT index corresponds to what is set in header
    // If not, generate a Warning.
    if($sect !== $this->FAT_count*128){
      $this->gen_err(self::E_FATTOOMUCH, __FUNCTION__, true);
    }
    return true;
  }

  /* [5] Create miniFAT and miniStream */

  // If miniStream is used, this function creates miniFAT and
  // extracts miniStream to temporary file/stream
  private function create_mini(){
    if($this->error){
      $this->gen_err(self::E_GENERAL, __FUNCTION__);
      return false;
    }
    //check if miniFAT and miniStream related values are correct
    if(!($this->MFAT_count>0 && $this->MFAT_first !== -2 &&
    $this->MSTREAM_size>0 && $this->MSTREAM_first !== -2)){
      return false;
    }

    $this->miniFAT = array(); //initialize miniFAT storage
    $sect = 0; //miniFAT sector number that is being processed

    $fats = array(); //for duplicate checking

    $sectorN = $this->MFAT_first; //first MFAT (miniFAT) sector we got from file header

    while(true){
      $file_offset = ($sectorN+1) * 512; //generate file offset

      //seek to sector position
      if(-1 === fseek($this->file, $file_offset)){
        $this->gen_err(self::E_SEEK, __FUNCTION__);
        return false;
      }

      //read sector
      $bin = fread($this->file, 512);
      if(false === $bin || strlen($bin)!==512){
        $this->gen_err(self::E_EOF, __FUNCTION__);
        return false;
      }

      $FAT_part = unpack('V128', $bin); //unpack miniFAT sector numbers

      foreach($FAT_part as $entry){
        if($entry > 0x7FFFFFFF) $entry -= 0x100000000; //"convert" number to 32-bit signed

        //check bounds
        if($entry < -2 || $entry > 0x1FFFFE8){ //3ffffe - 1(miniFAT) * 8(512/64=8)
          $this->gen_err(self::E_MINIFATOUB, __FUNCTION__, true);
          break 2; //exit from while loop
        }

        //we don't care about any special values
        if($entry<0){
          ++$sect;
          continue;
        }

        //check for duplicate
        if(isset($fats[$entry])){
          $this->gen_err(self::E_MINIFATLOOP, __FUNCTION__, true); //generate warning
          break 2; //and break from while loop
        }
        $fats[$entry] = false; //'add' value to values 'list'
        $this->miniFAT[$sect] = $entry; //add miniFAT entry
        ++$sect;
      }

      if(!isset($this->FAT[$sectorN])) break; //no more sectors in this chain, we finished
      $sectorN = $this->FAT[$sectorN]; //get next sector number from FAT
    }

    if(!$this->miniFAT){
      $this->gen_err(self::E_NOMINIFAT, __FUNCTION__, true); //generate warning
      return false;
    }

    if($sect !== $this->MFAT_count*128){ //actual entry number vs header info
      $this->gen_err(self::E_MINIFATTOOMUCH, __FUNCTION__, true);
    }


    
    $temp_str = 'php://temp'; //temp file address for fopen()
    if($this->tmp_ram_size !== null){ //if tmp size was manually set
      $size = (int) $this->tmp_ram_size;
      if($size>0) $temp_str .= '/maxmemory:'.$size; //tempfile size adjustment
      if($size===0) $temp_str = 'php://memory'; //always store data in memory
    }

    //create temporary stream
    if(false === ($this->MSTREAM = fopen($temp_str, 'w+b'))){
      $this->gen_err(self::E_TEMP, __FUNCTION__);
      return false;
    }

    //extract miniStream to temporary stream
    if(false === $this->read_stream($this->MSTREAM_first, $this->MSTREAM_size, $this->MSTREAM)){
      $this->gen_err(self::E_MSTREAMREAD, __FUNCTION__);
      return false;
    };
    return true;
  }



  /* Stream Entry extractor */

  // Extract Stream entry from compound file specified by index of $this->DE
  // Either extract to $stream or return as string
  public function extract_stream($i, $stream = null){
    if($this->error){
      $this->gen_err(self::E_GENERAL, __FUNCTION__);
      return false;
    }
    if(!isset($this->DE[$i])){
      $this->gen_err(self::E_STREX_NOSUCH, __FUNCTION__);
      return false;
    }
    if($this->DE[$i]['type']!==2){
      $this->gen_err(self::E_STREX_NOTSTR, __FUNCTION__);
      return false;
    }

    if(!$stream) $ret = '';

    $sectorN = $this->DE[$i]['sector'];
    $size = $this->DE[$i]['sizeL'];

    //if directory entry size is less than 4096, it's stored in the miniStream
    if($size<4096){
      if(!$this->MSTREAM){
        $this->gen_err(self::E_NOMSTREAM, __FUNCTION__);
        return false;
      }

      $left = $size;

      //if we must read more data than fits into a sector:
      while($left>64){ //miniSector = 64 bytes

        $file_offset = $sectorN * 64; //generate MSTREAM offset

        //seek to offset
        if(-1 === fseek($this->MSTREAM, $file_offset)){
          $this->gen_err(self::E_SEEK, __FUNCTION__);
          return false;
        }

        //read data
        $bin = fread($this->MSTREAM, 64);
        if(false === $bin || strlen($bin)!==64){
          $this->gen_err(self::E_EOF, __FUNCTION__);
          return false;
        }

        $left -= 64; //keep track of how much left to read


        if($stream){ //if stream is provided
          $written = fwrite($stream, $bin); //write to stream
          if($written!==64){
            $this->gen_err(self::E_TWRITE, __FUNCTION__);
            return false;
          }
        } else {
          $ret .= $bin; //if no stream provided, append data to return value
        }

        //try to get next sector
        if(!isset($this->miniFAT[$sectorN])){
          $this->gen_err(self::E_MFATNOFOUND, __FUNCTION__);
          return false;
        }
        $sectorN = $this->miniFAT[$sectorN]; //get next sector number from FAT
      }

      //if there's still data to read (always less or equal to 64 bytes)
      if($left>0){

        $file_offset = $sectorN * 64; //generate stream offset

        //same as above...
        if(-1 === fseek($this->MSTREAM, $file_offset)){
          $this->gen_err(self::E_SEEK, __FUNCTION__);
          return false;
        }

        $bin = fread($this->MSTREAM, $left);
        if(false === $bin || strlen($bin)!==$left){
          $this->gen_err(self::E_EOF, __FUNCTION__);
          return false;
        }

        if($stream){
          $written = fwrite($stream, $bin);
          if($written!==$left){
            $this->gen_err(self::E_TWRITE, __FUNCTION__);
            return false;
          }
        } else {
          $ret .= $bin;
        }
      }

      if($stream) return true;
      else return $ret;
    }

    // if we are at this point, stream size is >= 4096 and it's stored as regular stream
    return $this->read_stream($sectorN, $size, $stream);
  }

  /* Free memory */

  // Re-init all storages and close opened streams (if any)
  public function free(){
    $this->DIFAT = array();
    $this->FAT = array();
    $this->miniFAT = array();
    $this->DE = array();

    if($this->MSTREAM){
      if(gettype($this->MSTREAM)==='resource' && get_resource_type($this->MSTREAM)==='stream'){
        if(!fclose($this->MSTREAM)){
          $this->gen_err(self::E_CLOSE, __FUNCTION__, true);
        }
      }
      $this->MSTREAM = null;
    }

    if($this->file){
      if(gettype($this->file)==='resource' && get_resource_type($this->file)==='stream'){
        if(!fclose($this->file)){
          $this->gen_err(self::E_CLOSE, __FUNCTION__, true);
        }
      }
      $this->file = null;
    }
  }

  /* CONSTRUCTOR AND DESTRUCTOR */

  // Does some file-related error checking, reads file data and builds
  // neccessary structures (DIFAT, FAT, Directory Entries, miniStream)
  function __construct($filename, $debug = false, $mem = null){
    $this->debug = (bool) $debug;
    $this->tmp_ram_size = $mem;

    // Check if file exists
    if(!file_exists($filename)){
      $this->gen_err(self::E_EXIST, __FUNCTION__);
      return;
    }

    // Get file size and check for bounds
    $this->filesize = filesize($filename);
    if($this->filesize < 3*512 || $this->filesize > 0x7FFFFFFF){
      $this->gen_err(self::E_SIZE, __FUNCTION__);
      return;
    }

    // Try to open file and save resource pointer for later use
    if(!($this->file = fopen($filename, 'rb'))){
      $this->gen_err(self::E_OPEN, __FUNCTION__);
      return;
    }

    // Try to read header (get info, build DIFAT)
    if(!$this->read_header()) $this->gen_err(self::E_H_FAIL, __FUNCTION__);

    // If no errors, try to build FAT
    if(!$this->error){
      if(!$this->create_FAT()){
        $this->gen_err(self::E_FAT_FAIL, __FUNCTION__);
      }
    }

    unset($this->DIFAT); //since FAT is built, DIFAT is not needed anymore

    // If no errors, set encoding and try to read Directory Entries
    if(!$this->error){
      $this->DE_enc = mb_internal_encoding();
      if(!$this->read_DE()){
        $this->gen_err(self::E_DE_FAIL, __FUNCTION__);
      }
    }

    // In no errors, create miniFAT and miniStream, if neccessary
    if(!$this->error){
      $this->create_mini();
    }

    if($this->error){
      $this->gen_err(self::E_GENERAL, __FUNCTION__);
      return;
    }
  }

  // Not really neccessary as PHP automatically closes streams and deletes variables...
  // Only executes free()
  function __destruct(){
    $this->free();
  }
}
?>