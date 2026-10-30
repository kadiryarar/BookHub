<?php

    $page = max(1, (int) ($_GET["p"] ?? 1));

    $result = $trades->getTradesByUser($_SESSION["id"], $page);
    $userTrades = $result["trades"];
    $pageCount = $result["totalPages"];
    $totalItems = $result["totalTrades"];
    $recordStart = $result["start"];
    $recordEnd = $result["end"];

    $start = max(2, $page - 1);
    $end = min($pageCount - 1, $page + 1);

    $statusMap = [
        "pending"   => ["label" => "Bekliyor",     "icon" => "bi-hourglass-split", "bg" => "bg-warning-subtle",   "text" => "text-warning-emphasis"],
        "rejected"  => ["label" => "Reddedildi",   "icon" => "bi-x-circle",        "bg" => "bg-danger-subtle",    "text" => "text-danger"],
        "completed" => ["label" => "Takaslandı",   "icon" => "bi-check-circle",    "bg" => "bg-success-subtle",   "text" => "text-success"],
        "cancelled" => ["label" => "İptal edildi", "icon" => "bi-slash-circle",    "bg" => "bg-secondary-subtle", "text" => "text-secondary"],
    ];
?>
<div class="mb-3 pb-3 border-bottom">
    <h2 class="h5 fw-bold mb-1"><i class="bi bi-arrow-left-right text-primary me-2"></i>Takaslarım</h2>
    <p class="text-muted small mb-0">Gönderdiğin ve aldığın takas teklifleri.</p>
</div>
<?php if (empty($userTrades)): ?>
    <div class="border rounded-4 px-3 py-2 d-flex align-items-center gap-2 text-muted small mt-4">
        <i class="bi bi-arrow-left-right text-primary fs-5"></i>
        <span><strong class="text-dark">Takas yok.</strong> Henüz gönderdiğin veya aldığın bir takas teklifi bulunmuyor.</span>
    </div>
<?php else: ?>
<div class="row row-cols-1 row-cols-lg-2 g-3">
    <?php foreach ($userTrades as $trades): ?>
        <?php
            $status     = $statusMap[$trades->tradesStatus] ?? $statusMap["pending"];
            $isIncoming = $_SESSION["id"] == $trades->receiver_user_id;
            $isPending  = ($trades->tradesStatus === "pending") && ($_SESSION["id"] == $trades->receiver_user_id);

            $otherName = $isIncoming
                ? $trades->sender_name . " " . $trades->sender_surname
                : $trades->receiver_name . " " . $trades->receiver_surname;
        ?>
        <div class="col">
            <div class="border rounded-4 p-3 h-100 d-flex flex-column flex-sm-row align-items-sm-center justify-content-between gap-3">
                <div class="d-flex align-items-center gap-3 overflow-hidden">
                    <div class="<?php echo $status["bg"]; ?> rounded-3 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 50px; height: 50px;" title="<?php echo $status["label"]; ?>" aria-label="<?php echo $status["label"]; ?>">
                        <i class="bi <?php echo $status["icon"] . " " . $status["text"]; ?> fs-4"></i>
                    </div>
                    <div class="overflow-hidden">
                        <div class="mb-1">
                            <?php if ($isIncoming): ?>
                                <span class="badge text-bg-primary">Gelen Teklif</span>
                            <?php else: ?>
                                <span class="badge text-bg-info">Gönderilen Teklif</span>
                            <?php endif; ?>
                        </div>
                        <div class="small text-truncate">
                            <i class="bi bi-box-arrow-in-down text-success me-1"></i>
                            <span class="text-muted">Teklif edilen:</span>
                            <strong class="text-capitalize"><?php echo htmlspecialchars($trades->book_sender_title); ?></strong>
                            <span class="text-muted">· <?php echo htmlspecialchars($trades->book_sender_author); ?></span>
                        </div>
                        <div class="small text-truncate mb-1">
                            <i class="bi bi-box-arrow-up-right text-primary me-1"></i>
                            <span class="text-muted">İstenen:</span>
                            <strong class="text-capitalize"><?php echo htmlspecialchars($trades->book_receiver_title); ?></strong>
                            <span class="text-muted">· <?php echo htmlspecialchars($trades->book_receiver_author); ?></span>
                        </div>
                        <div class="text-muted small text-nowrap">
                            <i class="bi bi-person me-1"></i><?php echo htmlspecialchars($otherName); ?>
                            <i class="bi bi-clock ms-2 me-1"></i><?php echo date("d.m.Y", strtotime($trades->tradesCreatedAt)); ?>
                        </div>
                    </div>
                </div>
                <div class="d-flex align-items-center gap-2 flex-shrink-0 align-self-end align-self-sm-center">
                    <form method="post">
                        <!-- Reddet  -->
                        <input type="hidden" name="tradesId" value="<?php echo $trades->tradesId; ?>">

                        <!-- Kabul Et -->
                        <input type="hidden" name="receiver_user_id" value="<?php echo $trades->receiver_user_id; ?>">
                        <input type="hidden" name="sender_user_id" value="<?php echo $trades->sender_user_id; ?>">
                        <input type="hidden" name="book_sender_id" value="<?php echo $trades->book_sender_id; ?>">
                        <input type="hidden" name="book_receiver_id" value="<?php echo $trades->book_receiver_id; ?>">
                        <?php if ($isPending): ?>
                            <button type="submit" class="btn btn-sm btn-success rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 34px; height: 34px;" title="Kabul Et" aria-label="Kabul Et" name="tradesCompleted"><i class="bi bi-check-lg"></i></button>
                            <button type="submit" class="btn btn-sm btn-outline-danger rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 34px; height: 34px;" title="Reddet" aria-label="Reddet" name="tradesRejected"><i class="bi bi-x-lg"></i></button>
                        <?php endif; ?>
                        <?php if ($trades->sender_user_id == $_SESSION["id"] && $trades->tradesStatus === "pending"): ?>
                            <button type="submit" class="btn btn-sm btn-outline-danger rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 34px; height: 34px;" title="İptal Et" aria-label="İptal Et" name="tradesCancelled"><i class="bi bi-x-circle"></i></button>
                        <?php endif; ?>
                    </form>
                    <a href="<?php echo BASE_URL . "books/" . $trades->book_sender_slug . "/" . $trades->book_sender_id; ?>" class="btn btn-sm btn-outline-secondary rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 34px; height: 34px;" title="Detay" aria-label="Detay"><i class="bi bi-eye"></i></a>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<?php endif; ?>

<?php include_once __DIR__ . "/../partials/_pagination.php"; ?>