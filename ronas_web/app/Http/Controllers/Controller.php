<?php

namespace App\Http\Controllers;

use Illuminate\Database\QueryException;
use Throwable;

abstract class Controller
{
    protected function handleDatabase(callable $callback, $successMessage, $isAjax=false) {
        try {
            $callback();
            if ($isAjax) {
                return response()->json([
                    'status' => 'success',
                    'message' => $successMessage
                ]);
            }
            return back()->with('success', $successMessage);

        } catch (QueryException $e) {
            if ($e->errorInfo[1] == 1062) {
                return back()->with('error', 'Data sudah terdaftar (duplicate).');
            }
            if ($isAjax) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Terjadi kesalahan database.'
                ], 500);
            }
            return back()->with('error', 'Terjadi kesalahan database.');

        } catch (Throwable $e) {
            if ($isAjax) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Terjadi kesalahan sistem.'
                ], 500);
            }
            return back()->with('error', 'Terjadi kesalahan sistem.');
        }
    }
}
