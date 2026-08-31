<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Encryption & Decryption Helper for URL Parameters & Identifiers
 * 
 * Menggunakan OpenSSL AES-256-CBC dengan HMAC-SHA256 integrity check (Encrypt-then-MAC)
 * dan Base64 URL-Safe encoding (tanpa karakter '+', '/', atau '=' yang melanggar permitted_uri_chars).
 * Dilengkapi multi-fallback generator IV untuk kompatibilitas penuh di semua versi/ekstensi PHP.
 * 
 * @author BeRewards Core Engine
 * @version 1.0.1
 */

if (!function_exists('generate_secure_iv')) {
    /**
     * Menghasilkan random bytes yang aman dengan fallback multi-lapisan
     * 
     * @param int $length
     * @return string
     */
    function generate_secure_iv($length = 16)
    {
        if (function_exists('random_bytes')) {
            try {
                return random_bytes($length);
            } catch (Throwable $e) {
                // Fallback ke openssl jika random_bytes gagal
            }
        }

        if (function_exists('openssl_random_pseudo_bytes')) {
            $bytes = openssl_random_pseudo_bytes($length, $crypto_strong);
            if ($bytes !== false) {
                return $bytes;
            }
        }

        // Fallback deterministik berbasis entropi hash
        $output = '';
        while (strlen($output) < $length) {
            $output .= hash('sha256', uniqid((string) mt_rand(), true) . microtime(true), true);
        }
        return substr($output, 0, $length);
    }
}

if (!function_exists('get_encryption_secret_key')) {
    /**
     * Mengambil kunci enkripsi 32-byte dari konfigurasi CodeIgniter
     * 
     * @return string Raw 32-byte binary key
     */
    function get_encryption_secret_key()
    {
        $CI = get_instance();
        $key = $CI->config->item('encryption_key');
        if (empty($key)) {
            $key = 'berewards_default_secure_secret_key_2026_topsis_court';
        }
        return hash('sha256', (string) $key, true);
    }
}

if (!function_exists('encrypt_id')) {
    /**
     * Enkripsi ID numerik / string menjadi token URL-safe yang aman dan acak
     * 
     * @param int|string $id
     * @return string URL-safe encrypted token
     */
    function encrypt_id($id)
    {
        if ($id === NULL || $id === '') {
            return '';
        }

        $key = get_encryption_secret_key();
        $iv = generate_secure_iv(16);
        $raw_encrypted = openssl_encrypt((string) $id, 'AES-256-CBC', $key, OPENSSL_RAW_DATA, $iv);

        if ($raw_encrypted === false) {
            return '';
        }

        $hmac = hash_hmac('sha256', $iv . $raw_encrypted, $key, true);
        $payload = $iv . $hmac . $raw_encrypted;

        // URL-safe Base64: ganti '+' dengan '-', '/' dengan '_', dan hapus '='
        return rtrim(strtr(base64_encode($payload), '+/', '-_'), '=');
    }
}

if (!function_exists('decrypt_id')) {
    /**
     * Dekripsi token URL-safe kembali ke nilai ID asli (integer atau string).
     * Mengembalikan FALSE jika token tidak valid, rusak, atau telah dimanipulasi.
     * 
     * @param string $encrypted_token
     * @return int|string|false
     */
    function decrypt_id($encrypted_token)
    {
        if (empty($encrypted_token) || !is_string($encrypted_token)) {
            return false;
        }

        // Kembalikan karakter URL-safe ke Base64 standar
        $b64 = strtr($encrypted_token, '-_', '+/');
        $remainder = strlen($b64) % 4;
        if ($remainder) {
            $b64 .= str_repeat('=', 4 - $remainder);
        }

        $payload = base64_decode($b64, true);
        if ($payload === false || strlen($payload) < 49) {
            return false;
        }

        $iv = substr($payload, 0, 16);
        $hmac = substr($payload, 16, 32);
        $raw_encrypted = substr($payload, 48);

        $key = get_encryption_secret_key();
        $expected_hmac = hash_hmac('sha256', $iv . $raw_encrypted, $key, true);

        // Verifikasi HMAC dengan perbandingan waktu-konstan
        if (!hash_equals($hmac, $expected_hmac)) {
            return false;
        }

        $decrypted = openssl_decrypt($raw_encrypted, 'AES-256-CBC', $key, OPENSSL_RAW_DATA, $iv);
        if ($decrypted === false) {
            return false;
        }

        return is_numeric($decrypted) ? (int) $decrypted : $decrypted;
    }
}

if (!function_exists('encode_id')) {
    /**
     * Alias untuk encrypt_id()
     */
    function encode_id($id)
    {
        return encrypt_id($id);
    }
}

if (!function_exists('decode_id')) {
    /**
     * Alias untuk decrypt_id()
     */
    function decode_id($encrypted_token)
    {
        return decrypt_id($encrypted_token);
    }
}
