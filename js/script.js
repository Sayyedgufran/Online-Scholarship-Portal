// Preloader functionality
window.addEventListener('load', function () {
  const preloader = document.getElementById('preloader');
  if (!preloader) return;

  // Ensure minimum 2 seconds display of preloader
  const minTime = 2000; // milliseconds
  const startTime = performance.now();

  function hidePreloader() {
    preloader.classList.add('preloader-hidden');

    setTimeout(() => {
      if (preloader && preloader.parentNode) {
        preloader.parentNode.removeChild(preloader);
        document.body.classList.remove('preloader-lock');
      }
    }, 500);
  }

  const elapsed = performance.now() - startTime;
  if (elapsed >= minTime) {
    hidePreloader();
  } else {
    setTimeout(hidePreloader, minTime - elapsed);
  }
});

// Fallback: hide preloader after 6s even if load fails
setTimeout(() => {
  const preloader = document.getElementById('preloader');
  if (preloader && !preloader.classList.contains('preloader-hidden')) {
    preloader.classList.add('preloader-hidden');
    setTimeout(() => {
      if (preloader && preloader.parentNode) {
        preloader.parentNode.removeChild(preloader);
        document.body.classList.remove('preloader-lock');
      }
    }, 500);
  }
}, 6000);

// Form validation for registration
document.addEventListener('DOMContentLoaded', function() {
  const registerForm = document.querySelector('form[action*="register_process"]');
  if (registerForm) {
    registerForm.addEventListener('submit', function(e) {
      const password = document.getElementById('password');
      const confirmPassword = document.getElementById('confirm_password');
      
      if (password.value !== confirmPassword.value) {
        e.preventDefault();
        alert('Passwords do not match!');
        confirmPassword.focus();
      }
      
      if (password.value.length < 6) {
        e.preventDefault();
        alert('Password must be at least 6 characters long!');
        password.focus();
      }
    });
  }

  // Password strength indicator
  const passwordInput = document.getElementById('password');
  if (passwordInput) {
    passwordInput.addEventListener('input', function() {
      const strengthIndicator = document.getElementById('password-strength') || createStrengthIndicator();
      const strength = checkPasswordStrength(this.value);
      updateStrengthIndicator(strengthIndicator, strength);
    });
  }

  // Auto-set minimum date for scholarship deadline
  const deadlineInput = document.getElementById('deadline');
  if (deadlineInput) {
    const today = new Date().toISOString().split('T')[0];
    deadlineInput.min = today;
  }

  // Add active class to current page in navbar
  const currentPage = window.location.pathname.split('/').pop();
  const navLinks = document.querySelectorAll('.nav-link');
  navLinks.forEach(link => {
    if (link.getAttribute('href') === currentPage) {
      link.classList.add('active');
    }
  });
});

// Password strength checker
function checkPasswordStrength(password) {
  let strength = 0;
  
  if (password.length >= 6) strength++;
  if (password.match(/[a-z]/) && password.match(/[A-Z]/)) strength++;
  if (password.match(/\d/)) strength++;
  if (password.match(/[^a-zA-Z\d]/)) strength++;
  
  return strength;
}

// Create password strength indicator
function createStrengthIndicator() {
  const passwordGroup = document.querySelector('#password').closest('.mb-3');
  const indicator = document.createElement('div');
  indicator.id = 'password-strength';
  indicator.className = 'password-strength mt-2';
  indicator.innerHTML = `
    <div class="strength-bars d-flex gap-1">
      <div class="strength-bar flex-fill" style="height: 4px; background-color: #e9ecef;"></div>
      <div class="strength-bar flex-fill" style="height: 4px; background-color: #e9ecef;"></div>
      <div class="strength-bar flex-fill" style="height: 4px; background-color: #e9ecef;"></div>
      <div class="strength-bar flex-fill" style="height: 4px; background-color: #e9ecef;"></div>
    </div>
    <small class="strength-text text-muted"></small>
  `;
  passwordGroup.appendChild(indicator);
  return indicator;
}

// Update password strength indicator
function updateStrengthIndicator(indicator, strength) {
  const bars = indicator.querySelectorAll('.strength-bar');
  const text = indicator.querySelector('.strength-text');
  
  // Reset all bars
  bars.forEach(bar => bar.style.backgroundColor = '#e9ecef');
  
  // Set colors based on strength
  const colors = ['#dc3545', '#ffc107', '#17a2b8', '#28a745'];
  const messages = ['Very Weak', 'Weak', 'Medium', 'Strong'];
  
  for (let i = 0; i < strength; i++) {
    if (bars[i]) {
      bars[i].style.backgroundColor = colors[strength - 1];
    }
  }
  
  if (text) {
    text.textContent = strength > 0 ? `Password Strength: ${messages[strength - 1]}` : '';
    text.style.color = colors[strength - 1] || '#6c757d';
  }
}

// Smooth scrolling for anchor links
document.addEventListener('DOMContentLoaded', function() {
  const anchorLinks = document.querySelectorAll('a[href^="#"]');
  anchorLinks.forEach(link => {
    link.addEventListener('click', function(e) {
      e.preventDefault();
      const target = document.querySelector(this.getAttribute('href'));
      if (target) {
        target.scrollIntoView({
          behavior: 'smooth',
          block: 'start'
        });
      }
    });
  });
});

// ANNOUNCEMENT AUTO-HIDE CODE REMOVED - Announcement will stay visible always

// Export functions for global use
window.ScholarshipPortal = {
  checkPasswordStrength,
  updateStrengthIndicator
};

