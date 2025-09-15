    const hamburgerBtn = document.getElementById('hamburgerBtn');
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('overlay');

        // Sidebar y modales
function toggleSidebar() {
    sidebar.classList.toggle("active");
    overlay.classList.toggle("active");
}

function closeSidebar() {
    sidebar.classList.remove("active");
    overlay.classList.remove("active");
}

function openModal() {
    createLawyerModal.classList.add("active");
    document.body.style.overflow = "hidden";
}

function closeModalFunction() {
    createLawyerModal.classList.remove("active");
    document.body.style.overflow = "auto";
    document.querySelector("#createLawyerModal form").reset();
}