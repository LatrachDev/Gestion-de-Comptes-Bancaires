<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create New Client - Bank Admin</title>
    <script src="/assets/JavaScript/tailwind.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-gray-50">
    <?php require_once __DIR__ . '/../parts/sidebar.php'; ?>

    <div class="p-4 sm:ml-64">
        <div class="p-4">
            <!-- Header -->
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-800">Create New Client</h1>
                <a href="/admin/clients" class="flex items-center text-gray-600 hover:text-gray-800">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Back to Clients
                </a>
            </div>

            <?php if ($this->hasFlash('admin_create_client')): ?>
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
                    <p class="font-medium">Error:</p>
                    <?php $error = $this->getFlash('admin_create_client')['message']; ?>
                    <p><?php echo htmlspecialchars($error); ?></p>
                </div>
            <?php endif; ?>

            <!-- Client Creation Form -->
            <div class="max-w-4xl bg-white rounded-lg shadow-sm p-6 border border-gray-200">
                <form action="/admin/clients/create" method="POST" autocomplete="off" class="space-y-6">
                    <!-- Personal Information -->
                    <div class="space-y-4">
                        <h2 class="text-xl font-semibold text-gray-800 pb-2 border-b">Personal Information</h2>

                        <!-- Name Field -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-500">
                                    <i class="fas fa-user"></i>
                                </span>
                                <input type="text"
                                    id="name"
                                    name="name"
                                    required
                                    autocomplete="off"
                                    value="<?php echo htmlspecialchars($oldInput['name'] ?? ''); ?>"
                                    class="pl-10 w-full rounded-lg border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:ring-opacity-20 transition-colors text-gray-700 py-2.5">
                            </div>
                        </div>

                        <!-- Email Field -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-500">
                                    <i class="fas fa-envelope"></i>
                                </span>
                                <input type="email"
                                    id="email"
                                    name="email"
                                    required
                                    autocomplete="off"
                                    class="pl-10 w-full rounded-lg border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:ring-opacity-20 transition-colors text-gray-700 py-2.5">
                            </div>
                        </div>

                        <!-- Password Field -->
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-500">
                                    <i class="fas fa-lock"></i>
                                </span>
                                <input type="password"
                                    id="password"
                                    name="password"
                                    required
                                    autocomplete="new-password"
                                    class="pl-10 w-full rounded-lg border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:ring-opacity-20 transition-colors text-gray-700 py-2.5">
                            </div>
                        </div>
                    </div>

                    <!-- Bank Accounts Section -->
                    <div class="space-y-4 pt-6">
                        <h2 class="text-xl font-semibold text-gray-800 pb-2 border-b">Bank Accounts</h2>

                        <!-- Current Account -->
                        <div class="bg-gray-50 rounded-lg p-4 space-y-3">
                            <label class="inline-flex items-center space-x-3">
                                <input type="checkbox"
                                    name="create_current"
                                    id="create_current"
                                    class="form-checkbox h-5 w-5 text-blue-600 rounded border-gray-300 focus:ring-blue-500">
                                <span class="text-gray-700 font-medium">Current Account</span>
                            </label>

                            <div class="relative pl-8">
                                <label for="current_deposit" class="block text-sm font-medium text-gray-700 mb-1">Initial Deposit</label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-500">
                                        <i class="fas fa-dollar-sign"></i>
                                    </span>
                                    <input type="number"
                                        id="current_deposit"
                                        name="current_deposit"
                                        min="0"
                                        step="0.01"
                                        disabled
                                        class="pl-10 w-full rounded-lg border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:ring-opacity-20 transition-colors text-gray-700 py-2.5">
                                </div>
                            </div>
                        </div>

                        <!-- Savings Account -->
                        <div class="bg-gray-50 rounded-lg p-4 space-y-3">
                            <label class="inline-flex items-center space-x-3">
                                <input type="checkbox"
                                    name="create_savings"
                                    id="create_savings"
                                    class="form-checkbox h-5 w-5 text-blue-600 rounded border-gray-300 focus:ring-blue-500">
                                <span class="text-gray-700 font-medium">Savings Account</span>
                            </label>

                            <div class="relative pl-8">
                                <label for="savings_deposit" class="block text-sm font-medium text-gray-700 mb-1">Initial Deposit</label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-500">
                                        <i class="fas fa-dollar-sign"></i>
                                    </span>
                                    <input type="number"
                                        id="savings_deposit"
                                        name="savings_deposit"
                                        min="0"
                                        step="0.01"
                                        disabled
                                        class="pl-10 w-full rounded-lg border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:ring-opacity-20 transition-colors text-gray-700 py-2.5">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="flex justify-end space-x-3 pt-6 border-t">
                        <button type="reset" class="px-6 py-2.5 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors duration-200">
                            Clear Form
                        </button>
                        <button type="submit" class="px-6 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                            Create Client
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Toggle deposit input fields based on checkboxes
        document.getElementById('create_current').addEventListener('change', function() {
            document.getElementById('current_deposit').disabled = !this.checked;
        });

        document.getElementById('create_savings').addEventListener('change', function() {
            document.getElementById('savings_deposit').disabled = !this.checked;
        });

        // Clear form handler
        document.querySelector('button[type="reset"]').addEventListener('click', function() {
            document.getElementById('current_deposit').disabled = true;
            document.getElementById('savings_deposit').disabled = true;
        });
    </script>
</body>

</html>