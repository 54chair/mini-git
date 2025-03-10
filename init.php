<?php 
  function init() {
    if (file_exists(".mini-git")) {
      echo "mini-gitリポジトリは既に存在しています\n";
      return;
    }

    mkdir(".mini-git");
    mkdir(".mini-git/objects");
    mkdir(".mini-git/refs");
    mkdir(".mini-git/refs/heads");
    file_put_contents(".mini-git/HEAD", "ref: refs/heads/master");

    echo "mini-gitリポジトリを初期化しました\n";
  }