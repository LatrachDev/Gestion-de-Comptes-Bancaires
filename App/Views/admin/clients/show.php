
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
                    <button onclick="return confirm('Are you sure you want to delete this client?')" class="flex items-center text-red-600 hover:text-red-800">
                        <i class="fas fa-trash mr-2"></i>
                        Delete Client
                    </button>
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
                            <h2 class="text-xl font-semibold text-gray-800"><?= htmlspecialchars($client->getName()) ?></h2>
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
                    <button class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
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
                                        <h3 class="text-2xl font-bold text-gray-800 mt-2">
                                            $<?= number_format($account->getBalance(), 2) ?>
                                        </h3>
                                    </div>
                                    <div class="flex space-x-2">
                                        <button class="p-2 text-blue-600 hover:text-blue-800" title="Manage Account">
                                            <i class="fas fa-cog"></i>
                                        </button>
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

            <!-- Recent Transactions -->
            <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Recent Transactions</h2>
                <div class="overflow-x-auto">
                    <!-- Transaction table or empty state will go here -->
                    <p class="text-center text-gray-500 py-8">No recent transactions found.</p>
                </div>
            </div>
            
        </div>
    </div>
</body>
</html>