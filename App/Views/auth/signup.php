
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bank - Signup</title>
    <script src="/assets/JavaScript/tailwind.js"></script>
</head>
<body>
    <main class="bg-[url('/assets/images/bg2.jpg')] w-full h-screen bg-cover bg-center flex justify-center items-center bg-gray-900/60 backdrop-blur-lg">

        <div class="w-full max-w-md bg-white/30 backdrop-blur-md p-8 rounded-lg shadow-white border border-white/20">
            <h2 class="text-3xl font-extrabold text-center text-white mb-6">Bank Signup</h2>
            <form action="" method="POST">
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-200">Full Name</label>
                    <input 
                        type="text" 
                        id="name" 
                        name="name" 
                        class="mt-1 block w-full p-3 bg-white/20 border border-gray-200 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 text-white placeholder-gray-300" 
                        placeholder="Enter your full name"
                    >
                </div>
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-200">Email</label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        class="mt-1 block w-full p-3 bg-white/20 border border-gray-200 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 text-white placeholder-gray-300" 
                        placeholder="Enter your email"
                    >
                </div>
                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-gray-200">Password</label>
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        class="mt-1 block w-full p-3 bg-white/20 border border-gray-200 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 text-white placeholder-gray-300" 
                        placeholder="Create a password"
                    >
                </div>
                <div class="mb-4">
                    <label for="confirm-password" class="block text-sm font-medium text-gray-200">Confirm Password</label>
                    <input 
                        type="password" 
                        id="confirm-password" 
                        name="confirm-password" 
                        class="mt-1 block w-full p-3 bg-white/20 border border-gray-200 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 text-white placeholder-gray-300" 
                        placeholder="Confirm your password"
                    >
                </div>
                <hr class="my-5 w-9/12 mx-auto opacity-30">
                <button 
                    type="submit" 
                    class="w-full bg-blue-600/80 text-white py-2 px-4 rounded-lg hover:bg-blue-700/90 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    Sign Up
                </button>
            </form>
            <p class="mt-6 text-center text-sm text-gray-300">
                Already have an account? 
                <a href="" class="text-blue-400 hover:underline">Login</a>
            </p>
        </div>
    </main>
</body>
</html>
