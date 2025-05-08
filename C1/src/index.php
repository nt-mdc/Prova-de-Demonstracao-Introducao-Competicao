<?php

function zipFolder($sourceFolder, $zipFilePath) {

    if (!extension_loaded('zip') || !file_exists($sourceFolder)){
        return false;
    }

    $zip = new ZipArchive();

    if(!$zip->open($zipFilePath, ZipArchive::CREATE | ZipArchive::OVERWRITE)){
        return false;
    }

    $sourceFolder = realpath($sourceFolder);

    $files = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($sourceFolder),
        RecursiveIteratorIterator::LEAVES_ONLY
    );

    foreach ($files as $name => $file) {
        if (!$file->isDir()) {
            $filePath = $file->getRealPath();
            $relativePath = substr($filePath, strlen($sourceFolder) + 1);
            $zip->addFile($filePath, $relativePath);
        }
    }

    $zip->close();

    return true;
    
}

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pasta = $_POST['pasta'];
    $arqZip = $pasta.'.zip';

    if(zipFolder($pasta, $arqZip)) {
        echo "Pasta criada com sucesso! <a href='$arqZip'>Baixar Zip</a>";
    } else {
        echo "Falha ao compactar a pasta";
    }
}
?>

<form method="post">
    <label>Nome da Pasta para Compactar:</label><br>
    <input type="text" name="pasta" value="minha_pasta" required><br><br>
    <input type="submit" value="Compactar">
</form>