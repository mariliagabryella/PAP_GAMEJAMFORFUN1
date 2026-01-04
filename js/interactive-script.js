const canvas = document.getElementById("interactive-bg");
const ctx = canvas.getContext("2d");

let particles = [];
const colors = ["#BE3144", "#709AB9", "#FFFFFF", "#C0C0C0"]; // Vermelho, Azul, Branco, Prata
const maxParticles = 100;
const mouse = { x: null, y: null };

canvas.width = window.innerWidth;
canvas.height = window.innerHeight;

// Atualiza tamanho do canvas ao redimensionar a janela
window.addEventListener("resize", () => {
    canvas.width = window.innerWidth;
    canvas.height = window.innerHeight;
});

// Rato interativo
window.addEventListener("mousemove", (event) => {
    mouse.x = event.x;
    mouse.y = event.y;
    createParticle(mouse.x, mouse.y);
});

// Classe para partículas
class Particle {
    constructor(x, y, color) {
        this.x = x;
        this.y = y;
        this.size = Math.random() * 30 + 1; // Tamanho aleatório
        this.color = color;
        this.speedX = Math.random() * 3 - 1.5; // Movimento horizontal
        this.speedY = Math.random() * 3 - 1.5; // Movimento vertical
    }

    update() {
        this.x += this.speedX;
        this.y += this.speedY;
        this.size *= 0.95; // Partícula diminui com o tempo
    }

    draw() {
        ctx.fillStyle = this.color;
        ctx.beginPath();
        ctx.arc(this.x, this.y, this.size, 0, Math.PI * 2);
        ctx.fill();
    }
}

// Cria partículas
function createParticle(x, y) {
    if (particles.length < maxParticles) {
        const color = colors[Math.floor(Math.random() * colors.length)];
        particles.push(new Particle(x, y, color));
    }
}

// Atualiza partículas
function updateParticles() {
    particles.forEach((particle, index) => {
        particle.update();
        particle.draw();
        if (particle.size < 0.5) {
            particles.splice(index, 1); // Remove partículas pequenas
        }
    });
}

function animate() {
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    updateParticles();
    requestAnimationFrame(animate);
}

animate();
