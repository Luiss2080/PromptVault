document.addEventListener("DOMContentLoaded", function () {
    const logOutput = document.getElementById("logOutput");
    const logs = [
        "> Searching database...",
        "> Route parameter mismatch...",
        "> 404 Exception caught...",
        "> Displaying fallback view...",
        "> Ready for navigation.",
    ];
    let index = 0;

    // Simple typing log effect for the error page
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
                index = 0; // Loop or stop? Let's loop for activity
            }
        }, 2000);
    }
});
