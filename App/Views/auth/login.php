<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bank - Login</title>
    <script src="/assets/JavaScript/tailwind.js"></script>
</head>

<body>
    <main class="bg-[url('/assets/images/bg2.jpg')] w-full h-screen bg-cover bg-center flex justify-center items-center bg-gray-900/60 backdrop-blur-lg">

        <!-- <div class="w-full max-w-md bg-white/30 backdrop-blur-md p-8 rounded-lg shadow-lg border border-white/20"> -->
        <div class="w-full max-w-md bg-white/30 backdrop-blur-md p-8 rounded-lg shadow-white border border-white/20">
            <h2 class="text-3xl font-extrabold text-center text-white mb-6">Bank Login</h2>
            <?php
            if ($this->hasFlash("loginError")) {
                echo $this->getFlash("loginError")['message'];
            }
            ?>
            <form action="#" method="POST">
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-200">Email</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        class="mt-1 block w-full p-3 bg-white/20 border border-gray-200 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 text-white placeholder-gray-300"
                        placeholder="Enter your email"
                        required>
                </div>
                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-gray-200">Password</label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        class="mt-1 block w-full p-3 bg-white/20 border border-gray-200 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 text-white placeholder-gray-300"
                        placeholder="Enter your password"
                        required>
                </div>
                <div class="flex items-center justify-between mb-4">
                    <label class="flex items-center">
                        <input type="checkbox" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                        <span class="ml-2 text-sm text-gray-300">Remember me</span>
                    </label>
                    <a href="#" class="text-sm text-blue-400 hover:underline">Forgot Password?</a>
                </div>
                <button
                    type="submit"
                    class="w-full bg-blue-600/80 text-white py-2 px-4 rounded-lg hover:bg-blue-700/90 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    Login
                </button>
            </form>
            <p class="mt-6 text-center text-sm text-gray-300">
                Don’t have an account?
                <a href="#" class="text-blue-400 hover:underline">Sign up</a>
            </p>
        </div>
    </main>
</body>

</html>