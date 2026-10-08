// Menu mobile (abrir/fechar navegação)
const navToggle = document.getElementById('navToggle');
const nav = document.getElementById('nav');

if (navToggle && nav) {
  navToggle.addEventListener('click', () => {
    nav.classList.toggle('is-open');
  });
}

// Ano atual no rodapé
const yearEl = document.getElementById('year');
if (yearEl) {
  yearEl.textContent = new Date().getFullYear();
}

'use strict';

function closeMenu() {
  nav?.classList.remove('is-open');
  navToggle?.setAttribute('aria-expanded', 'false');
  navToggle?.setAttribute('aria-label', 'Abrir menu');
}

navToggle?.addEventListener('click', () => {
  const opened = nav?.classList.toggle('is-open') ?? false;
  navToggle.setAttribute('aria-expanded', String(opened));
  navToggle.setAttribute('aria-label', opened ? 'Fechar menu' : 'Abrir menu');
});
nav?.querySelectorAll('a').forEach(link => link.addEventListener('click', closeMenu));
document.addEventListener('keydown', event => {
  if (event.key === 'Escape' && nav?.classList.contains('is-open')) {
    closeMenu();
    navToggle?.focus();
  }
});
window.matchMedia('(min-width: 721px)').addEventListener('change', closeMenu);
const year = document.getElementById('year');
if (year) year.textContent = String(new Date().getFullYear());

const form = document.getElementById('registrationForm');
const status = document.getElementById('formStatus');
const birthdate = document.getElementById('birthdate');
const now = new Date();
const today = `${now.getFullYear()}-${String(now.getMonth() + 1).padStart(2, '0')}-${String(now.getDate()).padStart(2, '0')}`;
if (birthdate) birthdate.max = today;

function value(id) {
  return document.getElementById(id)?.value ?? '';
}

function errorFor(field) {
  const text = field.value.trim();
  if (!text) return 'Preencha este campo.';
  switch (field.id) {
    case 'name':
      return text.split(/\s+/).length < 2 || !/\p{L}/u.test(text)
        ? 'Informe seu nome e sobrenome.' : '';
    case 'email':
      return field.validity.typeMismatch ? 'Informe um e-mail válido.' : '';
    case 'phone': {
      const digits = text.replace(/\D/g, '');
      return !/^\+?[\d\s().-]+$/.test(text) || digits.length < 10 || digits.length > 15
        ? 'Informe um telefone válido, incluindo o DDD.' : '';
    }
    case 'birthdate': {
      const parsed = new Date(`${text}T12:00:00`);
      const parts = text.split('-').map(Number);
      return !/^\d{4}-\d{2}-\d{2}$/.test(text) || Number.isNaN(parsed.getTime()) ||
        parsed.getFullYear() !== parts[0] || parsed.getMonth() + 1 !== parts[1] ||
        parsed.getDate() !== parts[2] || parts[0] < 1 || text > today
        ? 'Informe uma data de nascimento válida, não futura.' : '';
    }
    case 'password':
      return field.value.length < 8 ? 'A senha deve ter pelo menos 8 caracteres.' : '';
    case 'password_confirmation':
      return field.value !== value('password') ? 'As senhas não coincidem.' : '';
    default:
      return '';
  }
}

function validate(field) {
  const message = errorFor(field);
  const output = document.getElementById(`${field.id}Error`);
  if (output) output.textContent = message;
  field.setAttribute('aria-invalid', String(Boolean(message)));
  return !message;
}

const fields = form ? Array.from(form.querySelectorAll('input, select')) : [];
fields.forEach(field => {
  field.addEventListener('blur', () => validate(field));
  field.addEventListener('input', () => {
    if (status) status.hidden = true;
    if (field.getAttribute('aria-invalid') === 'true') validate(field);
    if (field.id === 'password') {
      const confirmation = document.getElementById('password_confirmation');
      if (confirmation?.value) validate(confirmation);
    }
  });
  field.addEventListener('change', () => validate(field));
});

document.querySelectorAll('[data-toggle]').forEach(button => {
  button.addEventListener('click', () => {
    const input = document.getElementById(button.dataset.toggle);
    if (!input) return;
    const visible = input.type === 'password';
    input.type = visible ? 'text' : 'password';
    const subject = input.id === 'password' ? 'senha' : 'confirmação de senha';
    const label = `${visible ? 'Ocultar' : 'Mostrar'} ${subject}`;
    button.setAttribute('aria-label', label);
    button.setAttribute('title', label);
    button.setAttribute('aria-pressed', String(visible));
  });
});

form?.addEventListener('submit', event => {
  const invalid = fields.filter(field => !validate(field));
  if (!invalid.length) return; // tudo certo: envia pro Laravel
  event.preventDefault();
  if (status) {
    status.hidden = false;
    status.textContent = 'Confira os campos destacados antes de continuar.';
  }
  invalid[0].focus();
});
