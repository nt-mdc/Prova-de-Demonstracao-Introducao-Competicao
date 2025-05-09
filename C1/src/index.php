<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Compactar Pasta</title>
</head>

<body>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['folder'])) {
        if (isset($_FILES['folder']['name'][0]) && isset($_FILES['folder']['full_path'][0])) {
            $folderName = explode('/', $_FILES['folder']['full_path'][0])[0];
        } else {
            echo "<p>O navegador ou servidor não está fornecendo o caminho completo (full_path).</p>";
        }

        $zip = new ZipArchive();
        $zipFileName = $folderName . '.zip';

        if ($zip->open($zipFileName, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== TRUE) {
            die("Não foi possível criar o arquivo ZIP.");
        }

        $arquivos = $_FILES['folder'];

        for ($i = 0; $i < count($arquivos['name']); $i++) {
            $tmpName = $arquivos['tmp_name'][$i];
            $fullPath = $arquivos['full_path'][$i];

            if (is_uploaded_file($tmpName)) {
                $zip->addFile($tmpName, $fullPath);
            }
        }

        $zip->close();

        header("Content-Disposition: attachment; filename=\"" . basename($zipFileName) . "\"");
        header("Content-Type: application/octet-stream");
        header("Content-Length: " . filesize($zipFileName));
        header("Connection: close");

        unlink($zipFileName);

        echo "<p>Arquivo ZIP criado com sucesso: <a href='$zipFileName' download>Baixar ZIP</a></p>";
    }
    ?>

    <form method="post" enctype="multipart/form-data">
        <h1>Folder Zip</h1>
        <input type="file" name="folder[]" webkitdirectory directory required><br><br>
        <input type="submit" value="Compactar">
    </form>

</body>

</html>