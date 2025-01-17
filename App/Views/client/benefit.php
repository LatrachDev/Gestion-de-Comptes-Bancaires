<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ma Banque - Bénéficiaires</title>
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
            <div class="flex justify-between items-center">
                <h2 class="text-2xl font-bold text-gray-800">Bénéficiaires</h2>
                <button class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 flex items-center">
                    <i data-lucide="plus" class="w-5 h-5 mr-2"></i>
                    Ajouter un bénéficiaire
                </button>
            </div>

            <!-- Liste des bénéficiaires -->
            <div class="mt-6 bg-white rounded-lg shadow">
                <div class="p-6">
                    <!-- Bénéficiaire 1 -->
                    <div class="border-b pb-4">
                        <div class="flex justify-between items-center">
                            <div class="flex items-center space-x-4">
                                <div class="bg-blue-100 p-3 rounded-full">
                                    <i data-lucide="user" class="w-6 h-6 text-blue-600"></i>
                                </div>
                                <div>
                                    <h3 class="font-medium text-gray-900">John Doe</h3>
                                    <p class="text-sm text-gray-500">FR76 1111 2222 3333</p>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        Compte Courant
                                    </span>
                                </div>
                            </div>
                            <div class="flex space-x-2">
                                <button class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg">
                                    <i data-lucide="send" class="w-5 h-5"></i>
                                </button>
                                <button class="p-2 text-gray-600 hover:bg-gray-50 rounded-lg">
                                    <i data-lucide="edit" class="w-5 h-5"></i>
                                </button>
                                <button class="p-2 text-red-600 hover:bg-red-50 rounded-lg">
                                    <i data-lucide="trash-2" class="w-5 h-5"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Bénéficiaire 2 -->
                    <div class="border-b py-4">
                        <div class="flex justify-between items-center">
                            <div class="flex items-center space-x-4">
                                <div class="bg-purple-100 p-3 rounded-full">
                                    <i data-lucide="user" class="w-6 h-6 text-purple-600"></i>
                                </div>
                                <div>
                                    <h3 class="font-medium text-gray-900">Jane Smith</h3>
                                    <p class="text-sm text-gray-500">FR76 4444 5555 6666</p>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                        Compte Épargne
                                    </span>
                                </div>
                            </div>
                            <div class="flex space-x-2">
                                <button class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg">
                                    <i data-lucide="send" class="w-5 h-5"></i>
                                </button>
                                <button class="p-2 text-gray-600 hover:bg-gray-50 rounded-lg">
                                    <i data-lucide="edit" class="w-5 h-5"></i>
                                </button>
                                <button class="p-2 text-red-600 hover:bg-red-50 rounded-lg">
                                    <i data-lucide="trash-2" class="w-5 h-5"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Formulaire d'ajout de bénéficiaire (masqué par défaut) -->
                    <div class=" mt-6 p-6 border rounded-lg">
                        <h3 class="text-lg font-medium text-gray-900">Ajouter un bénéficiaire</h3>
                        <form class="mt-4 space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Nom complet</label>
                                <input type="text" class="mt-1 block w-full rounded-md border border-gray-300 p-2">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">IBAN</label>
                                <input type="text" class="mt-1 block w-full rounded-md border border-gray-300 p-2">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Type de compte</label>
                                <select class="mt-1 block w-full rounded-md border border-gray-300 p-2">
                                    <option>Compte Courant</option>
                                    <option>Compte Épargne</option>
                                </select>
                            </div>
                            <div class="flex justify-end space-x-3">
                                <button type="button" class="px-4 py-2 border rounded-lg">Annuler</button>
                                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg">Ajouter</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>