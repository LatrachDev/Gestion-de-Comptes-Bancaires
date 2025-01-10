<?php 
    $currentRoute = $_SERVER['REQUEST_URI']; 
?>

<div class="w-64 bg-white shadow-lg hidden md:block" id="sidebar">
    <div class="p-6">
        <h1 class="text-2xl font-bold text-blue-600">My Bank</h1>
    </div>
    <nav class="mt-6">
        <a href="/" class="flex items-center w-full p-4 space-x-3 <?= $currentRoute === '/' ? 'bg-blue-50 text-blue-600 border-r-4 border-blue-600' : 'text-gray-600 hover:bg-gray-50' ?>">
            <i data-lucide="wallet"></i>
            <span>Dashboard</span>
        </a>
        <a href="compte" class="flex items-center w-full p-4 space-x-3 <?= $currentRoute === '/compte' ? 'bg-blue-50 text-blue-600 border-r-4 border-blue-600' : 'text-gray-600 hover:bg-gray-50' ?>">
            <i data-lucide="credit-card"></i>
            <span>My Accounts</span>
        </a>
        <a href="transfer" class="flex items-center w-full p-4 space-x-3 <?= $currentRoute === '/transfer' ? 'bg-blue-50 text-blue-600 border-r-4 border-blue-600' : 'text-gray-600 hover:bg-gray-50' ?>">
            <i data-lucide="send"></i>
            <span>Transfers</span>
        </a>
        <a href="benefit" class="flex items-center w-full p-4 space-x-3 <?= $currentRoute === '/benefit' ? 'bg-blue-50 text-blue-600 border-r-4 border-blue-600' : 'text-gray-600 hover:bg-gray-50' ?>">
            <i data-lucide="users"></i>
            <span>Beneficiaries</span>
        </a>
        <a href="history" class="flex items-center w-full p-4 space-x-3 <?= $currentRoute === '/history' ? 'bg-blue-50 text-blue-600 border-r-4 border-blue-600' : 'text-gray-600 hover:bg-gray-50' ?>">
            <i data-lucide="history"></i>
            <span>History</span>
        </a>
        <a href="profile" class="flex items-center w-full p-4 space-x-3 <?= $currentRoute === '/profile' ? 'bg-blue-50 text-blue-600 border-r-4 border-blue-600' : 'text-gray-600 hover:bg-gray-50' ?>">
            <i data-lucide="user"></i>
            <span>Profile</span>
        </a>
    </nav>
</div>