/**
 * ASOCIACIÓN 1RO DE JUNIO - PASSWORD RECOVERY - JAVASCRIPT OPTIMIZADO
 * Funciones específicas para la recuperación de contraseña
 */

class AsociacionRecovery {
    constructor() {
        this.form = null;
        this.inputs = {};
        this.isLoading = false;
        this.currentStep = "email";
        this.config = {
            minPasswordLength: 6,
            emailRegex: /^[^\s@]+@[^\s@]+\.[^\s@]+$/,
            codeLength: 6,
            passwordRequirements: {
                minLength: 6,
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
            this.initPasswordRequirements();
            this.detectCurrentStep();
        });
    }

    cacheElements() {
        this.form = document.getElementById("recoveryForm");
        this.inputs = {
            email: document.getElementById("email"),
            code: document.getElementById("code"),
            password: document.getElementById("password"),
            confirm_password: document.getElementById("confirm_password"),
        };
        this.button = document.getElementById("recoveryButton");
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
            case "email":
                this.focusEmailInput();
                break;
            case "code":
                this.setupCodeInput();
                break;
            case "password":
                this.setupPasswordValidation();
                break;
        }
    }

    bindEvents() {
        if (!this.form) return;

        // Evento del formulario
        this.form.addEventListener("submit", (e) => this.handleSubmit(e));

        // Validación en tiempo real para inputs
        Object.entries(this.inputs).forEach(([name, input]) => {
            if (input) {
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

        // Enlaces específicos de recuperación
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
    focusEmailInput() {
        if (this.inputs.email) {
            setTimeout(() => {
                this.inputs.email.focus();
            }, 100);
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

    setupPasswordValidation() {
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
    }

    // ===== VALIDACIÓN ===== //
    validateField(fieldName) {
        const input = this.inputs[fieldName];
        if (!input || !input.value.trim()) return false;

        const value = input.value.trim();
        let isValid = false;
        let message = "";

        switch (fieldName) {
            case "email":
                isValid = this.config.emailRegex.test(value);
                message = isValid ? "" : "Ingresa un email válido";
                break;

            case "code":
                isValid =
                    value.length === this.config.codeLength &&
                    /^\d+$/.test(value);
                message = isValid ? "" : "Ingresa un código de 6 dígitos";
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
                isValid = value === passwordValue;
                message = isValid ? "" : "Las contraseñas no coinciden";
                break;
        }

        this.setFieldState(input, isValid, message);
        return isValid;
    }

    validatePassword() {
        if (!this.inputs.password) return;

        const password = this.inputs.password.value;
        const requirements = this.config.passwordRequirements;

        // Validar cada requisito
        const checks = {
            lengthReq: password.length >= requirements.minLength,
            upperReq: requirements.uppercase.test(password),
            lowerReq: requirements.lowercase.test(password),
            numberReq: requirements.number.test(password),
        };

        // Actualizar UI de requisitos
        Object.entries(checks).forEach(([reqId, isMet]) => {
            const element = document.getElementById(reqId);
            if (element) {
                element.classList.toggle("met", isMet);
            }
        });

        return Object.values(checks).every((check) => check);
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

    setFieldState(input, isValid, message = "") {
        const inputGroup = input.closest(".input-group");
        const errorElement = inputGroup.querySelector(".input-error");

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

        switch (this.currentStep) {
            case "email":
                isFormValid = this.validateField("email");
                break;
            case "code":
                isFormValid = this.validateField("code");
                break;
            case "password":
                const passwordValid = this.validateField("password");
                const confirmValid = this.validateField("confirm_password");
                const passwordRequirementsMet = this.validatePassword();
                isFormValid =
                    passwordValid && confirmValid && passwordRequirementsMet;
                break;
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
            await new Promise((resolve) => setTimeout(resolve, 800));

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

    // ===== MANEJO DE ENLACES ===== //
    handleResendCode(e) {
        e.preventDefault();
        this.showMessage("Reenviando código de verificación...", "info");

        // Simular reenvío
        setTimeout(() => {
            this.showMessage("Código reenviado correctamente", "success");
        }, 1500);
    }

    handleContactSupport(e) {
        e.preventDefault();
        this.showMessage("Abriendo canal de soporte...", "info");
        // Aquí iría la lógica para abrir soporte
    }

    handleHelpCenter(e) {
        e.preventDefault();
        this.showMessage("Accediendo al centro de ayuda...", "info");
        // Aquí iría la lógica para abrir centro de ayuda
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
    initPasswordRequirements() {
        // Animación de entrada para los requisitos
        const requirements = document.querySelector(".password-requirements");
        if (requirements) {
            requirements.style.opacity = "0";
            requirements.style.transform = "translateY(10px)";

            setTimeout(() => {
                requirements.style.transition = "all 0.5s ease";
                requirements.style.opacity = "1";
                requirements.style.transform = "translateY(0)";
            }, 300);
        }
    }

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

        // Animaciones para elementos de seguridad
        document.querySelectorAll(".security-item").forEach((item, index) => {
            item.addEventListener("mouseenter", () => {
                item.style.transform = "translateY(-2px) scale(1.02)";
            });

            item.addEventListener("mouseleave", () => {
                item.style.transform = "translateY(0) scale(1)";
            });
        });

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

    // ===== UTILIDADES ===== //
    formatCodeInput(input) {
        // Formatear el input del código para mejor UX
        let value = input.value.replace(/\D/g, "");
        if (value.length > 6) {
            value = value.slice(0, 6);
        }

        // Agregar espacios para mejor legibilidad
        if (value.length > 3) {
            value = value.slice(0, 3) + " " + value.slice(3);
        }

        input.value = value;
    }

    // ===== ACCESIBILIDAD ===== //
    handleKeyboardNavigation() {
        // Mejorar navegación por teclado
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
                    if (form) {
                        this.handleSubmit(e);
                    }
                }
            }
        });
    }
}

// ===== INICIALIZAR ===== //
const asociacionRecovery = new AsociacionRecovery();

// Funciones globales para debugging (opcional)
window.asociacionRecovery = asociacionRecovery;
