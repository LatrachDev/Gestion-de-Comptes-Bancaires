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
            <!-- Header -->
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-800">Dashboard Overview</h1>
                <div class="flex items-center space-x-4">
                    <span class="text-sm text-gray-500"><?= date('l, F j, Y') ?></span>
                    <button class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                        <i class="fas fa-download mr-2"></i>Export Report
                    </button>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
                <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-100 hover:shadow-md transition-shadow">
                    <div class="flex items-center">
                        <div class="p-3 rounded-lg bg-blue-100 text-blue-600 mr-4">
                            <i class="fas fa-users text-xl"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Total Clients</p>
                            <h3 class="text-2xl font-bold text-gray-800">0</h3>
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
                            <h3 class="text-2xl font-bold text-gray-800">$0</h3>
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
                            <h3 class="text-2xl font-bold text-gray-800">0</h3>
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
                            <h3 class="text-2xl font-bold text-gray-800">0</h3>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Activity & Charts Section -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Recent Activity -->
                <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-100">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-lg font-semibold text-gray-800">Recent Activity</h2>
                        <button class="text-blue-600 hover:text-blue-700 text-sm">View All</button>
                    </div>
                    <div class="space-y-4">
                        <!-- Activity Items -->
                        <div class="flex items-center p-3 hover:bg-gray-50 rounded-lg transition-colors">
                            <div class="p-2 rounded-lg bg-blue-100 text-blue-600 mr-3">
                                <i class="fas fa-user-plus"></i>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-800">New client account created</p>
                                <p class="text-xs text-gray-500">2 minutes ago</p>
                            </div>
                        </div>
                        <!-- Add more activity items here -->
                    </div>
                </div>

                <!-- Chart Section -->
                <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-100">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-lg font-semibold text-gray-800">Transaction Overview</h2>
                        <select class="text-sm border rounded-lg px-2 py-1">
                            <option>Last 7 days</option>
                            <option>Last 30 days</option>
                            <option>Last 90 days</option>
                        </select>
                    </div>
                    <div class="h-64 flex items-center justify-center text-gray-500">
                        <!-- Add your chart here -->
                        <p>Chart Placeholder</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
