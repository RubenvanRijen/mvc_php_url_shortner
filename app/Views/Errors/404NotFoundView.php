<!DOCTYPE html>
<html lang="en">
<?php include './app/Views/Components/head.php'; ?>

<body>
    <?php include './app/Views/Components/header.php'; ?>
    <section class="flex items-center justify-center h-screen p-16 ">
        <div class="container flex flex-col items-center ">
            <div class="flex flex-col gap-6 max-w-md text-center">
                <h2 class="font-extrabold text-black text-8xl">
                   404
                </h2>
                <p class="text-2xl md:text-3xl dark:text-gray-400">Sorry, we couldn't find this page.</p>
                <a href="/" class="px-8 py-4 text-xl font-semibold rounded bg-purple-600 text-gray-50 hover:text-gray-200">Back to homepage</a>
            </div>
        </div>
    </section>
    <?php include './app/Views/Components/footer.php'; ?>

</body>

<script defer type="module" src="/public/js/shortUrlForm.js"></script>

</html>