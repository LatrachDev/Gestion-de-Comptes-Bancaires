<!DOCTYPE html>
<html lang="fr">
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
        <div class="flex-1 p-8">
            <h2 class="text-2xl font-bold text-gray-800">Mon Profil</h2>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-6">
                <!-- Informations Personnelles -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-lg shadow">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-700 mb-4">Informations Personnelles</h3>
                            <form class="space-y-6">
                                <!-- Photo de profil -->
                                <div class="flex items-center space-x-6">
                                    <div class="relative">
                                        <img 
                                            src="" 
                                            alt="Photo de profile"
                                            class="w-32 h-32 rounded-full object-cover"
                                        />
                                        <button 
                                            type="button"
                                            class="absolute bottom-0 right-0 bg-blue-600 text-white p-2 rounded-full hover:bg-blue-700"
                                        >
                                            <i data-lucide="camera" class="w-4 h-4"></i>
                                        </button>
                                    </div>
                                    <div>
                                        <button 
                                            type="button"
                                            class="text-sm text-blue-600 hover:text-blue-800"
                                        >
                                            Changer la photo
                                        </button>
                                        <p class="text-xs text-gray-500 mt-1">
                                            JPG, PNG ou GIF. Max 1MB.
                                        </p>
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Civilité</label>
                                        <select class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2">
                                            <option>M.</option>
                                            <option>Mme</option>
                                        </select>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Numéro client</label>
                                        <input 
                                            type="text" 
                                            readonly 
                                            value="" 
                                            class="mt-1 block w-full rounded-md border border-gray-300 bg-gray-50 px-3 py-2"
                                        />
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Nom</label>
                                        <input 
                                            type="text" 
                                            class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2"
                                            value=""
                                        />
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Prénom</label>
                                        <input 
                                            type="text" 
                                            class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2"
                                            value=""
                                        />
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Date de naissance</label>
                                        <input 
                                            type="date" 
                                            class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2"
                                            value=""
                                        />
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Nationalité</label>
                                        <select class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2">
                                            <option>Française</option>
                                            <option>Autre</option>
                                        </select>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Email</label>
                                        <input 
                                            type="email" 
                                            class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2"
                                            value=""
                                        />
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Téléphone</label>
                                        <input 
                                            type="tel" 
                                            class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2"
                                            value=""
                                        />
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Adresse</label>
                                    <input 
                                        type="text" 
                                        class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2"
                                        value=""
                                    />
                                </div>

                                <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                                    <div class="col-span-2 md:col-span-1">
                                        <label class="block text-sm font-medium text-gray-700">Code postal</label>
                                        <input 
                                            type="text" 
                                            class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2"
                                            value=""
                                        />
                                    </div>

                                    <div class="col-span-2 md:col-span-2">
                                        <label class="block text-sm font-medium text-gray-700">Ville</label>
                                        <input 
                                            type="text" 
                                            class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2"
                                            value=""
                                        />
                                    </div>
                                </div>

                                <div class="flex justify-end pt-4">
                                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                                        Sauvegarder les modifications
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Sécurité -->
                    <div class="bg-white rounded-lg shadow mt-6">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-700 mb-4">Sécurité</h3>
                            <form class="space-y-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Mot de passe actuel</label>
                                    <input 
                                        type="password" 
                                        class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2"
                                        placeholder="••••••••"
                                    />
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Nouveau mot de passe</label>
                                    <input 
                                        type="password" 
                                        class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2"
                                        placeholder="••••••••"
                                    />
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Confirmer le nouveau mot de passe</label>
                                    <input 
                                        type="password" 
                                        class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2"
                                        placeholder="••••••••"
                                    />
                                </div>

                                <div class="flex justify-end pt-4">
                                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                                        Modifier le mot de passe
                                    </button>
                                </div>
                            </form>
                        </div>
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