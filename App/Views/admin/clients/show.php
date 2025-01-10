
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client Details - Bank Admin</title>
    <script src="/assets/JavaScript/tailwind.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50">
    <?php require_once __DIR__ . '/../parts/sidebar.php'; ?>

    <div class="p-4 sm:ml-64">
        <div class="p-4">
            <!-- Header -->
            <div class="flex justify-between items-center mb-6">
                <div class="flex items-center">
                    <a href="/admin/clients" class="text-gray-600 hover:text-gray-800 mr-4">
                        <i class="fas fa-arrow-left"></i>
                    </a>
                    <div>
                        <h1 class="text-2xl font-bold text-gray-800">Client Profile</h1>
                        <p class="text-sm text-gray-500">Manage client information and accounts</p>
                    </div>
                </div>
                <div class="flex space-x-3">
                    <?php if ($client->isActive()): ?>
                        <form action="/admin/clients/<?= $client->getId() ?>/suspend" method="POST" class="inline">
                            <button type="submit" class="flex items-center text-red-600 hover:text-red-800">
                                <i class="fas fa-ban mr-2"></i>
                                Suspend Client
                            </button>
                        </form>
                    <?php else: ?>
                        <form action="/admin/clients/<?= $client->getId() ?>/activate" method="POST" class="inline">
                            <button type="submit" class="flex items-center text-green-600 hover:text-green-800">
                                <i class="fas fa-check-circle mr-2"></i>
                                Activate Client
                            </button>
                        </form>
                    <?php endif; ?>
                </div>
            </div>

            <?php if ($this->hasFlash('admin_show_client')): ?>
                <?php $flash = $this->getFlash('admin_show_client'); ?>
                <div class="mb-6 p-4 rounded-lg <?= $flash['type'] === 'success' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' ?>">
                    <?= $flash['message'] ?>
                </div>
            <?php endif; ?>

            <!-- Client Information Card -->
            <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="h-16 w-16 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 text-2xl font-bold">
                            <?= strtoupper(substr($client->getName(), 0, 1)) ?>
                        </div>
                        <div class="ml-4">
                            <div class="flex items-center space-x-3">
                                <h2 class="text-xl font-semibold text-gray-800"><?= htmlspecialchars($client->getName()) ?></h2>
                                <span class="px-2 py-1 text-xs rounded-full <?= $client->isActive() ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' ?>">
                                    <?= ucfirst($client->getStatus()) ?>
                                </span>
                            </div>
                            <p class="text-gray-500"><?= htmlspecialchars($client->getEmail()) ?></p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-sm text-gray-500">Member Since</p>
                        <p class="text-gray-800"><?= date('F j, Y', strtotime($client->getCreatedAt())) ?></p>
                    </div>
                </div>
            </div>

            <!-- Bank Accounts Section -->
            <div class="mb-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-lg font-semibold text-gray-800">Bank Accounts</h2>
                    <?php if (count($accounts) < 2): ?>
                    <button onclick="showAddAccountModal()" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                        <i class="fas fa-plus mr-2"></i>Add Account
                    </button>
                    <?php endif; ?>
                </div>

                <?php if (empty($accounts)): ?>
                    <div class="text-center py-12 bg-white rounded-lg border border-gray-200">
                        <i class="fas fa-credit-card text-4xl text-gray-400 mb-3"></i>
                        <h3 class="text-lg font-medium text-gray-900">No Accounts Yet</h3>
                        <p class="text-gray-500 mb-4">This client doesn't have any bank accounts.</p>
                        <button class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
                            <i class="fas fa-plus mr-2"></i>Create First Account
                        </button>
                    </div>
                <?php else: ?>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <?php foreach ($accounts as $account): ?>
                            <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
                                <div class="flex justify-between items-start mb-4">
                                    <div>
                                        <span class="px-2 py-1 text-xs rounded-full <?= $account->getAccountType() === 'savings' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' ?>">
                                            <?= ucfirst($account->getAccountType()) ?> Account
                                        </span>
                                        <span class="ml-2 px-2 py-1 text-xs rounded-full <?= $account->isActive() ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' ?>">
                                            <?= ucfirst($account->getStatus()) ?>
                                        </span>
                                        <h3 class="text-2xl font-bold text-gray-800 mt-2">
                                            $<?= number_format($account->getBalance(), 2) ?>
                                        </h3>
                                    </div>
                                    <div class="flex space-x-2">
                                        <?php if ($account->isActive()): ?>
                                            <form action="/admin/clients/<?= $client->getId() ?>/accounts/<?= $account->getId() ?>/suspend" method="POST" class="inline">
                                                <button type="submit" class="text-red-600 hover:text-red-800">
                                                    <i class="fas fa-ban mr-1"></i> Suspend
                                                </button>
                                            </form>
                                        <?php else: ?>
                                            <form action="/admin/clients/<?= $client->getId() ?>/accounts/<?= $account->getId() ?>/activate" method="POST" class="inline">
                                                <button type="submit" class="text-green-600 hover:text-green-800">
                                                    <i class="fas fa-check-circle mr-1"></i> Activate
                                                </button>
                                            </form>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="space-y-2 text-sm text-gray-500 mb-4">
                                    <p><i class="fas fa-calendar-alt w-5"></i> Created: <?= date('M d, Y', strtotime($account->getCreatedAt())) ?></p>
                                    <p><i class="fas fa-clock w-5"></i> Last Updated: <?= date('M d, Y H:i', strtotime($account->getUpdatedAt())) ?></p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Add Account Modal -->
            <div id="addAccountModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full">
                <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
                    <div class="mt-3">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Add New Account</h3>
                        <form action="/admin/clients/<?= $client->getId() ?>/accounts/create" method="POST">
                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2">Account Type</label>
                                <select name="account_type" class="shadow border rounded w-full py-2 px-3 text-gray-700" required>
                                    <?php
                                    $hasCurrentAccount = false;
                                    $hasSavingsAccount = false;
                                    foreach ($accounts as $acc) {
                                        if ($acc->getAccountType() === 'current') $hasCurrentAccount = true;
                                        if ($acc->getAccountType() === 'savings') $hasSavingsAccount = true;
                                    }
                                    if (!$hasCurrentAccount): ?>
                                        <option value="current">Current Account</option>
                                    <?php endif; ?>
                                    <?php if (!$hasSavingsAccount): ?>
                                        <option value="savings">Savings Account</option>
                                    <?php endif; ?>
                                </select>
                            </div>
                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2">Initial Deposit</label>
                                <input type="number" name="deposit" step="0.01" min="0" class="shadow border rounded w-full py-2 px-3 text-gray-700" required>
                            </div>
                            <div class="flex justify-end space-x-3">
                                <button type="button" onclick="hideAddAccountModal()" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300">Cancel</button>
                                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Create Account</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Recent Transactions -->
            <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Recent Transactions</h2>
                <div class="overflow-x-auto">
                    <?php
                    $allTransactions = [];
                    foreach ($transactions as $accountTransactions) {
                        $allTransactions = array_merge($allTransactions, $accountTransactions);
                    }
                    
                    // Sort transactions by date, newest first
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
            
        </div>
    </div>
    <script>
        function showAddAccountModal() {
            document.getElementById('addAccountModal').classList.remove('hidden');
        }

        function hideAddAccountModal() {
            document.getElementById('addAccountModal').classList.add('hidden');
        }
    </script>
</body>
</html>