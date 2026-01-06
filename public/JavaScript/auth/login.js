/**
 * ASOCIACIÓN 1RO DE JUNIO - SISTEMA LOGIN - JAVASCRIPT OPTIMIZADO
 * Solo las funciones esenciales usadas en login.php
 */

class AsociacionLogin {
    constructor() {
        this.form = null;
        this.inputs = {};
        this.isLoading = false;
        this.config = {
            minPasswordLength: 6,
            emailRegex: /.+@.+\..+/,
        };
        this.init();
    }

    // ===== INICIALIZACIÓN ===== //
    init() {
        document.addEventListener("DOMContentLoaded", () => {
            this.cacheElements();
            this.bindEvents();
        });
    }

    cacheElements() {
        this.form = document.getElementById("loginForm");
        this.inputs = {
            email: document.getElementById("email"),
            password: document.getElementById("password"),
        };
        this.button = document.getElementById("loginButton");
        this.buttonText = document.querySelector(".button-text");
        this.buttonLoader = document.querySelector(".button-loader");
    }

    bindEvents() {
        if (!this.form) return;

        // Evento del formulario
        this.form.addEventListener("submit", (e) => this.handleSubmit(e));

        // Validación básica en inputs
        Object.entries(this.inputs).forEach(([name, input]) => {
            if (input) {
                input.addEventListener("input", () => {
                    if (input.value.trim()) {
                        this.validateField(name);
                    } else {
                        this.setFieldState(input, false, "");
                    }
                });

                // Efectos focus
                input.addEventListener("focus", () => {
                    input.closest(".input-group").classList.add("focused");
                });

                input.addEventListener("blur", () => {
                    input.closest(".input-group").classList.remove("focused");
                });
            }
        });

        // Enlaces de social media del lado izquierdo
        document
            .querySelectorAll(".social-section .social-link")
            .forEach((link) => {
                link.addEventListener("click", (e) =>
                    this.handleSocialClick(e)
                );
            });

        // Enlaces de las secciones del formulario (lado derecho)
        document
            .querySelectorAll(".form-footer .social-link")
            .forEach((link) => {
                link.addEventListener("click", (e) =>
                    this.handleFormSocialClick(e)
                );
            });

        // Enlaces de registro
        const registerLinks = document.querySelectorAll(
            "#registerLink, #registerMainLink"
        );
        registerLinks.forEach((link) => {
            link.addEventListener("click", (e) => this.handleRegisterClick(e));
        });

        // Efectos adicionales para el branding
        this.initBrandingEffects();
    }

    // ===== VALIDACIÓN ===== //
    validateField(fieldName) {
        const input = this.inputs[fieldName];
        if (!input) return false;

        const value = input.value.trim();
        let isValid = false;
        let message = "";

        switch (fieldName) {
            case "email":
                isValid = this.config.emailRegex.test(value);
                message = isValid ? "" : "Ingresa un email válido";
                break;

            case "password":
                isValid = value.length >= this.config.minPasswordLength;
                message = isValid
                    ? ""
                    : `La contraseña debe tener al menos ${this.config.minPasswordLength} caracteres`;
                break;
        }

        this.setFieldState(input, isValid, message);
        return isValid;
    }

    setFieldState(input, isValid, message = "") {
        const inputGroup = input.closest(".input-group");
        const errorElement = inputGroup.querySelector(".input-error");

        // Actualizar clases
        input.classList.toggle("error", !isValid && message);

        // Mostrar/ocultar error
        if (errorElement) {
            errorElement.textContent = message;
            errorElement.classList.toggle("show", !isValid && message);
        }
    }

    // ===== SUBMIT DEL FORMULARIO ===== //
    async handleSubmit(e) {
        e.preventDefault();

        // Validar todos los campos
        const emailValid = this.validateField("email");
        const passwordValid = this.validateField("password");

        if (!emailValid || !passwordValid) {
            this.showMessage(
                "Por favor corrige los errores antes de continuar",
                "error"
            );
            return;
        }

        if (this.isLoading) return;

        this.isLoading = true;
        this.button.disabled = true;
        this.button.classList.add("loading");

        try {
            const formData = new FormData(this.form);
            const csrfToken = document
                .querySelector('meta[name="csrf-token"]')
                ?.getAttribute("content");

            const response = await fetch("/login", {
                method: "POST",
                headers: {
                    "X-Requested-With": "XMLHttpRequest",
                    Accept: "application/json",
                    "X-CSRF-TOKEN": csrfToken,
                },
                credentials: "same-origin", // Incluir cookies en la petición
                body: formData,
            });

            const result = await response.json();

            if (result.success) {
                this.showMessage("Login exitoso. Redirigiendo...", "success");
                setTimeout(() => {
                    window.location.href = result.redirect || "/dashboard";
                }, 1500);
            } else {
                this.showMessage(
                    result.message || "Error en el login",
                    "error"
                );
            }
        } catch (error) {
            console.error("Error:", error);
            this.showMessage("Error de conexión. Intenta de nuevo.", "error");
        } finally {
            this.isLoading = false;
            this.button.disabled = false;
            this.button.classList.remove("loading");
        }
    }

