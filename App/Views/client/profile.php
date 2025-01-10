<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyBank - Profile</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lucide/0.263.1/umd/lucide.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-100">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <?php require_once __DIR__ . '/parts/clientSidebar.php'; ?>

        <!-- Main Content -->
        <div class="flex-1 p-8">
            <h2 class="text-2xl font-bold text-gray-800">My Profile</h2>

            <!-- Display User Information -->
            <div class="bg-white rounded-lg shadow p-6 mt-6">
                <h3 class="text-lg font-semibold text-gray-700 mb-4">My Information</h3>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Name</label>
                        <p class="mt-1 text-gray-900"><?= htmlspecialchars($user->getName()) ?></p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Email</label>
                        <p class="mt-1 text-gray-900"><?= htmlspecialchars($user->getEmail()) ?></p>
                    </div>
                </div>
                <!-- Edit Button -->
                <button 
                    onclick="openEditModal()" 
                    class="mt-6 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700"
                >
                    Edit Information
                </button>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div id="editModal" class="fixed inset-0 bg-black bg-opacity-50 hidden justify-center items-center">
        <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md">
            <h3 class="text-lg font-semibold text-gray-700 mb-4">Edit Information</h3>
            <form method="POST" action="/update-profile" class="space-y-6">
                <!-- Edit Name -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Name</label>
                    <input 
                        type="text" 
                        name="name" 
                        class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2"
                        value="<?= htmlspecialchars($user->getName()) ?>" 
                    />
                </div>

                <!-- Edit Email -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Email</label>
                    <input 
                        type="email" 
                        name="email" 
                        class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2"
                        value="<?= htmlspecialchars($user->getEmail()) ?>" 
                    />
                </div>

                <!-- Save Changes Button -->
                <div class="flex justify-end space-x-4">
                    <button 
                        type="button" 
                        onclick="closeEditModal()" 
                        class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600"
                    >
                        Cancel
                    </button>
                    <button 
                        type="submit" 
                        class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700"
                    >
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- JavaScript for Modal -->
    <script>
        function openEditModal() {
            document.getElementById('editModal').classList.remove('hidden');
            document.getElementById('editModal').classList.add('flex');
        }

        function closeEditModal() {
            document.getElementById('editModal').classList.add('hidden');
        }
    </script>
</body>
</html>