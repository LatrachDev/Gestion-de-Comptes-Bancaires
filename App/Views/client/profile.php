<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyBank - Profile</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lucide/0.263.1/umd/lucide.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="flex min-h-screen">

        <!-- Sidebar -->
        <?php require_once __DIR__ . '/parts/clientSidebar.php'; ?>

        <!-- Main Content -->
        <form method="POST" action="/update-profile" class="flex-1 p-8">
            <h2 class="text-2xl font-bold text-gray-800">My Profile</h2>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-6">
                <!-- Edit Profile -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-lg shadow">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-700 mb-4">Edit informations</h3>
                            <form class="space-y-6">
                                <!-- Edit Name -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Name</label>
                                    <input 
                                        type="text" 
                                        class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2"
                                        value="<?= htmlspecialchars($user->getName()) ?>" 
                                    />
                                </div>

                                <!-- Edit Email -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Email</label>
                                    <input 
                                        type="email" 
                                        class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2"
                                        value="<?= htmlspecialchars($user->getEmail()) ?>" 
                                    />
                                </div>

                                <!-- Update Password -->
                                <h3 class="text-lg font-semibold text-gray-700 mt-6">Change password</h3>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Current password</label>
                                    <input 
                                        type="password" 
                                        class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2"
                                        placeholder="••••••••"
                                    />
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">New password</label>
                                    <input 
                                        type="password" 
                                        class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2"
                                        placeholder="••••••••"
                                    />
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Confirm new password</label>
                                    <input 
                                        type="password" 
                                        class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2"
                                        placeholder="••••••••"
                                    />
                                </div>

                                <!-- Save Changes Button -->
                                <div class="flex justify-end pt-4">
                                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                                        Save changes
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

</body>
</html>
