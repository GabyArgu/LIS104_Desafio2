<!--Toast de Mensajes-->
<button type="button" class="d-none" id="toastBtn"></button>

<div class="toast-container position-fixed top-0 end-0 p-3">
    <div id="toast"
        class="toast align-items-center <?= $_SESSION['result']['status'] ? 'text-bg-success' : 'text-bg-danger' ?> border-0"
        role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body">
                <?php echo htmlspecialchars($_SESSION['result']['mensaje']); ?>
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                aria-label="Close"></button>
        </div>
    </div>
</div>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>


<?php if (isset($_SESSION['result'])): ?>
    <script>
        const toastTrigger = document.getElementById('toastBtn')
        const toast = document.getElementById('toast')

        if (toastTrigger) {
            const toastBootstrap = bootstrap.Toast.getOrCreateInstance(toast)
            toastTrigger.addEventListener('click', () => {
                toastBootstrap.show()
            })
        }

        toastTrigger.click();
    </script>
    <?php unset($_SESSION['result']); ?>
<?php endif; ?>