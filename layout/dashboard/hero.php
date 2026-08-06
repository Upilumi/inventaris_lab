<div class="card border-0 shadow-sm mb-4 dashboard-hero">
    <div class="card-body">

        <div class="row align-items-center">

            <div class="col-md-8">
                <h3 class="fw-bold mb-2">
                    👋 Selamat Datang,
                    <?= $_SESSION['nama'] ?? 'Administrator'; ?>
                </h3>

                <p class="text-muted mb-0">
                    Sistem Inventaris Laboratorium
                </p>

                <small class="text-secondary">
                    SMK NU Mojoagung
                </small>
            </div>

            <div class="col-md-4 text-md-end mt-3 mt-md-0">

                <h5 class="mb-1">
                    <?= date('d F Y'); ?>
                </h5>

                <small class="text-muted">
                    <?= date('l'); ?>
                </small>

            </div>

        </div>

    </div>
</div>