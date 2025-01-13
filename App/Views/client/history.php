<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ma Banque - Historique des transactions</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lucide/0.263.1/umd/lucide.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-100">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <?php require_once __DIR__ . '/parts/clientSidebar.php'; ?>

        <!-- Button to toggle sidebar on mobile -->
        <button class="md:hidden p-4 text-gray-600" id="toggleSidebar">
            <i data-lucide="menu"></i>
        </button>

        <!-- Main Content -->
        <div class="flex-1 p-4 md:p-8">
            <h2 class="text-2xl font-bold text-gray-800">Historique des transactions</h2>

          <!-- Liste des transactions -->
          <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Recent Transactions</h2>
                <div class="overflow-x-auto">
                    <?php
                    $allTransactions = [];
                    foreach ($transactions as $accountTransactions) {
                        $allTransactions = array_merge($allTransactions, $accountTransactions);
                    }
                    usort($allTransactions, function($a, $b) {
                        return strtotime($b['created_at']) - strtotime($a['created_at']);
                    });
                    ?>

                    <?php if (!empty($allTransactions)): ?>
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Account</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Type</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Amount</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Details</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <?php foreach ($allTransactions as $transaction): ?>
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            <?= date('M j, Y H:i', strtotime($transaction['created_at'])) ?>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 py-1 text-xs rounded-full <?= $transaction['source_account_type'] === 'savings' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' ?>">
                                                <?= ucfirst($transaction['source_account_type']) ?>
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <?php
                                            $icon = '';
                                            $color = '';
                                            switch ($transaction['transaction_type']) {
                                                case 'deposit':
                                                    $icon = 'fa-arrow-down';
                                                    $color = 'text-green-600';
                                                    break;
                                                case 'withdrawal':
                                                    $icon = 'fa-arrow-up';
                                                    $color = 'text-red-600';
                                                    break;
                                                case 'transfer':
                                                    $icon = 'fa-exchange-alt';
                                                    $color = 'text-blue-600';
                                                    break;
                                            }
                                            ?>
                                            <span class="inline-flex items-center">
                                                <i class="fas <?= $icon ?> mr-2 <?= $color ?>"></i>
                                                <span class="capitalize"><?= $transaction['transaction_type'] ?></span>
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="<?= $transaction['transaction_type'] === 'withdrawal' || ($transaction['transaction_type'] === 'transfer' && !$transaction['beneficiary_account_id']) ? 'text-red-600' : 'text-green-600' ?> font-medium">
                                                <?= $transaction['transaction_type'] === 'withdrawal' || ($transaction['transaction_type'] === 'transfer' && !$transaction['beneficiary_account_id']) ? '-' : '+' ?>
                                                <?= number_format($transaction['amount'], 2) ?> MAD
                                            </span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <?php if ($transaction['transaction_type'] === 'transfer'): ?>
                                                <?php if ($transaction['beneficiary_account_id']): ?>
                                                    <span class="text-sm text-gray-600">
                                                        To: <?= htmlspecialchars($transaction['beneficiary_name']) ?>'s
                                                        <?= $transaction['beneficiary_account_type'] ?> account
                                                    </span>
                                                <?php else: ?>
                                                    <span class="text-sm text-gray-600">
                                                        From: <?= htmlspecialchars($transaction['source_name']) ?>'s
                                                        <?= $transaction['source_account_type'] ?> account
                                                    </span>
                                                <?php endif; ?>
                                            <?php else: ?>
                                                <span class="text-sm text-gray-600">-</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <p class="text-center text-gray-500 py-8">No recent transactions found.</p>
                    <?php endif; ?>
                </div>
            </div>

    <script>
        // Toggle sidebar visibility on mobile
        const toggleButton = document.getElementById('toggleSidebar');
        const sidebar = document.querySelector('.w-64');

        toggleButton.addEventListener('click', () => {
            sidebar.classList.toggle('hidden');
        });

        lucide.createIcons();
    </script>
</body>
</html>
