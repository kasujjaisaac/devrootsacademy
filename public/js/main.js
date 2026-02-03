// =======================================
// DEVROOTS ACADEMY – INTERACTIVE JS (ULTRA-PREMIUM)
// =======================================
document.addEventListener("DOMContentLoaded", () => {

  // ------------------------------
  // UTILITY FUNCTIONS
  // ------------------------------
  const qs = (selector, parent = document) => parent.querySelector(selector);
  const qsa = (selector, parent = document) => parent.querySelectorAll(selector);

  // ------------------------------
  // HAMBURGER MENU (MOBILE)
  // ------------------------------
  const hamburger = qs(".hamburger");
  const navMenu = qs("nav ul");

  hamburger?.addEventListener("click", () => {
    navMenu?.classList.toggle("active");
    hamburger.classList.toggle("active");
  });

  // ------------------------------
  // BACK TO TOP BUTTON
  // ------------------------------
  const backToTop = qs("#back-to-top");

  if (backToTop) {
    const toggleBackToTop = () => backToTop.style.display = window.scrollY > 300 ? "block" : "none";
    window.addEventListener("scroll", toggleBackToTop);
    toggleBackToTop();

    backToTop.addEventListener("click", () => window.scrollTo({ top: 0, behavior: "smooth" }));
  }

  // ------------------------------
  // LIVE CHAT TOGGLE & BOT SIMULATION
  // ------------------------------
  const chatBtn = qs("#live-chat .chat-btn");
  const chatBox = qs("#live-chat .chat-box");
  const sendBtn = qs("#send-btn");
  const chatInput = qs("#chat-input");
  const chatMessages = qs("#chat-messages");

  if (chatBtn && chatBox && sendBtn && chatInput && chatMessages) {
    const addMessage = (text, isBot = false) => {
      const p = document.createElement("p");
      p.textContent = text;
      p.style.margin = "0.3rem 0";
      p.style.padding = isBot ? "0.4rem 0.6rem" : "0.5rem 0.8rem";
      p.style.borderRadius = "12px";
      p.style.background = isBot ? "#f9f9f9" : "#f1f1f1";
      p.style.fontStyle = isBot ? "italic" : "normal";
      p.style.textAlign = isBot ? "left" : "right";
      chatMessages.appendChild(p);
      chatMessages.scrollTop = chatMessages.scrollHeight;
    };

    const sendMessage = () => {
      const msg = chatInput.value.trim();
      if (!msg) return;
      addMessage(msg); // User message
      chatInput.value = "";
      setTimeout(() => addMessage("DevRoots: Thanks! We'll get back to you soon.", true), 800);
    };

    chatBtn.addEventListener("click", () => {
      chatBox.style.display = chatBox.style.display === "flex" ? "none" : "flex";
      chatBox.style.flexDirection = "column";
    });

    sendBtn.addEventListener("click", sendMessage);
    chatInput.addEventListener("keypress", e => { if (e.key === "Enter") sendMessage(); });
  }

  // ------------------------------
  // TESTIMONIALS CAROUSEL
  // ------------------------------
  const slides = qsa(".testimonial-slide");
  const prevBtn = qs(".testimonial-slider .prev");
  const nextBtn = qs(".testimonial-slider .next");
  const dots = qsa(".testimonial-slider .dot");
  let currentSlide = 0;
  let slideInterval;

  const showSlide = (index) => {
    slides.forEach((slide, i) => slide.classList.toggle("active", i === index));
    dots.forEach((dot, i) => dot.classList.toggle("active", i === index));
  };

  const nextSlide = () => {
    currentSlide = (currentSlide + 1) % slides.length;
    showSlide(currentSlide);
  };

  const prevSlide = () => {
    currentSlide = (currentSlide - 1 + slides.length) % slides.length;
    showSlide(currentSlide);
  };

  const startAutoSlide = () => slideInterval = setInterval(nextSlide, 5000);
  const stopAutoSlide = () => clearInterval(slideInterval);

  nextBtn?.addEventListener("click", () => { nextSlide(); stopAutoSlide(); startAutoSlide(); });
  prevBtn?.addEventListener("click", () => { prevSlide(); stopAutoSlide(); startAutoSlide(); });
  dots.forEach((dot, i) => dot.addEventListener("click", () => { currentSlide = i; showSlide(i); stopAutoSlide(); startAutoSlide(); }));

  if (slides.length) { showSlide(currentSlide); startAutoSlide(); }


  // ------------------------------
  // CONTACT FORM SUBMISSION
  // ------------------------------
const contactForm = document.getElementById("contactForm");

contactForm?.addEventListener("submit", (e) => {
e.preventDefault();
alert("Thank you! Your application has been submitted.");
contactForm.reset();
});


  // ------------------------------
  // SCROLL-TRIGGERED ANIMATIONS
  // ------------------------------
  const scrollElements = qsa(".hero-content, .courses, .about, .featured-courses, .testimonials, .contact");

  const handleScrollAnimation = () => {
    scrollElements.forEach(el => {
      const top = el.getBoundingClientRect().top;
      if (top <= window.innerHeight * 0.85) el.classList.add("scrolled");
    });
  };

  let ticking = false;
  window.addEventListener("scroll", () => {
    if (!ticking) {
      window.requestAnimationFrame(() => { handleScrollAnimation(); ticking = false; });
      ticking = true;
    }
  });

  handleScrollAnimation();
});
// =======================================
// Back-to-Top Button
const footerTopBtn = document.getElementById("footer-back-to-top");
footerTopBtn?.addEventListener("click", () => {
  window.scrollTo({ top: 0, behavior: "smooth" });
});

// Newsletter Form
const newsletterForm = document.getElementById("newsletterForm");
newsletterForm?.addEventListener("submit", (e) => {
  e.preventDefault();
  alert("Thank you for subscribing to our newsletter!");
  newsletterForm.reset();
});

// Pause slider on hover
const slider = document.querySelector('.slider-track');

slider.addEventListener('mouseenter', () => {
  slider.style.animationPlayState = 'paused';
});

slider.addEventListener('mouseleave', () => {
  slider.style.animationPlayState = 'running';
});
