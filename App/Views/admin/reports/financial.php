<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Financial Report - Bank Admin</title>
    <script src="/assets/JavaScript/tailwind.js"></script>
    <style>
        @media print {
            body * {
                visibility: visible;
            }
            #sidebar, .no-print {
                display: none;
            }
            .print-only {
                display: block;
            }
            .print-break-inside {
                break-inside: avoid;
            }
            @page {
                size: landscape;
                margin: 2cm;
            }
        }
    </style>
</head>
<body class="bg-gray-50">
    <?php require_once __DIR__ . '/../../admin/parts/sidebar.php'; ?>

    <div class="p-4 sm:ml-64">
        <div class="p-4">
            <!-- Report Header -->
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">Financial Report</h1>
                    <p class="text-sm text-gray-500">Generated on: <?= date('F j, Y, g:i a', strtotime($generated_at)) ?></p>
                </div>
                <button onclick="window.print()" class="no-print inline-flex items-center px-4 py-2 bg-gray-800 text-white rounded-lg hover:bg-gray-700">
                    <i class="fas fa-print mr-2"></i> Print Report
                </button>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8 print-break-inside">
                <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Total Deposits</h3>
                    <p class="text-2xl font-bold text-green-600">MAD <?= number_format($total_deposits, 2) ?></p>
                </div>
                
                <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Total Withdrawals</h3>
                    <p class="text-2xl font-bold text-red-600">MAD <?= number_format($total_withdrawals, 2) ?></p>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Total Transfers</h3>
                    <p class="text-2xl font-bold text-blue-600">MAD <?= number_format($total_transfers, 2) ?></p>
                </div>
            </div>

            <!-- Account Summary -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-8 print-break-inside">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Account Summary</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full">
                            <thead>
                                <tr class="bg-gray-50">
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Account Type</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total Accounts</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total Balance</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                <?php foreach ($accounts_summary as $summary): ?>
                                <tr>
                                    <td class="px-6 py-4 text-sm text-gray-900"><?= ucfirst($summary['account_type']) ?></td>
                                    <td class="px-6 py-4 text-sm text-gray-900"><?= $summary['count'] ?></td>
                                    <td class="px-6 py-4 text-sm text-gray-900">MAD <?= number_format($summary['total_balance'], 2) ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- All Transactions -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 print-break-inside">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">All Transactions</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full">
                            <thead>
                                <tr class="bg-gray-50">
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Client</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Type</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Amount</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Account Type</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Details</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                <?php foreach ($transactions as $t): ?>
                                    <tr>
                                        <td class="px-6 py-4 text-sm text-gray-900">
                                            <?= date('M j, Y H:i', strtotime($t['created_at'])) ?>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-900"><?= htmlspecialchars($t['client_name']) ?></td>
                                        <td class="px-6 py-4 text-sm text-gray-900">
                                            <span class="px-2 py-1 rounded-full text-xs 
                                                <?= match($t['transaction_type']) {
                                                    'deposit' => 'bg-green-100 text-green-800',
                                                    'withdrawal' => 'bg-red-100 text-red-800',
                                                    'transfer' => 'bg-blue-100 text-blue-800'
                                                } ?>">
                                                <?= ucfirst($t['transaction_type']) ?>
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-sm <?= $t['transaction_type'] === 'withdrawal' ? 'text-red-600' : 'text-green-600' ?>">
                                            MAD <?= number_format($t['amount'], 2) ?>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-900"><?= ucfirst($t['account_type']) ?></td>
                                        <td class="px-6 py-4 text-sm text-gray-900">
                                            <?php if ($t['transaction_type'] === 'transfer' && $t['beneficiary_name']): ?>
                                                To: <?= htmlspecialchars($t['beneficiary_name']) ?>
                                            <?php else: ?>
                                                -
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Print Footer -->
            <div class="mt-8 text-center text-sm text-gray-500 print-only" style="display: none;">
                <p>Bank Name - Financial Report</p>
                <p>Generated on <?= date('F j, Y, g:i a', strtotime($generated_at)) ?></p>
            </div>
        </div>
    </div>
</body>
</html>
