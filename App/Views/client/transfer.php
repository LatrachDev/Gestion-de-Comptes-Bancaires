<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Bank - Transfers</title>
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
            <h2 class="text-2xl font-bold text-gray-800">Make a transfer</h2>
            <?php
            if ($this->hasFlash("transfer")) {
                echo $this->getFlash("transfer")['message'];
            }
            ?>
            <div class="bg-white p-6 rounded-lg shadow mt-6">
                <form class="space-y-4" method="POST" action="/transfer">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Compte à débiter</label>
                        <select class="mt-1 block w-full rounded-md border border-gray-300 p-2" name="sender">
                            <?php foreach ($accounts as $account) : ?>
                                <?php if ($account->getAccountType() === 'current') : ?>
                                    <option value="<?= $account->getId() ?>">Current - <?= $account->getId() ?></option>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Beneficiary</label>
                        <select class="mt-1 block w-full rounded-md border border-gray-300 p-2" name="recipient">
                        <?php foreach ($accounts as $account) : ?>
                                <?php if ($account->getAccountType() === 'savings') : ?>
                                    <option value="<?= $account->getId() ?>">Saving - <?= $account->getId() ?></option>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Montant</label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 sm:text-sm">MAD</span>
                            </div>
                            <input 
                                type="number" 
                                min="0.01" 
                                step="0.01"
                                class="pl-7 block w-full rounded-md border border-gray-300 p-2 " 
                                placeholder="    0.00"
                                name="amount"
                            />
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Motif</label>
                        <input 
                            type="text"
                            class="mt-1 block w-full rounded-md border border-gray-300 p-2" 
                            placeholder="Motif du virement"
                            name="motif"
                        />
                    </div>

                    <div class="pt-4">
                        <button type="submit" class="w-full bg-blue-600 text-white p-3 rounded-lg hover:bg-blue-700">
                            Valider le virement
                        </button>
                    </div>
                </form>
            </div>

            <!-- Derniers virements -->
            <div class="bg-white rounded-lg shadow mt-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-700">Derniers virements</h3>
                    <div class="mt-4 space-y-4">
                        <div class="flex items-center justify-between p-4 border-b">
                            <div class="mx-auto mb-10">
                                <p class="text-sm text-gray-500">Aucun virement</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="p-6 hidden">
                    <h3 class="text-lg font-semibold text-gray-700">Derniers virements</h3>
                    <div class="mt-4 space-y-4">
                        <div class="flex items-center justify-between p-4 border-b">
                            <div>
                                <p class="font-medium">Virement à John Doe</p>
                                <p class="text-sm text-gray-500">12 janvier 2025</p>
                                <p class="text-sm text-gray-500">Motif : Remboursement déjeuner</p>
                            </div>
                            <p class="text-red-600 font-medium">-€125.00</p>
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