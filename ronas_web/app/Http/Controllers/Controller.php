<?php

namespace App\Http\Controllers;

use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Crypt;
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
                if ($isAjax) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Data sudah terdaftar (duplicate).'
                    ], 422);
                }
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

    protected function decryptId($encryptedId) {
        try {
            return Crypt::decryptString($encryptedId);
        } catch(Throwable $e) {
            return false;
        }
    }

    protected function failResponse($message, $code=400, $errors=null) {
        return response()->json([
            'status'  => 'error',
            'message' => $message,
            'errors'  => $errors,
        ], $code);
    }
}
