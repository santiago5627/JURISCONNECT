/**
 * Módulo de utilidades API y CSRF
 */

export const getCsrfToken = () => {
    const el = document.querySelector('meta[name="csrf-token"]');
    return el ? el.getAttribute("content") : null;
};

export async function fetchJson(url, options = {}) {
    const headers = options.headers || {};
    headers["X-Requested-With"] = headers["X-Requested-With"] || "XMLHttpRequest";
    if (!options.skipCsrf) {
        const token = getCsrfToken();
        if (token) headers["X-CSRF-TOKEN"] = token;
    }
    headers["Accept"] = headers["Accept"] || "application/json";
    
    options.headers = headers;
    const resp = await fetch(url, options);
    const json = await resp.json().catch(() => ({}));
    return { ok: resp.ok, status: resp.status, data: json };
}

export async function checkForDuplicatesAPI(body) {
    try {
        const res = await fetchJson("/lawyers/check-duplicates", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify(body),
        });
        return res;
    } catch (err) {
        console.error("checkForDuplicatesAPI:", err);
        return { ok: false, data: null };
    }
}

export async function checkFieldAPI(field, value) {
    try {
        const res = await fetchJson("/lawyers/check-field", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ field, value }),
        });
        return res;
    } catch (err) {
        console.error("checkFieldAPI:", err);
        return { ok: false, data: null };
    }
}