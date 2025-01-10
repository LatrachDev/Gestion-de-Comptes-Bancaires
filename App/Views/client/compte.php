<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Bank - My Accounts</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lucide/0.263.1/umd/lucide.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body class="bg-gray-100">
    <div class="flex min-h-screen">

        <?php require_once __DIR__ . '/parts/clientSidebar.php'; ?>

        <div class="flex-1 p-8">
            <h2 class="text-2xl font-bold text-gray-800">My accounts</h2>

            <div class="mt-6 bg-white rounded-lg shadow">
                <?php if (!empty($account)) : ?>
                    <?php foreach ($account as $acc) : ?>
                        <div class="p-6">
                            <div class="flex justify-between items-center">
                                <div>
                                    <h3 class="text-xl font-semibold text-gray-800">
                                        <?= $acc->getAccountType() === 'current' ? 'Current Account' : 'Savings Account' ?>
                                    </h3>
                                </div>
                                <div class="text-right">
                                    <p class="text-2xl font-bold text-gray-900">$<?= number_format($acc->getBalance(), 2) ?></p>
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium 
                                            <?= $acc->getStatus() === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' ?>">
                                        <?= $acc->getStatus() ?>
                                    </span>
                                </div>
                            </div>

                            <div class="mt-6 grid grid-cols-2 gap-4">
                                <!-- Fund Button -->
                                <button onclick="toggleModal('fundModal', <?= $acc->getId() ?>)" class="flex items-center justify-center p-3 text-blue-600 border border-blue-600 rounded-lg hover:bg-blue-50">
                                    <i data-lucide="plus-circle" class="w-5 h-5 mr-2"></i>
                                    Fund
                                </button>

                                <!-- Withdrawal Button -->
                                <button onclick="toggleModal('withdrawalModal', <?= $acc->getId() ?>)" class="flex items-center justify-center p-3 text-purple-600 border border-purple-600 rounded-lg hover:bg-purple-50">
                                    <i data-lucide="download" class="w-5 h-5 mr-2"></i>
                                    Withdrawal
                                </button>
                            </div>

                            <div class="mt-6">
                                <h4 class="font-medium text-gray-700">Account details</h4>
                                <dl class="mt-4 grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                                    <div>
                                        <dt class="text-sm text-gray-500">Opening Date</dt>
                                        <dd class="mt-1 text-sm text-gray-900"></dd>
                                    </div>
                                    <?php if ($acc->getAccountType() === 'current') : ?>
                                        <div>
                                            <dt class="text-sm text-gray-500">Withdrawal Limit</dt>
                                        </div>
                                        <div>
                                            <dt class="text-sm text-gray-500">Authorized Overdraft</dt>
                                        </div>
                                    <?php else : ?>
                                        <div>
                                            <dt class="text-sm text-gray-500">Interest Rate</dt>
                                        </div>
                                        <div>
                                            <dt class="text-sm text-gray-500">Plafond</dt>
                                        </div>
                                    <?php endif; ?>
                                    <div>
                                        <dt class="text-sm text-gray-500">Maintenance Fee</dt>
                                    </div>
                                </dl>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else : ?>
                    <div class="p-6">
                        <p class="text-gray-600">Aucun compte trouvé.</p>
                    </div>
                <?php endif; ?>
            </div>


        </div>
    </div>

    <!-- Fund Modal -->
    <div id="fundModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 w-full max-w-md">
            <div class="bg-white rounded-lg shadow-xl">
                <!-- Modal header -->
                <div class="flex justify-between items-center p-6 border-b">
                    <h3 class="text-lg font-semibold text-gray-900">Fund Account</h3>
                    <button onclick="toggleModal('fundModal')" class="text-gray-400 hover:text-gray-500">
                        <i data-lucide="x" class="w-6 h-6"></i>
                    </button>
                </div>

                <!-- Modal body -->
                <div class="p-6">
                    <form id="fundForm" class="space-y-6" action="/fund-account" method="POST">
                        <!-- Hidden input for account ID -->
                        <input type="hidden" name="account_id" value="<?= $acc->getId() ?>">

                        <!-- Amount -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Amount *</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500">$</span>
                                </div>
                                <input
                                    type="number"
                                    name="amount"
                                    required
                                    min="0.01"
                                    step="0.01"
                                    class="w-full pl-8 pr-12 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    placeholder="0.00">
                            </div>
                            <p class="mt-1 text-sm text-gray-500">Minimum amount: 0.01 $</p>
                        </div>

                        <!-- Modal footer -->
                        <div class="flex justify-end space-x-3 p-6 border-t bg-gray-50">
                            <button
                                onclick="toggleModal('fundModal')"
                                class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-500">
                                Cancel
                            </button>
                            <button

                                class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                Confirm Funding
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Withdrawal Modal -->
    <div id="withdrawalModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 w-full max-w-md">
            <div class="bg-white rounded-lg shadow-xl">
                <!-- Modal header -->
                <div class="flex justify-between items-center p-6 border-b">
                    <h3 class="text-lg font-semibold text-gray-900">Withdraw Funds</h3>
                    <button onclick="toggleModal('withdrawalModal')" class="text-gray-400 hover:text-gray-500">
                        <i data-lucide="x" class="w-6 h-6"></i>
                    </button>
                </div>

                <!-- Modal body -->
                <div class="p-6">
                    <form id="withdrawalForm" method="POST" action="/withdraw" class="space-y-6">
                        <!-- Hidden input for account ID -->
                        <input type="hidden" name="account_id"> 
                        <!-- Amount -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Amount *</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500">$</span>
                                </div>
                                <input
                                    type="number"
                                    name="amount"
                                    required
                                    min="0.01"
                                    step="0.01"
                                    class="w-full pl-8 pr-12 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500"
                                    placeholder="0.00">
                            </div>
                            <p class="mt-1 text-sm text-gray-500">Minimum amount: 0.01 $</p>
                        </div>


                        <!-- Modal footer -->
                        <div class="flex justify-end space-x-3 p-6 border-t bg-gray-50">
                            <button
                                onclick="toggleModal('withdrawalModal')"
                                class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-500">
                                Cancel
                            </button>
                            <button
                                class="px-4 py-2 bg-purple-600 text-white rounded-md hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500">
                                Confirm Withdrawal
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Function to toggle modal visibility
        function toggleModal(modalId, accId) {
            const modal = document.getElementById(modalId);
            modal.querySelector('input[type="hidden"]').value = accId;
            modal.classList.toggle('hidden');
        }

        // Function to handle form submission
        function submitForm(formId) {
            const form = document.getElementById(formId);
            if (form.checkValidity()) {

                toggleModal(formId.replace('Form', 'Modal')); // Close the modal
                form.reset(); // Reset the form
            } else {
                alert('Please fill out all required fields correctly.');
            }
        }
    </script>
</body>

</html>