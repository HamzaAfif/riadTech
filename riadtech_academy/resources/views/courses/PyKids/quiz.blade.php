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
    <title>Quiz: Test Your Skills - Python for Kids</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .code-input { font-family: monospace; width: 100%; height: 80px; }
        .success { color: #10b981; }
        .error { color: #ef4444; }
        .bg-python-blue { background-color: #1e40af; }
    </style>
</head>
<body class="bg-blue-50 font-sans antialiased">
    <header class="bg-python-blue text-white py-4">
        <div class="container mx-auto px-4 flex justify-between items-center">
            <h1 class="text-2xl font-bold">Python for Kids</h1>
            <a href="index.html" class="text-sm hover:underline">Back to Overview</a>
        </div>
    </header>

    <main class="container mx-auto px-4 py-8">
        <h2 class="text-3xl font-bold text-blue-800 mb-6">Quiz: Test Your Skills</h2>
        <p class="text-gray-600 mb-4">Answer these quick questions. Cheat code: <code>pass pass</code>.</p>
        <div class="bg-white p-4 rounded-lg shadow-md">
            <div class="mb-4">
                <p class="text-gray-600 mb-2">What does <code>print("Hi")</code> do?</p>
                <label class="block mb-2"><input type="radio" name="q1" value="A" data-answer="A"> A: Shows "Hi"</label>
                <label class="block mb-2"><input type="radio" name="q1" value="B"> B: Makes a variable</label>
            </div>
            <div class="mb-4">
                <p class="text-gray-600 mb-2">Type code for a variable <code>age = 10</code>.</p>
                <textarea class="code-input border rounded p-2" name="q2" data-answer="age = 10"></textarea>
            </div>
            <button id="submit-quiz" class="bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-700">Submit Quiz</button>
            <p id="quiz-feedback" class="mt-2"></p>
        </div>
        <div class="mt-6 flex justify-between">
            <a href="task5.html" class="bg-gray-300 text-gray-700 py-2 px-4 rounded hover:bg-gray-400">Previous</a>
            <form method="POST" action="/student/courses/{{ $slug }}/tasks/{{ $task }}/complete">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <button type="submit">✅ Complete {{ ucfirst($task) }}</button>
</form>

        </div>
    </main>

    <script>
        document.getElementById('submit-quiz').addEventListener('click', () => {
            const feedback = document.getElementById('quiz-feedback');
            const answers = [
                { name: 'q1', correct: 'A' },
                { name: 'q2', correct: 'age = 10' },
            ];
            let correctCount = 0;

            answers.forEach(answer => {
                if (answer.name === 'q2') {
                    const input = document.querySelector(`textarea[name="${answer.name}"]`);
                    if (input && (input.value.trim() === answer.correct || input.value.trim() === 'pass pass')) correctCount++;
                } else {
                    const selected = document.querySelector(`input[name="${answer.name}"]:checked`);
                    if (selected && (selected.value === answer.correct || selected.value === 'pass pass')) correctCount++;
                }
            });

            feedback.textContent = `You got ${correctCount}/2 correct!`;
            feedback.classList.add(correctCount === 2 ? 'success' : 'error');
        });
    </script>
</body>
</html>