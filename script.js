// ============================================================
// script.js
// Handles the Toggle and Delete buttons using AJAX (fetch),
// so the page never needs to reload.
// ============================================================

document.addEventListener("DOMContentLoaded", function () {
    const table = document.getElementById("users-table");

    table.addEventListener("click", function (e) {
        // ---------- Toggle button ----------
        if (e.target.classList.contains("toggle-btn")) {
            const button = e.target;
            const userId = button.dataset.id;
            const row = document.getElementById("row-" + userId);
            const badge = row.querySelector(".badge");

            button.disabled = true; // prevent double-clicks while the request runs

            const formData = new FormData();
            formData.append("id", userId);

            fetch("toggle.php", {
                method: "POST",
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    if (data.new_status == 1) {
                        badge.textContent = "1 (Active)";
                        badge.classList.remove("inactive");
                        badge.classList.add("active");
                    } else {
                        badge.textContent = "0 (Inactive)";
                        badge.classList.remove("active");
                        badge.classList.add("inactive");
                    }
                } else {
                    alert("Error: " + data.message);
                }
            })
            .catch(err => {
                console.error(err);
                alert("Could not reach the server");
            })
            .finally(() => {
                button.disabled = false;
            });
        }

        // ---------- Delete button ----------
        if (e.target.classList.contains("delete-btn")) {
            const button = e.target;
            const userId = button.dataset.id;
            const row = document.getElementById("row-" + userId);

            const confirmed = confirm("Delete this entry? This cannot be undone.");
            if (!confirmed) return;

            button.disabled = true;

            const formData = new FormData();
            formData.append("id", userId);

            fetch("delete.php", {
                method: "POST",
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    row.remove(); // remove the row from the table instantly
                } else {
                    alert("Error: " + data.message);
                    button.disabled = false;
                }
            })
            .catch(err => {
                console.error(err);
                alert("Could not reach the server");
                button.disabled = false;
            });
        }
    });
});