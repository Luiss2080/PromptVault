document.addEventListener("DOMContentLoaded", function () {
    const logOutput = document.getElementById("logOutput");
    const logs = [
        "> Verifying credentials...",
        "> Access token invalid or expired...",
        "> 403 Forbidden Exception...",
        "> Security protocols active...",
        "> Incident logged.",
    ];
    let index = 0;

    if (logOutput) {
        setInterval(() => {
            if (index < logs.length) {
                logOutput.style.opacity = "0";
                setTimeout(() => {
                    logOutput.innerText = logs[index];
                    logOutput.style.opacity = "1";
                    index++;
                }, 200);
            } else {
                index = 0;
            }
        }, 2000);
    }
});
