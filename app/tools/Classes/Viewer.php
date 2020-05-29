<?php
namespace Classes;

class Viewer
{
    protected $vars = [];

    protected $file;

    protected $page;

    function __construct($fn)
    {
      $this->file = DIR_FRONTEND.THEMENAME.'/'.$fn.".viewer.php";
    }
    public function __set($n,$v)
    {
      $this->vars[$n] = $v;
    }

    public function __get($n)
    {
      return $this->vars[$n];
    }

    public function __isset($n)
    {
      return isset($this->vars[$n]);
    }

    public function __unset($n)
    {
      unset($this->vars[$n]);
    }

    public function load($fn = null,array $v = null)
    {
      $fn = !empty($fn) ? DIR_FRONTEND.THEMENAME.'/'.$fn.".php" : $this->file;
      if(file_exists($fn) && is_file($fn)){

        $this->vars = empty($v) ? $this->vars : array_merge($this->vars,$v);

        extract($this->vars);
        $v = $this;

        ob_start();
        require_once($fn);
        $this->page = ob_get_clean();

        return $this;
      }else{
        if(DEBUG_MODE)
          die('page not found.');
      }
    }

    public function view()
    {
      echo $this->page;
      return $this;
    }

    public function import($fn,array $v = null)
    {
      $instace = $this;
      return $instace->load($fn,$v)->view();
    }

    public function asset($fn,$ft,array $attrs = [])
    {
      $furl = SITE_URL.ASSETS_URL.'/'.THEMENAME."/{$ft}/{$fn}.{$ft}";
      switch ($ft) {
        case 'css':
          echo "<link rel='stylesheet' href='{$furl}'";
          if(!empty($attrs)){
            foreach($attrs as $k =>$v){
              echo " {$k}='{$v}' ";
            }
          }
          echo "/>";
          break;

        case 'js':
          echo "<script type='text/javascript' src='{$furl}'";
          if(!empty($attrs)){
            foreach($attrs as $k =>$v){
              echo " {$k}='{$v}' ";
            }
          }
          echo "></script>";
          break;
        default:
          # code...
          break;
      }
    }

}
