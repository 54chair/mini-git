<?php 
  require "init.php";

  $command = $argv[1];

  switch ($command) {
    case "init":
      init();
      break;
    default:
      echo "不明なコマンドです\n";
      break;
  }