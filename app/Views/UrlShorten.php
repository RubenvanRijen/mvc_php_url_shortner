<!DOCTYPE html>
<html lang="en">
<?php include __DIR__ . '/Components/head.php'; ?>
<body>
<?php include __DIR__ . '/Components/header.php'; ?>

<div class="flex flex-col items-center justify-center h-screen">
    <h1 class="text-8xl font-bold pb-20">URL Shortener</h1>
    <form class="w-1/2 pb-20" action="" method="post">
        <div class="flex justify-center">
        </div>
        <div class="mb-6">
            <label for="url" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">URL</label>
            <input type="text" id="url" name="url"
                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                   placeholder="https://urlshortner.com" required>
        </div>
        <div class="flex justify-end">
            <button type="submit"
                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                Submit
            </button>
        </div>
    </form>
    <div class="w-1/2 relative overflow-x-auto shadow-md sm:rounded-lg mb-5">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">
                    Product name
                </th>
                <th scope="col" class="px-6 py-3">
                    Color
                </th>
                <th scope="col" class="px-6 py-3">
                    Category
                </th>
                <th scope="col" class="px-6 py-3">
                    Price
                </th>
            </tr>
            </thead>
            <tbody>
            <?php
            foreach ($data['urls'] as $url) {
                echo '<tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">';
                echo ' <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">';
                echo $url['original_url'];
                echo '</th>';
                echo ' <td class="px-6 py-4">';
                echo $url['original_url'];
                echo '</td>';
                echo '<td class="px-6 py-4">';
                echo $url['original_url'];
                echo '</td>';
                echo ' <td class="px-6 py-4">';
                echo $url['original_url'];
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
                    <a href="/url?page=<?= $data['currentPage'] - 1 ?>"
                       class="flex items-center justify-center px-4 h-10 ml-0 leading-tight text-gray-500 bg-white border border-gray-300 rounded-l-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">Previous</a>
                <?php else : ?>
                    <span
                        class="flex items-center justify-center px-4 h-10 ml-0 leading-tight text-gray-500 bg-white border border-gray-300 rounded-l-lg">Previous</span>
                <?php endif; ?>
            </li>

            <?php
            // Pagination links
            for ($i = 1; $i <= $data['totalPages']; $i++) {
                $active = ($data['currentPage'] == $i) ? 'active' : '';
                echo '<li>';
                echo '<a href="/url?page=' . $i . '" class="flex items-center justify-center px-4 h-10 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white pagination-link ' . $active . '">' . $i . '</a>';
                echo '</li>';
            }
            ?>

            <li>
                <?php if ($data['currentPage'] < $data['totalPages']) : ?>
                    <a href="/url?page=<?= $data['currentPage'] + 1 ?>"
                       class="flex items-center justify-center px-4 h-10 leading-tight text-gray-500 bg-white border border-gray-300 rounded-r-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">Next</a>
                <?php else : ?>
                    <span
                        class="flex items-center justify-center px-4 h-10 leading-tight text-gray-500 bg-white border border-gray-300 rounded-r-lg">Next</span>
                <?php endif; ?>
            </li>
        </ul>
    </nav>

</div>
<?php include __DIR__ . '/Components/footer.php'; ?>

</body>
<script defer type="module" src="/public/js/index.js"></script>
</html>