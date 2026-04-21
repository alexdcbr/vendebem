<?php if (isset($_SESSION['cliente_id'])): ?>
    </div> <!-- content -->
</div> <!-- layout -->
<?php endif; ?>

<footer style="text-align:center; padding:15px; background:#f5f5f5;">
    <small>© <?= date('Y') ?> Sistema de Vendas</small>
</footer>

<script>
function toggleSidebar() {
    document.getElementById('sidebar').classList.toggle('collapsed');
}
</script>

</body>
</html>