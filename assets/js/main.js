lucide.createIcons();


// JavaScript Toggle Sidebar
const toggleBtn = document.getElementById("sidebarToggle");
const sidebar = document.getElementById("sidebar");

toggleBtn?.addEventListener("click", () => {
  sidebar.classList.toggle("-translate-x-full");
});

// ===== Grafik Voting =====
const canvas = document.getElementById("votingChart");
if (canvas) {
  const ctx = canvas.getContext("2d");
  const votingChart = new Chart(ctx, {
    type: "bar",
    data: {
      labels: ["Kandidat A", "Kandidat B", "Kandidat C", "Kandidat D"],
      datasets: [
        {
          label: "Jumlah Suara",
          data: [250, 300, 200, 230],
          backgroundColor: [
            "rgba(59, 130, 246, 0.6)",
            "rgba(16, 185, 129, 0.6)",
            "rgba(249, 115, 22, 0.6)",
            "rgba(239, 68, 68, 0.6)",
          ],
          borderColor: [
            "rgba(59, 130, 246, 1)",
            "rgba(16, 185, 129, 1)",
            "rgba(249, 115, 22, 1)",
            "rgba(239, 68, 68, 1)",
          ],
          borderWidth: 1,
          borderRadius: 8,
        },
      ],
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: { display: false },
        tooltip: {
          backgroundColor: "#1f2937",
          titleColor: "#fff",
          bodyColor: "#fff",
        },
      },
      scales: {
        y: {
          beginAtZero: true,
          ticks: { stepSize: 50 },
        },
      },
    },
  });
}

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

      const topContainer = $(
        '<div class="flex flex-col sm:flex-row justify-between sm:items-center gap-4 mb-4 flex-wrap"></div>'
      );
      length
        .addClass("text-sm text-gray-700")
        .find("select")
        .addClass(
          "border border-gray-300 rounded-md px-3 py-1 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-400"
        );
      filter
        .addClass("text-sm text-gray-700")
        .find("input")
        .addClass(
          "border border-gray-300 rounded-md px-4 py-2 ml-2 text-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-400"
        )
        .attr("placeholder", "🔍 Cari nama, kelas, atau status");

      topContainer.append(length).append(filter);
      wrapper.find(".dataTables_length, .dataTables_filter").remove();
      wrapper.prepend(topContainer);

      // Pagination
      wrapper
        .find(".dataTables_paginate a")
        .addClass(
          "inline-block border border-gray-300 rounded-md px-3 py-1 mx-1 text-sm text-gray-700 bg-white hover:bg-blue-100 hover:text-blue-600 transition"
        );

      wrapper
        .find(".dataTables_paginate .current")
        .removeClass("bg-white")
        .addClass("bg-blue-500 text-white hover:bg-blue-600");

      // Info text
      wrapper.find(".dataTables_info").addClass("text-sm text-gray-500 mt-4");
    },
  });
});