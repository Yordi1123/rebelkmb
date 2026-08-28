import './bootstrap';
// Animación de burbujas del Homepage.
// El chequeo evita errores en cualquier otra vista que no tenga este elemento.
const bubblesContainer = document.getElementById('bubbles');

if (bubblesContainer) {
  const BUBBLE_COUNT = 22;

  for (let i = 0; i < BUBBLE_COUNT; i++) {
    const bubble = document.createElement('div');
    bubble.classList.add('bubble');

    const size = 4 + Math.random() * 14;
    bubble.style.width = `${size}px`;
    bubble.style.height = `${size}px`;
    bubble.style.left = `${Math.random() * 100}%`;
    bubble.style.animationDuration = `${8 + Math.random() * 10}s`;
    bubble.style.animationDelay = `${Math.random() * 12}s`;

    bubblesContainer.appendChild(bubble);
  }
}
