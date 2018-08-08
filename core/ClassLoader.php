<?php

class ClassLoader
{
  protected $dirs;

  public function register()
  {
    sql_autoload_register(array($this, 'localClass'));
  }

  public function registerDir($dir)
  {
    $this->dirs[] = $dir;
  }

  public function loadClass($class)
  {
    foreach ($this->dirs as $dir) {
      $file = $dir . '/' .$class . '.php';
      if (is_readdable($file)) {
        require $file;

        return;
      }
    }
  }
}
