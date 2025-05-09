<?php
// Define o tamanho do bloco (célula). Se não for informado, usa 50. Garante que seja no mínimo 1.
$cell = max(1, (int)($_GET['cell_size'] ?? 50));

// Caminho da imagem a ser processada (você pode trocar por um caminho dinâmico, se quiser)
$imgPath = 'your-image.jpg'; // ou 'your-image.png'

// Tenta carregar a imagem como JPEG; se falhar, tenta PNG
$src = @imagecreatefromjpeg($imgPath) ?: @imagecreatefrompng($imgPath);

// Se não conseguir carregar a imagem, exibe erro e para o script
if (!$src) die('Erro ao carregar imagem');

// Largura ($w) e altura ($h) da imagem original
$w = imagesx($src);
$h = imagesy($src);

// Cria uma nova imagem em branco com as mesmas dimensões
$out = imagecreatetruecolor($w, $h);

// Percorre a imagem em blocos de tamanho $cell x $cell
for ($y = 0; $y < $h; $y += $cell) {
    for ($x = 0; $x < $w; $x += $cell) {

        // Variáveis acumuladoras de cor: red ($r), green ($g), blue ($b), e contador de pixels ($n)
        $r = $g = $b = $n = 0;

        // Percorre os pixels dentro da célula atual
        for ($j = 0; $j < $cell && $y + $j < $h; $j++) {
            for ($i = 0; $i < $cell && $x + $i < $w; $i++) {

                // Captura a cor do pixel na posição (x+i, y+j)
                $rgb = imagecolorat($src, $x + $i, $y + $j);

                // Extrai os valores RGB do pixel e acumula
                $r += ($rgb >> 16) & 0xFF;
                $g += ($rgb >> 8) & 0xFF;
                $b += $rgb & 0xFF;
                $n++;
            }
        }

        // Calcula a média das cores da célula
        $avgColor = imagecolorallocate($out, $r / $n, $g / $n, $b / $n);

        // Desenha um retângulo preenchido na posição da célula com a cor média
        imagefilledrectangle(
            $out,
            $x, $y,
            min($x + $cell - 1, $w - 1),
            min($y + $cell - 1, $h - 1),
            $avgColor
        );
    }
}

// Define o tipo de resposta como imagem PNG
header('Content-Type: image/png');

// Gera e exibe a imagem resultante
imagepng($out);

// Libera a memória
imagedestroy($src);
imagedestroy($out);