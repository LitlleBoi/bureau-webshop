// Het BUREAU Webshop - JavaScript Interactiviteit

document.addEventListener('DOMContentLoaded', () => {
  // Mobile Nav Toggle
  const mobileToggle = document.getElementById('mobileToggle');
  const mainNav = document.getElementById('mainNav');

  if (mobileToggle && mainNav) {
    mobileToggle.addEventListener('click', () => {
      mainNav.classList.toggle('active');
    });
  }

  // Code input formatter: automatisch omzetten naar hoofdletters
  const codeInput = document.getElementById('codeInput');
  if (codeInput) {
    codeInput.addEventListener('input', (e) => {
      e.target.value = e.target.value.toUpperCase();
    });
  }

  // Product Detail Optie Selecties (Kleur & Maat)
  const colorOptions = document.querySelectorAll('.option-chip-color');
  const selectedColorInput = document.getElementById('selectedColor');

  if (colorOptions.length > 0 && selectedColorInput) {
    colorOptions.forEach(chip => {
      chip.addEventListener('click', () => {
        colorOptions.forEach(c => c.classList.remove('selected'));
        chip.classList.add('selected');
        selectedColorInput.value = chip.dataset.value;
      });
    });
  }

  const sizeOptions = document.querySelectorAll('.option-chip-size');
  const selectedSizeInput = document.getElementById('selectedSize');

  if (sizeOptions.length > 0 && selectedSizeInput) {
    sizeOptions.forEach(chip => {
      chip.addEventListener('click', () => {
        sizeOptions.forEach(c => c.classList.remove('selected'));
        chip.classList.add('selected');
        selectedSizeInput.value = chip.dataset.value;
      });
    });
  }
});
