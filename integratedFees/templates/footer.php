        </main>
        <footer class="footer">
            <p>For support, contact: <?= e(SUPPORT_EMAIL) ?> | <?= e(SUPPORT_PHONE) ?></p>
            <p class="copyright">&copy; <?= date('Y') ?> <?= e(SCHOOL_NAME) ?>. All rights reserved.</p>
        </footer>
    </div>

    <?php if (isset($includeRazorpay) && $includeRazorpay): ?>
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <?php endif; ?>

    <?php if (isset($scripts)): ?>
        <?php foreach ($scripts as $script): ?>
        <script src="<?= e($script) ?>"></script>
        <?php endforeach; ?>
    <?php endif; ?>
</body>
</html>
