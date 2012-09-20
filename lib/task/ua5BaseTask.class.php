<?php

abstract class ua5BaseTask extends sfBaseTask {


  protected $pid_dir = null;
  protected $pid_max_count = 0;


  protected function pidAvailable() {
    return $this->pidGetCount() < $this->pid_max_count;
  }


  protected function pidCreate() {
    $pid = getmypid();
    $pid_file = $this->pidGetName($pid);
    file_put_contents($pid_file,$pid);
    return $pid;
  }


  protected function pidDelete($pid = null) {
    if ( null === $pid ) {
      $pid = getmypid();
    }
    $pid_file = $this->pidGetName($pid);
    unlink($pid_file);
  }


  protected function pidExists($pid) {
    $pid_file = $this->pidGetName($pid);
    if ( file_exists($pid_file) ) {
      //-- Pid file exists, check if it is still running

      $cur_pid = file_get_contents($pid_file);
      $cmd = sprintf('ps -ef');
      exec($cmd, $output);
      $output = preg_grep('/ grep /', $output, PREG_GREP_INVERT);
      $output = preg_grep(sprintf('/ *\b%s\b +\b%s\b/', getmyuid(), $cur_pid), $output);
      if ( 0 < count($output) ) { //-- we have a match!
        //-- A process was found
        return true;
      }
      //-- No Process found
      $this->pidDelete($pid);
    }
    return false;
  }


  protected function pidGetCount() {
    $count = 0;
    $pid_dir = $this->pidGetDir();
    $handle = opendir($pid_dir);
    if ( !$handle ) {
      throw new Exception("Unable to open pid_dir ($pid_dir).");
    } else {
      /* This is the correct way to loop over the directory. */
      while (false !== ($entry = readdir($handle))) {
        $file_path = $pid_dir . DIRECTORY_SEPARATOR . $entry;
        if ( is_file($file_path) ) {
          $pid = file_get_contents($file_path);
          if ( $this->pidExists($pid) ) {
            $count++;
          }
        }
      }
    }
    return $count;
  }


  protected function pidGetDir() {
    if ( is_null($this->pid_dir) ) {
      $this->pid_dir = sprintf( '%s/%s.pids', sys_get_temp_dir(), __CLASS__);
      if ( !file_exists($this->pid_dir) ) {
        //-- Make the dir
        if ( !mkdir($this->pid_dir, 0777, true) ) {
          throw new Exception("Unable to create pid_dir ({$this->pid_dir}).");
        }
      } else {
        if ( !is_dir($this->pid_dir) ) {
          //-- Make sure the path is a directory
          throw new Exception("pid_dir ({$this->pid_dir}) already exists, but is not a directory.");
        } else if ( !is_writable($this->pid_dir) ) {
          //-- and that it is writable
          throw new Exception("pid_dir ({$this->pid_dir}) is a directory, but not writable.");
        }
      }
    }
    return $this->pid_dir;
  }


  protected function pidGetName($pid) {
    $pid_file = sprintf('%s/%s.pid', $this->pidGetDir(), $pid);
    return $pid_file;
  }


}
