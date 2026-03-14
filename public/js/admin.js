/* DevRoots Academy — Admin JS */
document.addEventListener('DOMContentLoaded', function () {

  /* ---- Sidebar toggle (mobile) ---- */
  const sidebar  = document.getElementById('adSidebar');
  const overlay  = document.getElementById('adOverlay');
  const toggleBtn = document.getElementById('adSidebarToggle');
  const closeBtn  = document.getElementById('adSidebarClose');

  function openSidebar() {
    sidebar && sidebar.classList.add('show');
    overlay && overlay.classList.add('show');
    document.body.style.overflow = 'hidden';
  }
  function closeSidebar() {
    sidebar && sidebar.classList.remove('show');
    overlay && overlay.classList.remove('show');
    document.body.style.overflow = '';
  }
  toggleBtn && toggleBtn.addEventListener('click', openSidebar);
  closeBtn  && closeBtn.addEventListener('click', closeSidebar);
  overlay   && overlay.addEventListener('click', closeSidebar);

  /* ---- User dropdown ---- */
  const userMenu = document.querySelector('.ad-user-menu');
  if (userMenu) {
    const trigger = userMenu.querySelector('.ad-user-trigger');
    trigger && trigger.addEventListener('click', function (e) {
      e.stopPropagation();
      userMenu.classList.toggle('open');
    });
    document.addEventListener('click', function () {
      userMenu.classList.remove('open');
    });
  }

  /* ---- Auto-dismiss alerts ---- */
  document.querySelectorAll('.ad-alert').forEach(function (el) {
    const closeBtn = el.querySelector('.ad-alert-close');
    if (closeBtn) {
      closeBtn.addEventListener('click', function () {
        el.style.opacity = '0';
        el.style.transform = 'translateY(-4px)';
        el.style.transition = 'opacity 0.2s, transform 0.2s';
        setTimeout(function () { el.remove(); }, 200);
      });
    }
    // Auto-remove success alerts after 5s
    if (el.classList.contains('ad-alert-success')) {
      setTimeout(function () {
        el.style.opacity = '0';
        el.style.transition = 'opacity 0.3s';
        setTimeout(function () { el.remove(); }, 300);
      }, 5000);
    }
  });

  /* ---- Live table search ---- */
  document.querySelectorAll('.ad-table-search').forEach(function (input) {
    const tableId = input.dataset.table;
    const table   = document.getElementById(tableId);
    if (!table) return;
    const rows = table.querySelectorAll('tbody tr');
    input.addEventListener('input', function () {
      const q = this.value.toLowerCase().trim();
      rows.forEach(function (row) {
        row.style.display = row.textContent.toLowerCase().includes(q) ? '' : 'none';
      });
    });
  });

  /* ---- Confirm delete modal ---- */
  const confirmOverlay = document.getElementById('adConfirmOverlay');
  const confirmYes = document.getElementById('adConfirmYes');
  const confirmNo  = document.getElementById('adConfirmNo');
  let pendingDeleteForm = null;

  document.querySelectorAll('[data-confirm-delete]').forEach(function (el) {
    el.addEventListener('click', function (e) {
      e.preventDefault();
      const form = this.closest('form') || document.getElementById(this.dataset.form);
      if (form) {
        pendingDeleteForm = form;
        confirmOverlay && confirmOverlay.classList.add('show');
      }
    });
  });

  confirmYes && confirmYes.addEventListener('click', function () {
    if (pendingDeleteForm) {
      pendingDeleteForm.submit();
    }
    confirmOverlay && confirmOverlay.classList.remove('show');
  });

  confirmNo && confirmNo.addEventListener('click', function () {
    pendingDeleteForm = null;
    confirmOverlay && confirmOverlay.classList.remove('show');
  });

  /* ---- Image preview ---- */
  document.querySelectorAll('input[type="file"][data-preview]').forEach(function (input) {
    const previewId = input.dataset.preview;
    const preview   = document.getElementById(previewId);
    if (!preview) return;
    input.addEventListener('change', function () {
      if (this.files && this.files[0]) {
        const reader = new FileReader();
        reader.onload = function (e) {
          preview.src = e.target.result;
          preview.classList.add('show');
        };
        reader.readAsDataURL(this.files[0]);
      }
    });
  });

  /* ---- Status filter (select to submit parent form) ---- */
  document.querySelectorAll('.ad-auto-submit').forEach(function (el) {
    el.addEventListener('change', function () {
      this.closest('form') && this.closest('form').submit();
    });
  });

});