    // ===== MENSAJES ===== //
    showMessage(message, type = "info") {
        // Buscar contenedor existente o crear uno
        let messageContainer = document.querySelector(".message-container");
        if (!messageContainer) {
            messageContainer = document.createElement("div");
            messageContainer.className = "message-container";
            messageContainer.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 10000;
        max-width: 400px;
      `;
            document.body.appendChild(messageContainer);
        }

        const messageEl = document.createElement("div");
        messageEl.className = `message message-${type}`;

        const colors = {
            success: "#22c55e",
            error: "#ef4444",
            info: "#3b82f6",
        };

        messageEl.style.cssText = `
      background: ${colors[type] || colors.info};
      color: white;
      padding: 12px 20px;
      border-radius: 8px;
      margin-bottom: 10px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.3);
      transform: translateX(100%);
      transition: transform 0.3s ease;
      font-size: 14px;
      border-left: 4px solid rgba(255,255,255,0.3);
    `;

        messageEl.innerHTML = `
      <i class="fas fa-${
          type === "success" ? "check" : type === "error" ? "times" : "info"
      }-circle"></i>
      ${message}
    `;

        messageContainer.appendChild(messageEl);

        // Animar entrada
        setTimeout(() => {
            messageEl.style.transform = "translateX(0)";
        }, 100);

        // Auto remove
        setTimeout(() => {
            messageEl.style.transform = "translateX(100%)";
            setTimeout(() => {
                if (messageEl.parentNode) {
                    messageEl.parentNode.removeChild(messageEl);
                }
            }, 300);
        }, 4000);
    }

    // ===== ENLACES DE REDES SOCIALES (LADO IZQUIERDO) ===== //
    handleSocialClick(e) {
        e.preventDefault();
        const socialType = e.currentTarget.classList;

        if (socialType.contains("tiktok")) {
            this.showMessage("Abriendo TikTok de la Asociación...", "info");
            // window.open('https://tiktok.com/@asociacion1junio', '_blank');
        } else if (socialType.contains("facebook")) {
            this.showMessage("Abriendo Facebook de la Asociación...", "info");
            // window.open('https://facebook.com/asociacion1junio', '_blank');
        } else if (socialType.contains("instagram")) {
            this.showMessage("Abriendo Instagram de la Asociación...", "info");
            // window.open('https://instagram.com/asociacion1junio', '_blank');
        } else if (socialType.contains("whatsapp")) {
            this.showMessage("Abriendo WhatsApp de la Asociación...", "info");
            // window.open('https://wa.me/1234567890', '_blank');
        }
    }

    // ===== ENLACES DE FUNCIONES (LADO DERECHO) ===== //
    handleFormSocialClick(e) {
        e.preventDefault();
        const linkText = e.currentTarget.querySelector("span").textContent;

        switch (linkText) {
            case "Gestión":
                this.showMessage(
                    "Redirigiendo a Gestión de Conductores...",
                    "info"
                );
                break;
            case "Servicios":
                this.showMessage(
                    "Accediendo a Servicios de Mototaxi...",
                    "info"
                );
                break;
            case "Asociación":
                this.showMessage("Conectando con la Asociación...", "info");
                break;
            case "Soporte":
                this.showMessage("Abriendo canal de soporte...", "info");
                break;
        }
    }

    handleRegisterClick(e) {
        // Permitir que el enlace funcione normalmente (eliminamos preventDefault)
        this.showMessage(
            "Redirigiendo al registro de la Asociación...",
            "info"
        );
        // El enlace redirigirá automáticamente a route('register.show')
    }

    // ===== EFECTOS DEL BRANDING ===== //
    initBrandingEffects() {
        // Efecto parallax sutil en el logo
        const logo = document.querySelector(".brand-logo");
        if (logo) {
            document.addEventListener("mousemove", (e) => {
                const { clientX, clientY } = e;
                const { innerWidth, innerHeight } = window;

                const xPos = (clientX / innerWidth - 0.5) * 10;
                const yPos = (clientY / innerHeight - 0.5) * 10;

                logo.style.transform = `translate(${xPos}px, ${yPos}px)`;
            });
        }

        // Animación adicional en hover para enlaces sociales
        document
            .querySelectorAll(".social-section .social-link")
            .forEach((link) => {
                link.addEventListener("mouseenter", () => {
                    link.style.transform = "translateY(-3px) scale(1.05)";
                });

                link.addEventListener("mouseleave", () => {
                    link.style.transform = "translateY(0) scale(1)";
                });
            });
    }
}

// ===== INICIALIZAR ===== //
const asociacionLogin = new AsociacionLogin();
