</main>

<footer class="bg-light text-center py-3 mt-auto border-top"
    style="font-family: 'Inter', sans-serif; font-size: 0.9rem;">

    {if isset($session.user_id)}
        <div class="mb-2">
            <a href="index.php?action=addFeedback" class="btn btn-outline-primary btn-sm">
                <i class="bi bi-chat-dots-fill"></i> Dodaj feedback
            </a>
        </div>
    {/if}
    <p class="m-0 text-muted">
        &copy; {$smarty.now|date_format:"%Y"} Zarządzanie finansami rodzinnymi. Wszelkie prawa zastrzeżone.
    </p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>