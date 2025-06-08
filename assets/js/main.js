lucide.createIcons();

// Toggle Sidebar
const toggleBtn = document.getElementById("sidebarToggle");
const sidebar = document.getElementById("sidebar");

toggleBtn?.addEventListener("click", () => {
  sidebar.classList.toggle("-translate-x-full");
});

// Toggle close & open sidebar
document.addEventListener("DOMContentLoaded", () => {
  const sidebar = document.getElementById("sidebar");
  const mainContent = document.getElementById("mainContent");
  const toggleBtn = document.getElementById("toggleSidebar");
  const mobileToggle = document.getElementById("sidebarToggle");

  let sidebarOpen =
    localStorage.getItem("sidebarOpen") === "false" ? false : true;

  function isDesktop() {
    return window.innerWidth >= 768;
  }

  function updateDesktopLayout() {
    sidebar.style.transform = sidebarOpen
      ? "translateX(0)"
      : "translateX(-100%)";

    if (toggleBtn) {
      toggleBtn.innerHTML = "";
      const icon = document.createElement("i");
      icon.setAttribute(
        "data-lucide",
        sidebarOpen ? "arrow-left" : "arrow-right"
      );
      toggleBtn.appendChild(icon);
      toggleBtn.style.right = sidebarOpen ? "-20px" : "-45px";
      toggleBtn.classList.remove("hidden");
    }

    if (mainContent) {
      mainContent.classList.remove("ml-64", "ml-8");
      mainContent.classList.add(sidebarOpen ? "ml-64" : "ml-8");
    }

    lucide.createIcons();
  }

  // Toggle desktop
  if (toggleBtn) {
    toggleBtn.addEventListener("click", () => {
      if (!isDesktop()) return;
      sidebarOpen = !sidebarOpen;
      localStorage.setItem("sidebarOpen", sidebarOpen);
      updateDesktopLayout();
    });
  }

  // Toggle mobile
  if (mobileToggle) {
    mobileToggle.addEventListener("click", () => {
      if (isDesktop()) return;
      const isHidden = sidebar.style.transform === "translateX(-100%)";
      sidebar.style.transform = isHidden
        ? "translateX(0)"
        : "translateX(-100%)";
    });
  }

  // Responsiveness
  window.addEventListener("resize", () => {
    if (isDesktop()) {
      sidebarOpen =
        localStorage.getItem("sidebarOpen") === "false" ? false : true;
      updateDesktopLayout();
    } else {
      sidebar.style.transform = "translateX(-100%)";
      if (mainContent) mainContent.classList.remove("ml-64", "ml-8");
      if (toggleBtn) toggleBtn.classList.add("hidden");
    }
  });

  // Initial layout
  if (isDesktop()) {
    updateDesktopLayout();
  } else {
    sidebar.style.transform = "translateX(-100%)";
    if (mainContent) mainContent.classList.remove("ml-64", "ml-8");
    if (toggleBtn) toggleBtn.classList.add("hidden");
  }

  sidebar.style.visibility = "visible";
});

// ===== DataTables =====
$(document).ready(function () {
  const table = $("#dataTables").DataTable({
    responsive: true,
    language: {
      paginate: {
        previous: "←",
        next: "→",
      },
    },
    initComplete: function () {
      const wrapper = $("#dataTables_wrapper");
      const length = wrapper.find(".dataTables_length");
      const filter = wrapper.find(".dataTables_filter");

      const topContainer = $(`
        <div class="flex flex-col gap-3 sm:flex-row sm:justify-between sm:items-center mb-4">
        </div>
      `);

      // Style dropdown jumlah data
      length
        .addClass("text-sm text-gray-700")
        .find("select")
        .addClass(
          "border border-gray-300 rounded-lg px-3 py-1.5 text-sm text-gray-700 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
        );

      // Style input search
      filter
        .addClass("text-sm text-gray-700")
        .find("input")
        .addClass(
          "border border-gray-300 rounded-lg px-4 py-2 text-sm text-gray-700 placeholder-gray-400 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 w-full sm:w-64"
        )
        .attr("placeholder", "🔍 Cari sesuatu ...");

      topContainer.append(length).append(filter);
      wrapper.find(".dataTables_length, .dataTables_filter").remove();
      wrapper.prepend(topContainer);

      // Pagination styling
      wrapper
        .find(".dataTables_paginate a")
        .addClass(
          "inline-block border border-gray-300 rounded-md px-3 py-1 mx-1 text-sm text-gray-700 bg-white hover:bg-blue-100 hover:text-blue-600 transition duration-200 ease-in-out"
        );

      // Active page styling
      wrapper
        .find(".dataTables_paginate .current")
        .removeClass("bg-white")
        .addClass("bg-blue-500 text-white hover:bg-blue-600");

      // Info text styling
      wrapper.find(".dataTables_info").addClass("text-sm text-gray-500 mt-4");
    },
  });
});

// Sweet-Alert confirm to DELETE
$(document).ready(function () {
  if (!$.fn.DataTable.isDataTable("#dataTables")) {
    $("#dataTables").DataTable({
      responsive: true,
    });
  }

  // Event hapus dengan SweetAlert (sama seperti sebelumnya)
  $(document).on("click", ".btn-hapus", function (e) {
    e.preventDefault();
    const url = $(this).attr("href");

    Swal.fire({
      title: "Yakin ingin menghapus?",
      text: "Data yang dihapus akan diarsipkan dan bisa dikembalikan jika diperlukan.",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Ya, hapus!",
    }).then((result) => {
      if (result.isConfirmed) {
        window.location.href = url;
      }
    });
  });
});

// Sweet-Alert confirm to LOGOUT
$(document).on("click", ".btn-logout", function (e) {
  e.preventDefault();
  const url = $(this).attr("href");

  Swal.fire({
    title: "Keluar dari sistem?",
    text: "Anda akan keluar dari akun saat ini.",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#aaa",
    confirmButtonText: "Ya, Logout",
    cancelButtonText: "Batal",
  }).then((result) => {
    if (result.isConfirmed) {
      window.location.href = url;
    }
  });
});
