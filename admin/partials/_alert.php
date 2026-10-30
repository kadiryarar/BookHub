<?php if (!empty($data)): ?>
  <div class="toast-container position-fixed top-0 end-0 p-3 pt-4 mt-5">
    <div class="alert alert-<?php echo $data["status"]; ?> alert-dismissible fade show d-flex align-items-center gap-2 shadow pe-auto mb-0" role="alert">
      <?php if ($data["status"] === "success"): ?>
        <i class="bi bi-check-circle-fill"></i>
      <?php else: ?>
        <i class="bi bi-exclamation-triangle-fill"></i>
      <?php endif; ?>
      <div><?php echo $data["message"]; ?></div>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Kapat"></button>
    </div>
  </div>
<?php endif; ?>