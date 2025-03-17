<?php 
  require "./command/init.php";
  require "./command/add.php";

  $command = $argv[1];

  switch ($command) {
    case "init":
      init();
      break;
    case "add":
      $filePath = $argv[2];
      add($filePath);
      break;
    default:
      echo "不明なコマンドです\n";
      break;
  }