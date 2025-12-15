/**
 * Módulo de paginación AJAX y búsqueda
 */

let searchTimeout;

export function performSearch(searchTerm) {
    const params = new URLSearchParams();
    if (searchTerm) params.append("search", searchTerm);
    params.append("ajax", "1");

    fetch(`${window.location.pathname}?${params.toString()}`, {
        method: "GET",
        headers: {
            "X-Requested-With": "XMLHttpRequest",
            Accept: "application/json",
        },
    })
        .then((response) => response.json())
        .then((data) => {
            if (data.success && data.html) {
                const tempDiv = document.createElement("div");
                tempDiv.innerHTML = data.html;

                const newTableBody = tempDiv.querySelector("#tableBody");
                const currentTableBody = document.querySelector("#tableBody");
                if (newTableBody && currentTableBody)
                    currentTableBody.innerHTML = newTableBody.innerHTML;

                const newPagination = tempDiv.querySelector(".pagination");
                const currentPaginationContainer = document.querySelector(".pagination")?.parentElement;
                if (currentPaginationContainer) {
                    if (newPagination)
                        currentPaginationContainer.innerHTML = newPagination.parentElement.innerHTML;
                    else
                        currentPaginationContainer.innerHTML = "";
                }

                const newUrl = new URL(window.location);
                if (searchTerm) newUrl.searchParams.set("search", searchTerm);
                else newUrl.searchParams.delete("search");
                newUrl.searchParams.delete("page");
                window.history.replaceState({}, "", newUrl.toString());
            }
        })
        .catch((error) => console.error("Error en búsqueda:", error));
}

export function clearSearch() {
    const input = document.getElementById("searchInput");
    if (input) input.value = "";
    performSearch("");
}

export function setupSearchInput() {
    const searchInput = document.getElementById("searchInput");
    if (!searchInput) return;

    searchInput.addEventListener("input", function () {
        clearTimeout(searchTimeout);
        const searchTerm = this.value.trim();
        searchTimeout = setTimeout(() => performSearch(searchTerm), 300);
    });
}

export function handleAjaxPagination() {
    const sections = [
        document.querySelector("#lawyers-section"),
        document.querySelector("#assistants-section"),
        document.querySelector("#lawyersTableWrapper"),
        document.querySelector("#assistantsTableWrapper")
    ];

    sections.forEach(section => {
        if (!section) return;

        section.addEventListener("click", function (e) {
            const link = e.target.closest(".pagination-btn.ajax-page");
            if (!link) return;
            e.preventDefault();

            const url = link.getAttribute("href");
            if (!url || url === "#") return;

            const container = section.querySelector(".table-container, .table-wrapper");
            if (container) {
                container.style.opacity = "0.5";
                container.style.pointerEvents = "none";
            }

            fetch(url, {
                method: "GET",
                headers: {
                    "X-Requested-With": "XMLHttpRequest",
                    Accept: "application/json",
                },
            })
                .then(async (resp) => {
                    if (!resp.ok)
                        throw new Error(`HTTP error! status: ${resp.status}`);
                    return resp.json();
                })
                .then((data) => {
                    if (data.success && data.html) {
                        const newContainer = document.createElement("div");
                        newContainer.innerHTML = data.html;
                        const newContent = newContainer.querySelector(".table-container, .table-wrapper");

                        if (container && newContent) {
                            container.replaceWith(newContent);
                        }

                        if (window.history && window.history.pushState)
                            window.history.pushState({}, "", url);

                        handleAjaxPagination();
                    } else {
                        throw new Error(data.message || "Formato de respuesta inválido");
                    }
                })
                .catch((error) => {
                    console.error("Error en paginación AJAX:", error);
                    if (container) {
                        container.innerHTML = `<div class="alert alert-danger" style="padding: 20px; color: red;"><strong>Error:</strong> ${error.message}</div>`;
                        container.style.opacity = "1";
                        container.style.pointerEvents = "auto";
                    }
                })
                .finally(() => {
                    if (container) {
                        container.style.opacity = "1";
                        container.style.pointerEvents = "auto";
                    }
                });
        });
    });
}