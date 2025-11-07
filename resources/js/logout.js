document
    .getElementById("logoutButton")
    .addEventListener("click", async function () {
        try {
            const response = await fetch("/logout", {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": document
                        .querySelector('meta[name="csrf-token"]')
                        .getAttribute("content"),
                    "Content-Type": "application/json",
                },
            });

            if (response.ok) {
                window.location.href = "/account.login";
            } else {
                console.error("Logout failed");
            }
        } catch (error) {
            console.error("An error occurred:", error);
        }
    });
