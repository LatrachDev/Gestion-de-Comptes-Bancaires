<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Bank - Dashboard</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lucide/0.263.1/umd/lucide.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-100">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <?php
        use Core\Auth;
        require_once __DIR__ . '/parts/clientSidebar.php'; 
        ?>

        <!-- Toggle Button for Mobile -->
        <button class="md:hidden p-4 text-gray-600 hover:text-blue-600 fixed top-0 left-0 z-50" id="toggleSidebar">
            <i data-lucide="menu" class="w-6 h-6"></i>
        </button>

        <!-- Main Content -->
        <div class="flex-1 p-4 md:p-8">
            <!-- Header -->
            <div class="flex justify-between items-center mb-8">
                <h2 class="text-2xl font-bold text-gray-800">
                    Hello <?= isset($auth['user']) ? $auth['user']->getName() : 'Guest' ?>
                </h2>
                <div class="flex items-center space-x-4">
                    <button class="p-2 text-gray-600 hover:text-blue-600" id="toggleSidebarDesktop">
                        <i data-lucide="menu" class="w-6 h-6"></i>
                    </button>
                    <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center text-white font-bold">
                        <?= isset($auth['user']) ? substr($auth['user']->getName(), 0, 2) : 'G' ?>
                    </div>
                </div>
            </div>

            <!-- Account Summary Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <?php foreach($account as $acc) : ?>
                    <div class="bg-white p-6 rounded-lg shadow-lg hover:shadow-xl transition-shadow duration-300">
                        <div class="flex items-center space-x-4">
                            <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                            <i class="fas <?= $acc->getAccountType() == 'current' ? 'fa-wallet' : 'fa-piggy-bank' ?> w-6 h-6 text-blue-600"></i>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-700">
                                    <?= ucfirst($acc->getAccountType()) ?> Account
                                </h3>
                                <p class="text-3xl font-bold text-gray-900 mt-2">
                                    <?= $acc->getBalance(); ?> $
                                </p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Quick Actions -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-8">
                <a href="/transfer" class="flex items-center justify-center space-x-2 p-6 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-300" onclick="openPopup('newTransferPopup')">
                    <i data-lucide="send" class="w-6 h-6"></i>
                    <span class="text-lg">New Transfer</span>
                </a>
                <a href="/compte" class="flex items-center justify-center space-x-2 p-6 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors duration-300" onclick="openPopup('fundAccountPopup')">
                    <i data-lucide="plus-circle" class="w-6 h-6"></i>
                    <span class="text-lg">Fund Account</span>
                </a>
            </div>

            
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            lucide.createIcons();
            const toggleButton = document.getElementById('toggleSidebar');
            const toggleButtonDesktop = document.getElementById('toggleSidebarDesktop');
            const sidebar = document.getElementById('sidebar');

            toggleButton.addEventListener('click', () => {
                sidebar.classList.toggle('hidden');
            });

            toggleButtonDesktop.addEventListener('click', () => {
                sidebar.classList.toggle('hidden');
            });
        });

    </script>
</body>
</html>