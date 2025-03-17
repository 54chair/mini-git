<?php
  function add($filePath) {
    $blob = hashObject($filePath);
    updateIndex($filePath, $blob);
    echo "addコマンドが実行されました\n";
  }

  function hashObject($filePath) {
    $content = file_get_contents($filePath);
    $header = "blob " . strlen($content) . "\0";
    $blobObject = sha1($header . $content);
    $directory = substr($blobObject, 0, 2);
    $file = substr($blobObject, 2);
    if (!file_exists(".mini-git/objects/{$directory}/{$file}")) {
      mkdir(".mini-git/objects/{$directory}");
      file_put_contents(".mini-git/objects/{$directory}/{$file}", $blobObject);
    }
    return $blobObject;
  }

  function updateIndex($filePath, $blob) {
    if (!file_exists(".mini-git/index")) {
      touch(".mini-git/index");
    }

    $indexContent = file_get_contents(".mini-git/index");
    $fileMode = "100644";
    $indexLines = explode("\n", trim($indexContent));

    $existingIndexFilePath = array_map(function($line) {
      $entry = explode(" ", $line);
      return count($entry) >= 3 ? $entry[2] : "";
    }, $indexLines);

    if (in_array($filePath, $existingIndexFilePath)) {
      $newIndexLines = [];
      foreach ($indexLines as $line) {
        $entry = explode(" ", $line);
        if ($entry[2] === $filePath) {
          $newIndexLines[] = "$fileMode $blob $filePath";
        } else {
          $newIndexLines[] = $line;
        }
      }
      file_put_contents(".mini-git/index", implode("\n", $newIndexLines) . "\n");
    } else {
      file_put_contents(".mini-git/index", "$fileMode $blob $filePath\n", FILE_APPEND);
    }
  }