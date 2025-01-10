<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Bank - Dashboard</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lucide/0.263.1/umd/lucide.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <?php

use Core\Auth;

 require_once __DIR__ . '/parts/clientSidebar.php'; ?>

        <!-- Toggle Button for Mobile -->
        <button class="md:hidden p-4 text-gray-600 hover:text-blue-600" id="toggleSidebar">
            <i data-lucide="menu" class="w-6 h-6"></i>
        </button>

        <button class="hidden md:block p-4 text-gray-600 hover:text-blue-600" id="toggleSidebarDesktop">
            <i data-lucide="menu" class="w-6 h-6"></i>
        </button>

        <!-- Main Content -->
        <div class="flex-1 p-4 md:p-8">
            <h2 class="text-2xl font-bold text-gray-800">
                Hello <?= isset($auth['user']) ? $auth['user']->getName() : 'Guest' ?>
            </h2>
            
            <!-- Account Summary Cards -->
            <?php foreach($account as $acc) : ?>
               
                <?php if($acc->getAccountType() == "current") : ?>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mt-6">
                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="text-lg font-semibold text-gray-700">Current Account</h3>
                    <p class="text-3xl font-bold text-gray-900 mt-2"> <?= $acc->getBalance(); ?> $</p>
                </div>
                <?php elseif($acc->getAccountType() == "savings") : ?>
            
                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="text-lg font-semibold text-gray-700">Savings Account</h3>
                    <p class="text-3xl font-bold text-gray-900 mt-2"> <?= $acc->getBalance(); ?> $</p>
                </div>
            </div>
            <?php endif; ?>
            <?php endforeach; ?>
            


            <!-- Quick Actions -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mt-6">
                <button class="flex items-center justify-center space-x-2 p-4 bg-blue-600 text-white rounded-lg hover:bg-blue-700" onclick="openPopup('newTransferPopup')">
                    <i data-lucide="send" class="w-5 h-5"></i>
                    <span>New Transfer</span>
                </button>
                <button class="flex items-center justify-center space-x-2 p-4 bg-green-600 text-white rounded-lg hover:bg-green-700" onclick="openPopup('fundAccountPopup')">
                    <i data-lucide="plus-circle" class="w-5 h-5"></i>
                    <span>Fund Account</span>
                </button>
                <button class="flex items-center justify-center space-x-2 p-4 bg-purple-600 text-white rounded-lg hover:bg-purple-700" onclick="openPopup('manageBeneficiariesPopup')">
                    <i data-lucide="users" class="w-5 h-5"></i>
                    <span>Manage Beneficiaries</span>
                </button>
            </div>

            <!-- Popup Sections -->
            <div id="newTransferPopup" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
                <div class="bg-white p-6 rounded-lg shadow-lg w-1/3">
                    <h3 class="text-lg font-semibold">New Transfer</h3>
                    <form class="mt-4 space-y-4">
                        <div>
                            <label for="transferName" class="block text-sm font-medium text-gray-700">Recipient Name</label>
                            <input type="text" id="transferName" class="w-full p-2 border rounded-lg" placeholder="Enter recipient name">
                        </div>
                        <div>
                            <label for="transferAccount" class="block text-sm font-medium text-gray-700">Account Number</label>
                            <input type="text" id="transferAccount" class="w-full p-2 border rounded-lg" placeholder="Enter account number">
                        </div>
                        <div>
                            <label for="transferAmount" class="block text-sm font-medium text-gray-700">Amount</label>
                            <input type="number" id="transferAmount" class="w-full p-2 border rounded-lg" placeholder="Enter amount">
                        </div>
                        <div>
                            <label for="transferMotif" class="block text-sm font-medium text-gray-700">Transfer Motif</label>
                            <textarea id="transferMotif" class="w-full p-2 border rounded-lg" placeholder="Enter the reason for the transfer"></textarea>
                        </div>
                        <div class="flex justify-end space-x-2">
                            <button type="button" class="bg-gray-600 text-white p-2 rounded" onclick="closePopup('newTransferPopup')">Cancel</button>
                            <button type="submit" class="bg-blue-600 text-white p-2 rounded">Submit</button>
                        </div>
                    </form>
                </div>
            </div>

            <div id="fundAccountPopup" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
                <div class="bg-white p-6 rounded-lg shadow-lg w-1/3">
                    <h3 class="text-lg font-semibold">Fund Account</h3>
                    <form class="mt-4 space-y-4">
                        <div>
                            <label for="fundAmount" class="block text-sm font-medium text-gray-700">Amount</label>
                            <input type="number" id="fundAmount" class="w-full p-2 border rounded-lg" placeholder="Enter amount">
                        </div>
                        <div>
                            <label for="fundSource" class="block text-sm font-medium text-gray-700">Source</label>
                            <input type="text" id="fundSource" class="w-full p-2 border rounded-lg" placeholder="Enter funding source">
                        </div>
                        <div class="flex justify-end space-x-2">
                            <button type="button" class="bg-gray-600 text-white p-2 rounded" onclick="closePopup('fundAccountPopup')">Cancel</button>
                            <button type="submit" class="bg-green-600 text-white p-2 rounded">Submit</button>
                        </div>
                    </form>
                </div>
            </div>

            <div id="manageBeneficiariesPopup" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
                <div class="bg-white p-6 rounded-lg shadow-lg w-1/3">
                    <h3 class="text-lg font-semibold">Manage Beneficiaries</h3>
                    <form class="mt-4 space-y-4">
                        <div>
                            <label for="beneficiaryName" class="block text-sm font-medium text-gray-700">Beneficiary Name</label>
                            <input type="text" id="beneficiaryName" class="w-full p-2 border rounded-lg" placeholder="Enter beneficiary name">
                        </div>
                        <div>
                            <label for="beneficiaryAccount" class="block text-sm font-medium text-gray-700">Account Number</label>
                            <input type="text" id="beneficiaryAccount" class="w-full p-2 border rounded-lg" placeholder="Enter account number">
                        </div>
                        <div class="flex justify-end space-x-2">
                            <button type="button" class="bg-gray-600 text-white p-2 rounded" onclick="closePopup('manageBeneficiariesPopup')">Cancel</button>
                            <button type="submit" class="bg-purple-600 text-white p-2 rounded">Submit</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        lucide.createIcons();
        const toggleButton = document.getElementById('toggleSidebar');
        const toggleButtonDesktop = document.getElementById('toggleSidebarDesktop');
        const sidebar = document.getElementById('sidebar');

        toggleButton.addEventListener('click', () => {
            sidebar.classList.toggle('hidden');
        });

        toggleButtonDesktop.addEventListener('click', () => {
            sidebar.classList.toggle('hidden');
        });
    });

    function openPopup(popupId) {
        document.getElementById(popupId).classList.remove('hidden');
    }

    function closePopup(popupId) {
        document.getElementById(popupId).classList.add('hidden');
    }
</script>
</body>
</html>
