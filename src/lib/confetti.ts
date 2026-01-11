// Simple confetti animation utility
const confetti = () => {
  const colors = ['#d7036c', '#FF7F66', '#FFA5D8', '#10B981', '#FFD700'];
  const confettiCount = 100;

  for (let i = 0; i < confettiCount; i++) {
    const confettiElement = document.createElement('div');
    confettiElement.style.cssText = `
      position: fixed;
      width: 10px;
      height: 10px;
      background-color: ${colors[Math.floor(Math.random() * colors.length)]};
      left: ${Math.random() * 100}vw;
      top: -10px;
      border-radius: ${Math.random() > 0.5 ? '50%' : '0'};
      pointer-events: none;
      z-index: 9999;
      animation: confetti-fall ${2 + Math.random() * 3}s linear forwards;
    `;

    document.body.appendChild(confettiElement);

    // Remove after animation
    setTimeout(() => {
      confettiElement.remove();
    }, 5000);
  }

  // Add keyframes if not already added
  if (!document.getElementById('confetti-styles')) {
    const style = document.createElement('style');
    style.id = 'confetti-styles';
    style.textContent = `
      @keyframes confetti-fall {
        0% {
          transform: translateY(0) rotate(0deg);
          opacity: 1;
        }
        100% {
          transform: translateY(100vh) rotate(720deg);
          opacity: 0;
        }
      }
    `;
    document.head.appendChild(style);
  }
};

export default confetti;
