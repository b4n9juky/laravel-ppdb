<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login Form</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 min-h-screen flex items-center justify-center">

  <div class="bg-white p-8 rounded-xl shadow-xl w-full max-w-md">
    <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Login to Your Account</h2>

    <form action="#" method="POST" class="space-y-4">
      <div>
        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
        <input
          type="email"
          id="email"
          name="email"
          required
          class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-indigo-400 focus:outline-none"
        />
      </div>

      <div>
        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
        <input
          type="password"
          id="password"
          name="password"
          required
          class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-indigo-400 focus:outline-none"
        />
      </div>

      <div class="flex items-center justify-between">
        <label class="flex items-center text-sm">
          <input type="checkbox" class="mr-2" />
          Remember me
        </label>
        <a href="#" class="text-sm text-indigo-500 hover:underline">Forgot password?</a>
      </div>

      <button
        type="submit"
        class="w-full py-2 px-4 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-lg shadow-md transition duration-300"
      >
        Sign In
      </button>
    </form>

    <p class="mt-6 text-sm text-center text-gray-600">
      Don't have an account?
      <a href="#" class="text-indigo-500 hover:underline">Sign up</a>
    </p>
  </div>

</body>
</html>
