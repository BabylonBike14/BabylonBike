<?php

/**
 *
 */
class OwnEncrypt
{

  function __construct()
  {
    # code...
  }
  function Encrypt($str)
  {
    return crypt($str, '$6$rounds=5000$anexamplestringforsalt$');
  }
}



 ?>
