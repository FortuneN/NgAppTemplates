<?php
header("content-type:text/plain");
$root = realpath(".");
$ar = array_diff(scandir($root), array('.','..'));
foreach ($ar as $fold) {
	$rootPath = "{$root}/{$fold}";
	if (is_dir($rootPath)) {
		$zip = new ZipArchive();
		$zip->open("{$rootPath}.zip", ZipArchive::CREATE | ZipArchive::OVERWRITE);
		$files = new RecursiveIteratorIterator(
      new RecursiveDirectoryIterator($rootPath), RecursiveIteratorIterator::LEAVES_ONLY
		);
		foreach ($files as $name => $file) {
			if (!$file->isDir()) {
				$filePath = $file->getRealPath();
				$relativePath = substr($filePath, strlen($rootPath) + 1);
				$zip->addFile($filePath, $relativePath);
			}
		}
		$zip->close();
		echo "{$fold}.zip", PHP_EOL;
	}
}
echo "Done.";
