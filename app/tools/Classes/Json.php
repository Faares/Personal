<?php

namespace Classes;

class Json
{

  protected $fp;

  function __construct($fn)
  {
    $this->fp = DIR_DATABASE.$fn.'.database.json';
  }

  public function load($arr =false)
  {
    if(file_exists($this->fp) && is_file($this->fp))
    {
      $x = $arr ? json_decode(file_get_contents($this->fp),true) : json_decode(file_get_contents($this->fp));
      return json_last_error() == 0 ? $x : die(json_last_error_msg()." in: ".$this->fp);
    }
    return DEBUG_MODE ? die('Cant found '.$this->fp) : false;
  }

}
