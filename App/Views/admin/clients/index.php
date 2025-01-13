<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clients List - Bank Admin</title>
    <script src="/assets/JavaScript/tailwind.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-gray-50">
    <?php require_once __DIR__ . '/../parts/sidebar.php'; ?>

    <div class="p-4 sm:ml-64">
        <div class="p-4">
            <!-- Header -->
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-800">Manage Clients</h1>
                <a href="/admin/clients/create" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                    <i class="fas fa-plus mr-2"></i>New Client
                </a>
            </div>

            <?php if ($this->hasFlash('admin_create_client')): ?>
                <?php $flash = $this->getFlash('admin_create_client'); ?>
                <div class="mb-4 p-4 rounded-lg <?= $flash['type'] === 'success' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' ?>">
                    <?= $flash['message'] ?>
                </div>
            <?php endif; ?>
            <?php if ($this->hasFlash('admin_show_client')): ?>
                <?php $flash = $this->getFlash('admin_show_client'); ?>
                <div class="mb-4 p-4 rounded-lg <?= $flash['type'] === 'success' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' ?>">
                    <?= $flash['message'] ?>
                </div>
            <?php endif; ?>

            <!-- Search Bar -->
            <div class="mb-6">
                <div class="relative">
                    <input type="text"
                        id="searchClient"
                        placeholder="Search clients by name or email..."
                        class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                </div>
            </div>
            <!-- Clients Table -->
            <div class="bg-white rounded-lg shadow-sm">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Client</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Created</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php if (empty($clients)): ?>
                                <tr>
                                    <td colspan="4" class="px-6 py-12 text-center">
                                        <div class="text-gray-500">
                                            <i class="fas fa-users text-4xl mb-3"></i>
                                            <p class="text-lg font-medium">No Clients Found</p>
                                            <p class="text-sm">Start by adding a new client</p>
                                        </div>
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($clients as $client): ?>
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="h-10 w-10 flex-shrink-0">
                                                    <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center">
                                                        <span class="text-blue-600 font-medium text-sm">
                                                            <?= strtoupper(substr($client->getName(), 0, 2)) ?>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="ml-4">
                                                    <div class="name-client text-sm font-medium text-gray-900">
                                                        <?= htmlspecialchars($client->getName()) ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="email-client px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            <?= htmlspecialchars($client->getEmail()) ?>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-500">
                                            <?= date('M d, Y', strtotime($client->getCreatedAt())) ?>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <div class="flex justify-end space-x-3">
                                                <a href="/admin/clients/<?= $client->getId() ?>"
                                                   class="text-blue-600 hover:text-blue-900 flex items-center">
                                                    <i class="fas fa-eye mr-1"></i>
                                                    View Details
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('searchClient').addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            const rows = document.querySelectorAll('tbody tr');

            rows.forEach(row => {
                const name = row.querySelector('.name-client').textContent.toLowerCase();
                const email = row.querySelector('.email-client').textContent.toLowerCase();

                if (name.includes(searchTerm) || email.includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    </script>
</body>

</html>
