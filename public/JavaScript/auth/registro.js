/**
 * ASOCIACIÓN 1RO DE JUNIO - SISTEMA REGISTRO - JAVASCRIPT OPTIMIZADO
 * Funciones específicas para el registro de usuarios
 */

class AsociacionRegistration {
    constructor() {
        this.form = null;
        this.inputs = {};
        this.isLoading = false;
        this.currentStep = "register";
        this.config = {
            minPasswordLength: 8,
            emailRegex: /^[^\s@]+@[^\s@]+\.[^\s@]+$/,
            codeLength: 6,
            phoneRegex: /^[\+]?[0-9\s\-\(\)]{10,}$/,
            passwordRequirements: {
                minLength: 8,
                uppercase: /[A-Z]/,
                lowercase: /[a-z]/,
                number: /[0-9]/,
                special: /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\?]/,
            },
        };
        this.init();
    }

    // ===== INICIALIZACIÓN ===== //
    init() {
        document.addEventListener("DOMContentLoaded", () => {
            this.cacheElements();
            this.bindEvents();
            this.detectCurrentStep();
        });
    }

    cacheElements() {
        this.form = document.getElementById("registerForm");
        this.inputs = {
            name: document.getElementById("name"),
            apellido: document.getElementById("apellido"),
            email: document.getElementById("email"),
            telefono: document.getElementById("telefono"),
            ci: document.getElementById("ci"),
            password: document.getElementById("password"),
            confirm_password: document.getElementById("confirm_password"),
            code: document.getElementById("code"),
            acepta_terminos: document.getElementById("acepta_terminos"),
            acepta_marketing: document.getElementById("acepta_marketing"),
        };
        this.button = document.getElementById("registerButton");
        this.buttonText = document.querySelector(".button-text");
        this.buttonLoader = document.querySelector(".button-loader");
    }

    detectCurrentStep() {
        // Detectar el paso actual desde el formulario
        const stepInput = document.querySelector('input[name="step"]');
        if (stepInput) {
            this.currentStep = stepInput.value;
        }

        // Configurar según el paso
        this.configureStepFeatures();
    }

    configureStepFeatures() {
        switch (this.currentStep) {
            case "register":
                this.focusFirstInput();
                this.setupFormValidation();
                break;
            case "verify":
                this.setupCodeInput();
                break;
        }
    }

    bindEvents() {
        if (!this.form) return;

        // Evento del formulario
        this.form.addEventListener("submit", (e) => this.handleSubmit(e));

        // Validación en tiempo real para inputs
        Object.entries(this.inputs).forEach(([name, input]) => {
            if (input && input.type !== "checkbox") {
                input.addEventListener("input", () => {
                    this.validateField(name);
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

        // Eventos específicos para checkboxes
        if (this.inputs.acepta_terminos) {
            this.inputs.acepta_terminos.addEventListener("change", () => {
                this.validateTerms();
            });
        }

        // Enlaces específicos de registro
        const resendLink = document.getElementById("resendCode");
        if (resendLink) {
            resendLink.addEventListener("click", (e) =>
                this.handleResendCode(e)
            );
        }

        const contactSupport = document.getElementById("contactSupport");
        if (contactSupport) {
            contactSupport.addEventListener("click", (e) =>
                this.handleContactSupport(e)
            );
        }

        const helpCenter = document.getElementById("helpCenter");
        if (helpCenter) {
            helpCenter.addEventListener("click", (e) =>
                this.handleHelpCenter(e)
            );
        }

        // Enlaces de términos y privacidad
        document
            .querySelectorAll(".link-terms, .link-privacy")
            .forEach((link) => {
                link.addEventListener("click", (e) => this.handleLegalLinks(e));
            });

        // Enlaces de social media del lado izquierdo
        document
            .querySelectorAll(".social-section .social-link")
            .forEach((link) => {
                link.addEventListener("click", (e) =>
                    this.handleSocialClick(e)
                );
            });

        // Efectos adicionales
        this.initBrandingEffects();
    }

    // ===== CONFIGURACIÓN POR PASOS ===== //
    focusFirstInput() {
        if (this.inputs.name) {
            setTimeout(() => {
                this.inputs.name.focus();
            }, 100);
        }
    }

    setupFormValidation() {
        // Configurar validación específica para formulario de registro
        if (this.inputs.password) {
            this.inputs.password.addEventListener("input", () => {
                this.validatePassword();
                this.checkPasswordMatch();
            });
        }

        if (this.inputs.confirm_password) {
            this.inputs.confirm_password.addEventListener("input", () => {
                this.checkPasswordMatch();
            });
        }

        // Formateo automático para teléfono
        if (this.inputs.telefono) {
            this.inputs.telefono.addEventListener("input", (e) => {
                this.formatPhoneNumber(e.target);
            });
        }
    }

    setupCodeInput() {
        if (this.inputs.code) {
            // Auto-focus en el input de código
            setTimeout(() => {
                this.inputs.code.focus();
            }, 100);

            // Solo números en el código
            this.inputs.code.addEventListener("input", (e) => {
                e.target.value = e.target.value.replace(/[^0-9]/g, "");
                if (e.target.value.length > 6) {
                    e.target.value = e.target.value.slice(0, 6);
                }
            });

            // Submit automático cuando se completa el código
            this.inputs.code.addEventListener("input", (e) => {
                if (e.target.value.length === 6) {
                    setTimeout(() => {
                        this.form.submit();
                    }, 500);
                }
            });
        }
    }

    // ===== VALIDACIÓN ===== //
    validateField(fieldName) {
        const input = this.inputs[fieldName];
        if (!input) return false;

        const value = input.value.trim();
        let isValid = false;
        let message = "";

        switch (fieldName) {
            case "name":
            case "apellido":
                isValid = value.length >= 2 && /^[a-zA-ZÀ-ÿ\s]+$/.test(value);
                message = isValid
                    ? ""
                    : "Debe contener solo letras y al menos 2 caracteres";
                break;

            case "ci":
                isValid = value.length >= 6 && /^\d+$/.test(value);
                message = isValid
                    ? ""
                    : "La cédula debe contener solo números (mínimo 6 dígitos)";
                break;

            case "email":
                isValid = this.config.emailRegex.test(value);
                message = isValid ? "" : "Ingresa un email válido";
                break;

            case "telefono":
                // Teléfono es opcional
                if (value) {
                    isValid = this.config.phoneRegex.test(value);
                    message = isValid ? "" : "Formato de teléfono inválido";
                } else {
                    isValid = true; // Opcional
                }
                break;

            case "password":
                isValid = value.length >= this.config.minPasswordLength;
                message = isValid
                    ? ""
                    : `La contraseña debe tener al menos ${this.config.minPasswordLength} caracteres`;
                this.validatePassword();
                break;

            case "confirm_password":
                const passwordValue = this.inputs.password?.value || "";
                isValid = value === passwordValue && value.length > 0;
                message = isValid ? "" : "Las contraseñas no coinciden";
                break;

            case "code":
                isValid =
                    value.length === this.config.codeLength &&
                    /^\d+$/.test(value);
                message = isValid ? "" : "Ingresa un código de 6 dígitos";
                break;
        }

        this.setFieldState(input, isValid, message);
        return isValid;
    }

    validatePassword() {
        if (!this.inputs.password) return;

        const password = this.inputs.password.value;
        const requirements = this.config.passwordRequirements;
        const errors = [];

        // Validar cada requisito y recopilar errores
        if (password.length < requirements.minLength) {
            errors.push(`Mínimo ${requirements.minLength} caracteres`);
        }
        if (!requirements.uppercase.test(password)) {
            errors.push("Una letra mayúscula");
        }
        if (!requirements.lowercase.test(password)) {
            errors.push("Una letra minúscula");
        }
        if (!requirements.number.test(password)) {
            errors.push("Un número");
        }

        // Mostrar errores en el campo o limpiar si es válido
        const isValid = errors.length === 0;
        const errorMessage = isValid ? "" : `Requisitos: ${errors.join(", ")}`;

        this.setFieldState(this.inputs.password, isValid, errorMessage);

        return isValid;
    }

    checkPasswordMatch() {
        if (!this.inputs.password || !this.inputs.confirm_password) return;

        const password = this.inputs.password.value;
        const confirmPassword = this.inputs.confirm_password.value;

        if (confirmPassword) {
            const matches = password === confirmPassword;
            this.setFieldState(
                this.inputs.confirm_password,
                matches,
                matches ? "" : "Las contraseñas no coinciden"
            );
            return matches;
        }
        return true;
    }

    validateTerms() {
        const termsAccepted = this.inputs.acepta_terminos?.checked;
        const termsGroup =
            this.inputs.acepta_terminos?.closest(".checkbox-label");

        if (termsGroup) {
            if (!termsAccepted) {
                termsGroup.style.borderLeft = "3px solid #ef4444";
                termsGroup.style.paddingLeft = "0.5rem";
            } else {
                termsGroup.style.borderLeft = "none";
                termsGroup.style.paddingLeft = "0";
            }
        }

        return termsAccepted;
    }

    setFieldState(input, isValid, message = "") {
        const inputGroup = input.closest(".input-group");
        const errorElement = inputGroup?.querySelector(".input-error");

        // Actualizar clases
        input.classList.remove("error", "success");
        if (message) {
            input.classList.add(isValid ? "success" : "error");
        } else if (input.value.trim() && isValid) {
            input.classList.add("success");
        }

        // Mostrar/ocultar error
        if (errorElement) {
            errorElement.textContent = message;
            errorElement.classList.toggle("show", !isValid && message);
        }
    }

    // ===== SUBMIT DEL FORMULARIO ===== //
    async handleSubmit(e) {
        e.preventDefault();

        // Validar según el paso actual
        let isFormValid = false;

        if (this.currentStep === "register") {
            // Validar todos los campos requeridos
            const requiredFields = [
                "name",
                "apellido",
                "ci",
                "email",
                "password",
                "confirm_password",
            ];
            const validations = requiredFields.map((field) =>
                this.validateField(field)
            );
            const passwordRequirementsMet = this.validatePassword();
            const passwordsMatch = this.checkPasswordMatch();
            const termsAccepted = this.validateTerms();

            isFormValid =
                validations.every((v) => v) &&
                passwordRequirementsMet &&
                passwordsMatch &&
                termsAccepted;

            if (!termsAccepted) {
                this.showMessage(
                    "Debes aceptar los términos y condiciones para continuar",
                    "error"
                );
            }
        } else if (this.currentStep === "verify") {
            isFormValid = this.validateField("code");
        }

        if (!isFormValid) {
            this.showMessage(
                "Por favor corrige los errores antes de continuar",
                "error"
            );
            return;
        }

        if (this.isLoading) return;

        this.setLoadingState(true);

        try {
            // Simular delay para mejor UX
            await new Promise((resolve) => setTimeout(resolve, 1000));

            // Aquí iría la lógica real de envío
            this.form.submit();
        } catch (error) {
            console.error("Error:", error);
            this.showMessage("Error de conexión. Intenta de nuevo.", "error");
            this.setLoadingState(false);
        }
    }

    setLoadingState(loading) {
        this.isLoading = loading;
        if (this.button) {
            this.button.disabled = loading;
            this.button.classList.toggle("loading", loading);
        }
    }

    // ===== FORMATEO Y UTILIDADES ===== //
    formatPhoneNumber(input) {
        let value = input.value.replace(/\D/g, "");

        if (value.length > 0) {
            // Formateo básico para números internacionales
            if (value.startsWith("1")) {
                value = value.replace(
                    /(\d{1})(\d{3})(\d{3})(\d{4})/,
                    "+$1 $2 $3 $4"
                );
            } else if (value.startsWith("34")) {
                value = value.replace(
                    /(\d{2})(\d{3})(\d{3})(\d{3})/,
                    "+$1 $2 $3 $4"
                );
            } else if (value.startsWith("52")) {
                value = value.replace(
                    /(\d{2})(\d{3})(\d{3})(\d{4})/,
                    "+$1 $2 $3 $4"
                );
            } else {
                // Formato general
                if (value.length <= 10) {
                    value = value.replace(/(\d{3})(\d{3})(\d{4})/, "$1 $2 $3");
                }
            }
        }

        input.value = value;
    }

    // ===== MANEJO DE ENLACES ===== //
    handleResendCode(e) {
        e.preventDefault();
        this.showMessage("Reenviando código de verificación...", "info");

        setTimeout(() => {
            this.showMessage("Código reenviado correctamente", "success");
        }, 1500);
    }

    handleContactSupport(e) {
        e.preventDefault();
        this.showMessage("Abriendo soporte VIP...", "info");
    }

    handleHelpCenter(e) {
        e.preventDefault();
        this.showMessage("Accediendo al centro de ayuda...", "info");
    }

    handleLegalLinks(e) {
        e.preventDefault();
        const isTerms = e.target.classList.contains("link-terms");
        this.showMessage(
            isTerms
                ? "Abriendo términos y condiciones..."
                : "Abriendo política de privacidad...",
            "info"
        );
    }

    // ===== REDES SOCIALES ===== //
    handleSocialClick(e) {
        e.preventDefault();
        const socialType = e.currentTarget.classList;

        if (socialType.contains("tiktok")) {
            this.showMessage("Abriendo TikTok de la Asociación...", "info");
        } else if (socialType.contains("facebook")) {
            this.showMessage("Abriendo Facebook de la Asociación...", "info");
        } else if (socialType.contains("instagram")) {
            this.showMessage("Abriendo Instagram de la Asociación...", "info");
        } else if (socialType.contains("whatsapp")) {
            this.showMessage("Contactando por WhatsApp...", "info");
        }
    }

    // ===== MENSAJES ===== //
    showMessage(message, type = "info") {
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

        const icons = {
            success: "✅",
            error: "⚠️",
            info: "ℹ️",
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
      display: flex;
      align-items: center;
      gap: 8px;
    `;

        messageEl.innerHTML = `
      <span class="message-icon">${icons[type]}</span>
      <span class="message-text">${message}</span>
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

    // ===== EFECTOS VISUALES ===== //

    initBrandingEffects() {
        // Efecto parallax sutil en el logo
        const logo = document.querySelector(".brand-logo");
        if (logo) {
            document.addEventListener("mousemove", (e) => {
                const { clientX, clientY } = e;
                const { innerWidth, innerHeight } = window;

                const xPos = (clientX / innerWidth - 0.5) * 8;
                const yPos = (clientY / innerHeight - 0.5) * 8;

                logo.style.transform = `translate(${xPos}px, ${yPos}px)`;
            });
        }

        // Efectos en enlaces sociales
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

        // Animación de partículas
        this.animateParticles();

        // Efectos en inputs cuando están en focus
        this.setupInputEffects();
    }

    animateParticles() {
        const particles = document.querySelectorAll(".particle");
        particles.forEach((particle) => {
            const randomDelay = Math.random() * 2000;
            const randomDuration = 4000 + Math.random() * 2000;

            particle.style.animationDelay = `${randomDelay}ms`;
            particle.style.animationDuration = `${randomDuration}ms`;
        });
    }

    setupInputEffects() {
        // Efectos visuales adicionales en inputs
        Object.values(this.inputs).forEach((input) => {
            if (input && input.type !== "checkbox") {
                input.addEventListener("focus", () => {
                    const wrapper = input.closest(".input-wrapper");
                    if (wrapper) {
                        wrapper.style.transform = "scale(1.02)";
                        wrapper.style.transition = "transform 0.2s ease";
                    }
                });

                input.addEventListener("blur", () => {
                    const wrapper = input.closest(".input-wrapper");
                    if (wrapper) {
                        wrapper.style.transform = "scale(1)";
                    }
                });
            }
        });
    }

    // ===== ACCESIBILIDAD ===== //
    handleKeyboardNavigation() {
        document.addEventListener("keydown", (e) => {
            if (e.key === "Escape") {
                // Cerrar mensajes activos
                const messages = document.querySelectorAll(".message");
                messages.forEach((msg) => {
                    msg.style.transform = "translateX(100%)";
                    setTimeout(() => {
                        if (msg.parentNode) {
                            msg.parentNode.removeChild(msg);
                        }
                    }, 300);
                });
            }

            // Enter en el último input válido
            if (e.key === "Enter") {
                const activeElement = document.activeElement;
                if (
                    activeElement &&
                    activeElement.classList.contains("form-input")
                ) {
                    const form = activeElement.closest("form");
                    if (form && this.currentStep === "register") {
                        // En registro, validar antes de submit automático
                        e.preventDefault();
                        this.handleSubmit(e);
                    }
                }
            }
        });
    }
}

// ===== INICIALIZAR =====
const asociacionRegistration = new AsociacionRegistration();

// Funciones globales para debugging (opcional)
window.asociacionRegistration = asociacionRegistration;
