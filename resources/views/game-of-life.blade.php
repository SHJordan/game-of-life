<!DOCTYPE html>
<html>
<head>
    <title>Game of Life</title>
    <!-- TailwindCSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Google Fonts - Press Start 2P -->
    <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap" rel="stylesheet">
    <style>
        /* Aplicar a fonte pixelada */
        body {
            font-family: 'Press Start 2P', cursive;
            background-color: #f0f4f8;
        }

        /* Estilização da tabela */
        table {
            border-collapse: collapse;
        }

        td {
            width: 25px;
            height: 25px;
            border: 1px solid #ccc;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .alive {
            background-color: #333;
        }

        /* Estilização do botão */
        .btn-submit {
            @apply bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded;
        }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen">
    <div class="bg-white p-8 rounded-lg shadow-lg">
        <h1 class="text-2xl text-center mb-6">Game of Life</h1>

        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li class="list-disc list-inside">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="overflow-auto max-w-full">
            <table id="game-board" class="mx-auto">
                @foreach($gameBoard->grid as $rowIndex => $row)
                    <tr>
                        @foreach($row as $colIndex => $cell)
                            <td class="{{ $cell == 1 ? 'alive' : '' }}" data-row="{{ $rowIndex }}" data-col="{{ $colIndex }}"></td>
                        @endforeach
                    </tr>
                @endforeach
            </table>
        </div>

        <form action="{{ route('game-of-life.update', $gameBoard->id) }}" method="post" class="mt-6 text-center">
            @csrf
            @method('PUT')
            <input type="hidden" id="grid" name="grid">
            <button type="submit" class="btn-submit">Next Generation</button>
        </form>
    </div>

    <script>
        const gameBoard = document.getElementById('game-board');
        const gridInput = document.getElementById('grid');

        // Inicializar o campo 'grid' com o estado atual do gameBoard ao carregar a página
        const initialGrid = @json($gameBoard->grid);
        gridInput.value = JSON.stringify(initialGrid);

        gameBoard.addEventListener('click', (e) => {
            if (e.target.tagName === 'TD') {
                const row = e.target.dataset.row;
                const col = e.target.dataset.col;
                const cell = e.target;

                // Alterna a classe 'alive' na célula clicada
                cell.classList.toggle('alive');

                // Atualiza o estado do grid com base nas células atuais
                const grid = [];
                const rows = gameBoard.rows;

                for (let i = 0; i < rows.length; i++) {
                    const rowCells = rows[i].cells;
                    const rowGrid = [];

                    for (let j = 0; j < rowCells.length; j++) {
                        const cell = rowCells[j];
                        rowGrid.push(cell.classList.contains('alive') ? 1 : 0);
                    }

                    grid.push(rowGrid);
                }

                gridInput.value = JSON.stringify(grid);
            }
        });
    </script>
</body>
</html>
