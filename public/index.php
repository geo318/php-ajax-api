<!doctype HTML>
<html>
    <head>
        <meta content="width=device-width, user-scalable=no, initial-scale=1.0, minimal-ui" name='viewport'>
        <title>Submit form</title>
        <link href="./css/tailwind.css" rel="stylesheet">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    </head>
    <body>
        <main class="min-h-screen bg-gray-100 flex flex-col justify-center py-12 px-6 lg:px-8">
            <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
                <div class='bg-white py-8 px-6 shadow rounded-lg sm:px-10'>
                    <form class="mb-0 space-y-6" action='' method='POST' onsubmit="return false">
                        <h1 class="mt-6 text-center text-3xl font-extrabold text-gray-900">Dictionary API : search 👇</h1>
                        <div class="mt-1 w-full flex">
                            <input class="border-2 w-full border-black border-solid rounded-md font-medium" type='text' id = 'name' name='name' placeholder='search any word...' ?>
                        </div>
                        <button class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" type='submit' id='search_submit' name='submit'>Search</button>
                        <button class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" type='submit' id='db_submit' name='submit'>Show form Database</button>
                    </form>
                    <div class='result p-4' id ='search_result'></div>
                </div>
            </div>
        </main>
        <script src="js/main.js"></script>
    </body>
</html>