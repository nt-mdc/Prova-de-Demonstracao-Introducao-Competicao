// 🎯 Seleciona o canvas e o contexto de desenho 2D
const cnv = document.getElementById("canvas");
const ctx = cnv.getContext("2d");

// 🎯 Pega o input onde o usuário digita o número de iterações
let amount = document.getElementById("amount");


// 🔺 Desenha um triângulo usando 3 pontos (x, y)
// Cada ponto é um array com 2 valores: [x, y]
function drawTriangle(p1, p2, p3) {
    ctx.beginPath();              // Começa a forma
    ctx.moveTo(p1[0], p1[1]);     // Vai até o ponto 1
    ctx.lineTo(p2[0], p2[1]);     // Linha até o ponto 2
    ctx.lineTo(p3[0], p3[1]);     // Linha até o ponto 3
    ctx.closePath();              // Fecha o triângulo
    ctx.fill();                   // Preenche com a cor atual
}


// 🔁 Desenha o fractal do triângulo (Triângulo de Sierpinski)
// Se depth (profundidade) for 0, desenha um triângulo completo
// Senão, divide em 3 triângulos menores e repete
function fractal(p1, p2, p3, depth) {
    if (depth === 0) {
        drawTriangle(p1, p2, p3); // Caso base: desenha o triângulo
        return;
    }

    // 🧮 Calcula os pontos médios entre os lados
    const mid12 = [(p1[0] + p2[0]) / 2, (p1[1] + p2[1]) / 2];
    const mid23 = [(p2[0] + p3[0]) / 2, (p2[1] + p3[1]) / 2];
    const mid31 = [(p3[0] + p1[0]) / 2, (p3[1] + p1[1]) / 2];

    // 🔄 Chama recursivamente para os 3 triângulos menores
    fractal(p1, mid12, mid31, depth - 1);
    fractal(mid12, p2, mid23, depth - 1);
    fractal(mid31, mid23, p3, depth - 1);
}


// ▶️ Função chamada ao clicar no botão "Draw"
// Lê o número de iterações, limpa o canvas, define os pontos e desenha
function draw() {
    const interactions = parseInt(amount.value); // Lê o valor digitado
    ctx.clearRect(0, 0, cnv.width, cnv.height);  // Limpa o canvas anterior
    ctx.fillStyle = "#0000ff";                   // Define a cor do preenchimento

    // 📐 Calcula a altura de um triângulo equilátero com base = 500
    const height = Math.sqrt(3) / 2 * 500;

    // 🧭 Define os 3 pontos do triângulo principal (equilátero)
    const p1 = [50, 500];                  // Base esquerda
    const p2 = [550, 500];                 // Base direita
    const p3 = [300, 500 - height];        // Topo

    // 🔄 Começa o desenho do fractal
    fractal(p1, p2, p3, interactions);
}
