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
            transition: background-color 0.3s, transform 0.3s;
        }

        .alive {
            background-color: #333;
            transform: scale(1.1);
        }

        /* Estilização do botão */
        .btn-submit {
            @apply bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded;
        }

        /* Mensagens de erro */
        #error-messages .bg-red-100 {
            transition: opacity 0.5s;
        }

        /* Animações adicionais (opcional) */
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes fadeOut {
            from { opacity: 1; }
            to { opacity: 0; }
        }

        .fade-enter-active {
            animation: fadeIn 0.5s forwards;
        }

        .fade-leave-active {
            animation: fadeOut 0.5s forwards;
        }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen">
    <div class="bg-white p-8 rounded-lg shadow-lg">
        <h1 class="text-2xl text-center mb-6">Game of Life</h1>

        <div id="error-messages">
            @if ($errors->any())
                <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li class="list-disc list-inside">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>

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

        <form id="next-generation-form" class="mt-6 text-center">
            @csrf
            @method('PUT')
            <input type="hidden" id="grid" name="grid" value='@json($gameBoard->grid)'>
            <button type="submit" class="btn-submit">Next Generation</button>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const gameBoard = document.getElementById('game-board');
            const gridInput = document.getElementById('grid');
            const form = document.getElementById('next-generation-form');
            const errorMessages = document.getElementById('error-messages');

            // Inicializar o campo 'grid' com o estado atual do gameBoard ao carregar a página
            const initialGrid = @json($gameBoard->grid);
            gridInput.value = JSON.stringify(initialGrid);

            // Função para atualizar o grid no DOM com transições
            function updateGrid(newGrid) {
                for (let i = 0; i < newGrid.length; i++) {
                    for (let j = 0; j < newGrid[i].length; j++) {
                        const cell = gameBoard.rows[i].cells[j];
                        const shouldBeAlive = newGrid[i][j] === 1;
                        const isAlive = cell.classList.contains('alive');

                        if (shouldBeAlive && !isAlive) {
                            cell.classList.add('alive');
                        } else if (!shouldBeAlive && isAlive) {
                            cell.classList.remove('alive');
                        }
                        // Se o estado não mudou, não fazemos nada
                    }
                }
            }

            // Evento de clique nas células para alternar estado
            gameBoard.addEventListener('click', (e) => {
                if (e.target.tagName === 'TD') {
                    const cell = e.target;
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

            // Evento de submissão do formulário via AJAX
            form.addEventListener('submit', (e) => {
                e.preventDefault(); // Evita o envio tradicional do formulário

                const gridData = gridInput.value;
                const token = document.querySelector('input[name="_token"]').value;

                fetch("{{ route('game-of-life.update', $gameBoard->id) }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token,
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest' // Adiciona este header
                    },
                    body: JSON.stringify({
                        grid: gridData,
                        _method: 'PUT'
                    })
                })
                .then(response => {
                    if (!response.ok) {
                        // Se a resposta não for OK, lança um erro com a mensagem do servidor
                        return response.json().then(errorData => {
                            throw new Error(errorData.error || 'Erro desconhecido.');
                        });
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.error) {
                        displayErrors([data.error]);
                        return;
                    }

                    if (data.grid) {
                        updateGrid(data.grid);
                        // Atualiza o campo 'grid' com o novo estado
                        gridInput.value = JSON.stringify(data.grid);
                        clearErrors();
                    }
                })
                .catch(error => {
                    displayErrors(['Ocorreu um erro ao processar a requisição: ' + error.message]);
                    console.error('Erro:', error);
                });
            });

            // Função para exibir mensagens de erro
            function displayErrors(errors) {
                let html = '<div class="mb-4 p-4 bg-red-100 text-red-700 rounded"><ul>';
                errors.forEach(error => {
                    html += `<li class="list-disc list-inside">${error}</li>`;
                });
                html += '</ul></div>';
                errorMessages.innerHTML = html;
            }

            // Função para limpar mensagens de erro
            function clearErrors() {
                errorMessages.innerHTML = '';
            }
        });
    </script>
</body>
</html>
