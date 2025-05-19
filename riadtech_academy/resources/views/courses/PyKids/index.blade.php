<script type="text/javascript">
        var gk_isXlsx = false;
        var gk_xlsxFileLookup = {};
        var gk_fileData = {};
        function filledCell(cell) {
          return cell !== '' && cell != null;
        }
        function loadFileData(filename) {
        if (gk_isXlsx && gk_xlsxFileLookup[filename]) {
            try {
                var workbook = XLSX.read(gk_fileData[filename], { type: 'base64' });
                var firstSheetName = workbook.SheetNames[0];
                var worksheet = workbook.Sheets[firstSheetName];

                // Convert sheet to JSON to filter blank rows
                var jsonData = XLSX.utils.sheet_to_json(worksheet, { header: 1, blankrows: false, defval: '' });
                // Filter out blank rows (rows where all cells are empty, null, or undefined)
                var filteredData = jsonData.filter(row => row.some(filledCell));

                // Heuristic to find the header row by ignoring rows with fewer filled cells than the next row
                var headerRowIndex = filteredData.findIndex((row, index) =>
                  row.filter(filledCell).length >= filteredData[index + 1]?.filter(filledCell).length
                );
                // Fallback
                if (headerRowIndex === -1 || headerRowIndex > 25) {
                  headerRowIndex = 0;
                }

                // Convert filtered JSON back to CSV
                var csv = XLSX.utils.aoa_to_sheet(filteredData.slice(headerRowIndex)); // Create a new sheet from filtered array of arrays
                csv = XLSX.utils.sheet_to_csv(csv, { header: 1 });
                return csv;
            } catch (e) {
                console.error(e);
                return "";
            }
        }
        return gk_fileData[filename] || "";
        }
        </script><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Python for Kids - Overview - RiadTech Academy</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .bg-python-blue { background-color: #1e40af; }
    </style>
</head>
<body class="bg-blue-50 font-sans antialiased">
    <header class="bg-python-blue text-white py-4">
        <div class="container mx-auto px-4 flex justify-between items-center">
            <h1 class="text-2xl font-bold">Python for Kids</h1>
            <a href="/" class="text-sm hover:underline">Back to Home</a>
        </div>
    </header>

    <main class="container mx-auto px-4 py-8">
        <h2 class="text-3xl font-bold text-blue-800 mb-6">Python Adventure Camp - Overview</h2>
        <p class="text-gray-600 mb-4">Welcome to the Python for Kids course! Complete these fun tasks to learn Python with Pippin the Python. Use the cheat code <code>pass pass</code> to skip any task during testing!</p>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <a href="task1.html" class="block bg-white p-4 rounded-lg shadow-md hover:bg-blue-100">
                <h3 class="text-lg font-semibold text-blue-600">Task 1: Say Hi!</h3>
                <p class="text-gray-600">Greet Pippin with a simple print command.</p>
            </a>
            <a href="task2.html" class="block bg-white p-4 rounded-lg shadow-md hover:bg-blue-100">
                <h3 class="text-lg font-semibold text-blue-600">Task 2: Name Your Pet</h3>
                <p class="text-gray-600">Give Pippin a name using a variable.</p>
            </a>
            <a href="task3.html" class="block bg-white p-4 rounded-lg shadow-md hover:bg-blue-100">
                <h3 class="text-lg font-semibold text-blue-600">Task 3: Jump Three Times</h3>
                <p class="text-gray-600">Help Pippin jump using a loop.</p>
            </a>
            <a href="task4.html" class="block bg-white p-4 rounded-lg shadow-md hover:bg-blue-100">
                <h3 class="text-lg font-semibold text-blue-600">Task 4: Choose a Path</h3>
                <p class="text-gray-600">Pick a path for Pippin with a variable.</p>
            </a>
            <a href="task5.html" class="block bg-white p-4 rounded-lg shadow-md hover:bg-blue-100">
                <h3 class="text-lg font-semibold text-blue-600">Task 5: Mini Game Time</h3>
                <p class="text-gray-600">Guess Pippin's number in a tiny game.</p>
            </a>
            <a href="quiz.html" class="block bg-white p-4 rounded-lg shadow-md hover:bg-blue-100">
                <h3 class="text-lg font-semibold text-blue-600">Quiz: Test Your Skills</h3>
                <p class="text-gray-600">Answer quick questions to check your learning.</p>
            </a>
            <a href="project.html" class="block bg-white p-4 rounded-lg shadow-md hover:bg-blue-100">
                <h3 class="text-lg font-semibold text-blue-600">Final Project: Number Guessing Game</h3>
                <p class="text-gray-600">Build a fun game with Pippin!</p>
            </a>

        </div>

         @php
        $first = 'task1';
        @endphp

        <form method="GET" action="{{ route('student.courses.tasks.show', ['slug'=>$course->slug, 'step'=>$first]) }}">
        <button>▶️ Next: {{ ucfirst($first) }}</button>
        </form>

    </main>
</body>
</html>