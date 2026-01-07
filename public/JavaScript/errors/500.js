document.addEventListener("DOMContentLoaded", function () {
    const logOutput = document.getElementById("logOutput");
    const logs = [
        "> System Integrity Check...",
        "> Internal Server Error Detected...",
        "> Stack Trace Dumped...",
        "> Attempting recovery...",
        "> Please contact Admin.",
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
