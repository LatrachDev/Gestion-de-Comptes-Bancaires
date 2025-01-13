<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bank Admin - Dashboard</title>
    <script src="/assets/JavaScript/tailwind.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-gray-50">
    <?php require_once __DIR__ . '/parts/sidebar.php'; ?>

    <div class="p-4 sm:ml-64">
        <div class="p-4">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-800">Dashboard Overview</h1>
                <div class="flex items-center space-x-4">
                    <span class="text-sm text-gray-500"><?= date('l, F j, Y') ?></span>
                    <button class="inline-flex items-center px-4 py-2 bg-gray-800 hover:bg-gray-700 text-white text-sm font-medium rounded-lg transition-colors duration-150 shadow-sm">
                        <i class="fas fa-download mr-2"></i>Export Report
                    </button>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
                <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-100 hover:shadow-md transition-shadow">
                    <div class="flex items-center">
                        <div class="p-3 rounded-lg bg-blue-100 text-blue-600 mr-4">
                            <i class="fas fa-users text-xl"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Total Clients</p>
                            <h3 class="text-2xl font-bold text-gray-800"><?= $totalClients - 1 ?></h3>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-100 hover:shadow-md transition-shadow">
                    <div class="flex items-center">
                        <div class="p-3 rounded-lg bg-green-100 text-green-600 mr-4">
                            <i class="fas fa-money-bill-wave text-xl"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Total Deposits</p>
                            <h3 class="text-2xl font-bold text-gray-800">MAD<?= number_format($totalBalance, 2) ?></h3>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-100 hover:shadow-md transition-shadow">
                    <div class="flex items-center">
                        <div class="p-3 rounded-lg bg-purple-100 text-purple-600 mr-4">
                            <i class="fas fa-credit-card text-xl"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Total Accounts</p>
                            <h3 class="text-2xl font-bold text-gray-800"><?= $totalAccounts ?></h3>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-100 hover:shadow-md transition-shadow">
                    <div class="flex items-center">
                        <div class="p-3 rounded-lg bg-orange-100 text-orange-600 mr-4">
                            <i class="fas fa-exchange-alt text-xl"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Total Transactions</p>
                            <h3 class="text-2xl font-bold text-gray-800"><?= $totalTransactions ?></h3>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex flex-col gap-6">
                <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-100">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-lg font-semibold text-gray-800">Transaction Filters</h2>
                        <button onclick="fetchTransactions()"
                            class="inline-flex items-center px-6 py-2.5 bg-gray-800 hover:bg-gray-700 text-white text-sm font-medium rounded-lg transition-all duration-150 shadow-sm hover:shadow-md">
                            <i class="fas fa-filter mr-2 opacity-75"></i>
                            Apply Filters
                        </button>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-exchange-alt text-gray-400 mr-2"></i>
                                    Transaction Type
                                </label>
                                <select id="type" class="w-full px-3 py-2 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                                    <option value="">All Types</option>
                                    <option value="deposit">Deposit</option>
                                    <option value="withdrawal">Withdrawal</option>
                                    <option value="transfer">Transfer</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-credit-card text-gray-400 mr-2"></i>
                                    Account Type
                                </label>
                                <select id="accountType" class="w-full px-3 py-2 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                                    <option value="">All Accounts</option>
                                    <option value="current">Current Account</option>
                                    <option value="savings">Savings Account</option>
                                </select>
                            </div>
                        </div>

                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="far fa-calendar-alt text-gray-400 mr-2"></i>
                                    Date Start
                                </label>
                                <div class="flex flex-col space-y-3">
                                    <div class="relative">
                                        <div class="relative">
                                            <input type="date" id="startDateTime"
                                                class="w-full pl-10 pr-3 py-2 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                                            <i class="far fa-calendar text-gray-400 absolute left-3 top-1/2 -translate-y-1/2"></i>
                                        </div>
                                    </div>
                                    <div class="relative">
                                        <label class="block text-sm font-medium text-gray-700 mb-2">
                                            <i class="far fa-calendar-alt text-gray-400 mr-2"></i>
                                            Date End
                                        </label>
                                        <div class="relative flex items-center">
                                            <div class="absolute left-0 h-full flex items-center pl-3">
                                                <div class="h-4 w-0.5 bg-gray-200"></div>
                                            </div>
                                            <input type="date" id="endDateTime"
                                                class="w-full pl-10 pr-3 py-2 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                                            <i class="far fa-calendar text-gray-400 absolute left-3 top-1/2 -translate-y-1/2"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-coins text-gray-400 mr-2"></i>
                                    Amount Range (MAD)
                                </label>
                                <div class="grid grid-cols-2 gap-2">
                                    <div class="relative">
                                        <input type="number" id="amountStart" placeholder="Min"
                                            class="w-full px-3 py-2 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                                    </div>
                                    <div class="relative">
                                        <input type="number" id="amountEnd" placeholder="Max"
                                            class="w-full px-3 py-2 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                                    </div>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-user text-gray-400 mr-2"></i>
                                    User Name
                                </label>
                                <input type="text" id="userName" placeholder="Search by name..."
                                    class="w-full px-3 py-2 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                            </div>
                        </div>
                    </div>
                </div>
                <div id="transactionsContainer" class="bg-white w-full rounded-lg shadow-sm">
                    <div class="flex justify-between items-center p-6 border-b">
                        <h2 class="text-lg font-semibold text-gray-800">Transaction Overview</h2>
                        <div class="animate-spin text-gray-400 hidden" id="loadingSpinner">
                            <i class="fas fa-circle-notch fa-spin"></i>
                        </div>
                    </div>
                    <div id="transactionsContent"></div>
                </div>
                <script>
                    document.addEventListener('DOMContentLoaded', () => fetchTransactions());

                    async function fetchTransactions() {

                        try {
                            const filters = {
                                startDate: document.getElementById('startDateTime').value,
                                endDate: document.getElementById('endDateTime').value,
                                type: document.getElementById('type').value,
                                userName: document.getElementById('userName').value,
                                amountStart: document.getElementById('amountStart').value,
                                amountEnd: document.getElementById('amountEnd').value,
                                accountType: document.getElementById('accountType').value
                            };

                            let queryParams = [];
                            for (let key in filters) {
                                if (filters[key]) {
                                    queryParams.push(key + '=' + encodeURIComponent(filters[key]));
                                }
                            }

                            const queryString = queryParams.join('&');
                            const url = '/admin/transactions/search' + (queryString ? '?' + queryString : '');
                            const response = await fetch(url);

                            if (!response.ok) {
                                updateTransactionDisplay({
                                    error: 'Failed to fetch'
                                });
                                return;
                            }

                            const data = await response.json();
                            if (!data) {
                                updateTransactionDisplay({
                                    data: []
                                });
                                return;
                            }
                            updateTransactionDisplay(data);

                        } catch (error) {
                            updateTransactionDisplay({
                                error: 'Fetch error'
                            });
                        }
                    }

                    function updateTransactionDisplay(result) {
                        const container = document.getElementById('transactionsContent');
                        container.innerHTML = '';

                        if (result.error) {
                            showError(result.error);
                            return;
                        }

                        const transactions = result.data || [];
                        if (transactions.length === 0) {
                            container.innerHTML = '<p class="text-center text-gray-500 py-8">No transactions found.</p>';
                            return;
                        }

                        renderTransactions(transactions);
                    }

                    function renderTransactions(transactions) {
                        const container = document.getElementById('transactionsContent');
                        if (!transactions.length) {
                            container.innerHTML = '<p class="text-center text-gray-500 py-8">No transactions found.</p>';
                            return;
                        }

                        const tableHTML = `
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Account</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Type</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Amount</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Details</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">By</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    ${transactions.map(t => `
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                ${new Date(t.created_at).toLocaleString()}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 py-1 text-xs rounded-full ${t.source_account_type === 'savings' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800'}">
                                                    ${t.source_account_type.charAt(0).toUpperCase() + t.source_account_type.slice(1)}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="inline-flex items-center">
                                                    <i class="fas ${getTransactionIcon(t.transaction_type)} mr-2 ${getTransactionColor(t.transaction_type)}"></i>
                                                    <span class="capitalize">${t.transaction_type}</span>
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="${getAmountColor(t)}">
                                                    ${getAmountPrefix(t)}${Number(t.amount).toFixed(2)} MAD
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                ${getTransactionDetails(t)}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                ${t.source_name || 'N/A'}
                                            </td>
                                        </tr>
                                    `).join('')}
                                </tbody>
                            </table>
                        `;
                        container.innerHTML = tableHTML;
                    }

                    function getTransactionIcon(type) {
                        switch (type) {
                            case 'deposit':
                                return 'fa-arrow-down';
                            case 'withdrawal':
                                return 'fa-arrow-up';
                            case 'transfer':
                                return 'fa-exchange-alt';
                            default:
                                return '';
                        }
                    }

                    function getTransactionColor(type) {
                        switch (type) {
                            case 'deposit':
                                return 'text-green-600';
                            case 'withdrawal':
                                return 'text-red-600';
                            case 'transfer':
                                return 'text-blue-600';
                            default:
                                return '';
                        }
                    }

                    function getAmountColor(transaction) {
                        return transaction.transaction_type === 'withdrawal' || (transaction.transaction_type === 'transfer' && !transaction.beneficiary_account_id) ? 'text-red-600' : 'text-green-600';
                    }

                    function getAmountPrefix(transaction) {
                        return transaction.transaction_type === 'withdrawal' || (transaction.transaction_type === 'transfer' && !transaction.beneficiary_account_id) ? '-' : '+';
                    }

                    function getTransactionDetails(transaction) {
                        if (transaction.transaction_type === 'transfer') {
                            if (transaction.beneficiary_account_id) {
                                return `To: ${transaction.beneficiary_name}'s ${transaction.beneficiary_account_type} account`;
                            } else {
                                return `From: ${transaction.source_name}'s ${transaction.source_account_type} account`;
                            }
                        } else {
                            return '-';
                        }
                    }

                    function showError(message) {
                        const container = document.getElementById('transactionsContent');
                        container.innerHTML = `
                            <div class="text-center p-6">
                                <div class="text-red-600 mb-2">
                                    <i class="fas fa-exclamation-circle text-3xl"></i>
                                </div>
                                <p class="text-gray-500">${message}</p>
                            </div>
                        `;
                    }
                </script>
            </div>
        </div>
    </div>
</body>

</html>