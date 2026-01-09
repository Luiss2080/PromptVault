document.addEventListener("DOMContentLoaded", function () {
    // Foto Preview
    const avatarInput = document.getElementById("avatar");
    const photoPreview = document.querySelector(".photo-preview");
    const photoPlaceholder = document.querySelector(".photo-placeholder");

    if (avatarInput) {
        avatarInput.addEventListener("change", function (event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    if (photoPreview) {
                        photoPreview.src = e.target.result;
                        photoPreview.style.display = "block";
                    }
                    if (photoPlaceholder) {
                        photoPlaceholder.style.display = "none";
                    }
                };
                reader.readAsDataURL(file);
            }
        });
    }

    // Initialize Custom Selects
    const initCustomSelects = () => {
        const customSelects = document.querySelectorAll(".form-select");
        customSelects.forEach((select) => {
            if (
                select.nextElementSibling &&
                select.nextElementSibling.classList.contains(
                    "custom-select-wrapper"
                )
            )
                return;

            select.style.display = "none";
            const wrapper = document.createElement("div");
            wrapper.classList.add("custom-select-wrapper");

            const trigger = document.createElement("div");
            trigger.classList.add("custom-select-trigger");
            trigger.innerHTML = `<span>${
                select.options[select.selectedIndex].text
            }</span><i class="fas fa-chevron-down"></i>`;

            const customOptions = document.createElement("div");
            customOptions.classList.add("custom-options");

            Array.from(select.options).forEach((option) => {
                if (option.disabled && option.value === "") return;

                const optionEl = document.createElement("div");
                optionEl.classList.add("custom-option");
                optionEl.textContent = option.text;
                optionEl.dataset.value = option.value;
                if (option.selected) optionEl.classList.add("selected");

                optionEl.addEventListener("click", () => {
                    select.value = option.value;
                    trigger.querySelector("span").textContent = option.text;
                    customOptions
                        .querySelectorAll(".custom-option")
                        .forEach((opt) => opt.classList.remove("selected"));
                    optionEl.classList.add("selected");
                    wrapper.classList.remove("open");
                    select.dispatchEvent(new Event("change"));
                });
                customOptions.appendChild(optionEl);
            });

            trigger.addEventListener("click", (e) => {
                e.stopPropagation();
                document
                    .querySelectorAll(".custom-select-wrapper.open")
                    .forEach((w) => {
                        if (w !== wrapper) w.classList.remove("open");
                    });
                wrapper.classList.toggle("open");
            });

            wrapper.appendChild(trigger);
            wrapper.appendChild(customOptions);
            select.parentNode.insertBefore(wrapper, select.nextSibling);
        });

        document.addEventListener("click", (e) => {
            if (!e.target.closest(".custom-select-wrapper")) {
                document
                    .querySelectorAll(".custom-select-wrapper.open")
                    .forEach((wrapper) => {
                        wrapper.classList.remove("open");
                    });
            }
        });
    };

    initCustomSelects();
});
