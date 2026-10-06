        </main>
        <footer class="footer">
            <p>For support, contact: <?= e(SUPPORT_EMAIL) ?></p>
            <p class="copyright">&copy; <?= date('Y') ?> <?= e(SCHOOL_NAME) ?>. All rights reserved.</p>
        </footer>
    </div>

    <?php if (!empty($includeRazorpay)): ?>
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <?php endif; ?>

    <?php foreach ($scripts ?? [] as $script): ?>
    <script src="<?= e($script) ?>"></script>
    <?php endforeach; ?>
</body>
</html>
