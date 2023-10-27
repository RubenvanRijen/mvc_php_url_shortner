<!DOCTYPE html>
<html lang="en">
<?php include __DIR__ . '/Components/head.php'; ?>

<body>
    <?php include __DIR__ . '/Components/header.php'; ?>

    <div class="flex flex-col items-center justify-center h-screen">
        <!-- show the internal error on short url creation -->
        <?php if (isset($_SESSION['generate_error'])) : ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <strong class="font-bold">Error!</strong>
                <span class="block sm:inline"><?php echo $_SESSION['generate_error']; ?></span>
                <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                    <svg class="fill-current h-6 w-6 text-red-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <title>Close</title>
                        <path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z" />
                    </svg>
                </span>
            </div>
            <?php unset($_SESSION['generate_error']); // Clear the error message 
            ?>
        <?php endif; ?>
        <h1 class="text-8xl font-bold pb-20">URL Shortener</h1>
        <form id="createShortUrl" class="w-1/2 pb-20" action="/urls/create" method="post">
            <div class="flex justify-center">
            </div>
            <div class="mb-6">
                <label for="url" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">URL</label>
                <input type="text" id="url" name="url" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="https://urlshortner.com" required>
                <?php if (isset($_SESSION['url_error'])) : ?>
                    <div class="text-sm text-red-500 mt-3">
                        <?php echo $_SESSION['url_error']; ?>
                    </div>
                    <?php unset($_SESSION['url_error']); // Clear the error message 
                    ?>
                <?php endif; ?>
            </div>
            <div class="flex justify-end">
                <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    Submit
                </button>
            </div>
        </form>
        <div class="w-1/2 relative overflow-x-auto shadow-md sm:rounded-lg mb-5">
            <?php if ($data['newUrl'] != null) : ?>
                <h2 class="mb-4">Created Url: <a target="_blank" class="mb-4" href="<?php echo $data['baseUrl'] . '/short/' . $data['newUrl']; ?>">Short
                        Url</a>
                </h2>
            <?php endif; ?>

            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            ShortUrl
                        </th>
                        <th scope="col" class="px-6 py-3">
                            OriginalUrl
                        </th>
                        <th scope="col" class="px-6 py-3">
                            usedAmount
                        </th>
                        <th scope="col" class="px-6 py-3">
                            created on
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($data['urls'] as $url) {
                        echo '<tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">';
                        echo ' <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">';
                        echo $data['baseUrl'] . '/short/' . $url['short_url'];
                        echo '</th>';
                        echo ' <td class="px-6 py-4">';
                        echo $url['original_url'];
                        echo '</td>';
                        echo '<td class="px-6 py-4">';
                        echo $url['used_amount'];
                        echo '</td>';
                        echo ' <td class="px-6 py-4">';
                        echo $url['created_at'];
                        echo ' </td>';
                        echo '</tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <nav>
            <ul class="inline-flex -space-x-px text-base h-10">
                <li>
                    <?php if ($data['currentPage'] > 1) : ?>
                        <a href="/urls?page=<?= $data['currentPage'] - 1 ?>" class="flex items-center justify-center px-4 h-10 ml-0 leading-tight text-gray-500 bg-white border border-gray-300 rounded-l-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">Previous</a>
                    <?php else : ?>
                        <span class="flex items-center justify-center px-4 h-10 ml-0 leading-tight text-gray-500 bg-white border border-gray-300 rounded-l-lg">Previous</span>
                    <?php endif; ?>
                </li>

                <?php
                // Pagination links
                for ($i = 1; $i <= $data['totalPages']; $i++) {
                    $active = ($data['currentPage'] == $i) ? 'active' : '';
                    echo '<li>';
                    echo '<a href="/urls?page=' . $i . '" class="flex items-center justify-center px-4 h-10 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white pagination-link ' . $active . '">' . $i . '</a>';
                    echo '</li>';
                }
                ?>

                <li>
                    <?php if ($data['currentPage'] < $data['totalPages']) : ?>
                        <a href="/urls?page=<?= $data['currentPage'] + 1 ?>" class="flex items-center justify-center px-4 h-10 leading-tight text-gray-500 bg-white border border-gray-300 rounded-r-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">Next</a>
                    <?php else : ?>
                        <span class="flex items-center justify-center px-4 h-10 leading-tight text-gray-500 bg-white border border-gray-300 rounded-r-lg">Next</span>
                    <?php endif; ?>
                </li>
            </ul>
        </nav>

    </div>
    <?php include __DIR__ . '/Components/footer.php'; ?>

</body>

<script defer type="module" src="/public/js/shortUrlForm.js"></script>

</html>