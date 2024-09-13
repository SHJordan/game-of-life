<?php

namespace App\Http\Controllers;

use App\Models\GameBoard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class GameOfLifeController extends Controller
{
    public function index()
    {
        $width = 10;
        $height = 10;
        $defaultGrid = array_fill(0, $height, array_fill(0, $width, 0));

        $gameBoard = GameBoard::firstOrCreate(['width' => $width, 'height' => $height], ['grid' => $defaultGrid]);
        return view('game-of-life', compact('gameBoard'));
    }


    public function update(Request $request, GameBoard $gameBoard)
    {
        $gridData = $request->input('grid');

        // Verifica se o grid foi fornecido
        if (!$gridData) {
            return response()->json(['error' => 'Grid de dados ausente.'], 400);
        }

        $grid = json_decode($gridData, true);

        // Verifica se o JSON foi decodificado corretamente
        if (!is_array($grid)) {
            return response()->json(['error' => 'Dados de grid inválidos.'], 400);
        }

        // Verifica as dimensões do grid
        if (count($grid) !== $gameBoard->height || count($grid[0]) !== $gameBoard->width) {
            return response()->json(['error' => 'Dimensões do grid não correspondem.'], 400);
        }

        // Inicializa o $newGrid array
        $newGrid = array_fill(0, $gameBoard->height, array_fill(0, $gameBoard->width, 0));

        for ($i = 0; $i < $gameBoard->height; $i++) {
            for ($j = 0; $j < $gameBoard->width; $j++) {
                $aliveNeighbors = 0;

                for ($x = -1; $x <= 1; $x++) {
                    for ($y = -1; $y <= 1; $y++) {
                        if ($x == 0 && $y == 0) continue;
                        $neighborX = $j + $x;
                        $neighborY = $i + $y;

                        if ($neighborX >= 0 && $neighborX < $gameBoard->width && $neighborY >= 0 && $neighborY < $gameBoard->height) {
                            $aliveNeighbors += $grid[$neighborY][$neighborX];
                        }
                    }
                }

                if ($grid[$i][$j] == 1 && ($aliveNeighbors < 2 || $aliveNeighbors > 3)) {
                    $newGrid[$i][$j] = 0;
                } elseif ($grid[$i][$j] == 0 && $aliveNeighbors == 3) {
                    $newGrid[$i][$j] = 1;
                } else {
                    $newGrid[$i][$j] = $grid[$i][$j];
                }
            }
        }

        $gameBoard->grid = $newGrid;
        $gameBoard->save();

        Log::info('Request expects JSON:', ['expectsJson' => $request->expectsJson()]);
        // Verifica se a requisição espera uma resposta JSON
        if ($request->expectsJson()) {
            Log::info('Returning JSON response');
            return response()->json(['grid' => $newGrid]);
        }
        Log::info('Redirecting back');
        return redirect()->back();
    }
}
