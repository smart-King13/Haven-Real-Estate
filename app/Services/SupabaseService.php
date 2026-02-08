<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SupabaseService
{
    protected $url;
    protected $key;
    protected $serviceKey;

    public function __construct()
    {
        $this->url = config('services.supabase.url');
        $this->key = config('services.supabase.key');
        $this->serviceKey = config('services.supabase.service_key');
    }

    /**
     * Get HTTP client with auth headers
     */
    protected function http($useServiceKey = false)
    {
        $key = $useServiceKey ? $this->serviceKey : $this->key;
        
        return Http::withHeaders([
            'apikey' => $key,
            'Authorization' => 'Bearer ' . $key,
            'Content-Type' => 'application/json',
            'Prefer' => 'return=representation'
        ]);
    }

    // =====================================================
    // AUTH METHODS
    // =====================================================

    /**
     * Sign up a new user
     */
    public function signUp(string $email, string $password, array $metadata = [])
    {
        try {
            $response = $this->http()->post($this->url . '/auth/v1/signup', [
                'email' => $email,
                'password' => $password,
                'data' => $metadata
            ]);

            if ($response->successful()) {
                return (object) $response->json();
            }

            // Get detailed error information
            $errorData = $response->json();
            $errorMessage = $errorData['msg'] ?? $errorData['message'] ?? $errorData['error'] ?? 'Signup failed';
            $errorCode = $errorData['error_code'] ?? null;
            
            // Log the full error for debugging
            Log::error('Supabase signup error', [
                'status' => $response->status(),
                'error' => $errorData
            ]);
            
            throw new \Exception($errorMessage);
        } catch (\Exception $e) {
            Log::error('Supabase signup exception: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Sign in with email and password
     */
    public function signIn(string $email, string $password)
    {
        try {
            $response = $this->http()->post($this->url . '/auth/v1/token?grant_type=password', [
                'email' => $email,
                'password' => $password
            ]);

            if ($response->successful()) {
                $data = $response->json();
                // Convert arrays to objects for consistency
                return json_decode(json_encode($data));
            }

            throw new \Exception($response->json()['error_description'] ?? 'Login failed');
        } catch (\Exception $e) {
            Log::error('Supabase signin error: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Sign out current user
     */
    public function signOut(string $accessToken)
    {
        try {
            $response = Http::withHeaders([
                'apikey' => $this->key,
                'Authorization' => 'Bearer ' . $accessToken
            ])->post($this->url . '/auth/v1/logout');

            return true;
        } catch (\Exception $e) {
            Log::error('Supabase signout error: ' . $e->getMessage());
            return true; // Return true anyway
        }
    }

    /**
     * Get user from access token
     */
    public function getUser(string $accessToken)
    {
        try {
            $response = Http::withHeaders([
                'apikey' => $this->key,
                'Authorization' => 'Bearer ' . $accessToken
            ])->get($this->url . '/auth/v1/user');

            if ($response->successful()) {
                return (object) $response->json();
            }

            return null;
        } catch (\Exception $e) {
            Log::error('Supabase get user error: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Verify access token
     */
    public function verifyToken(string $accessToken)
    {
        try {
            $user = $this->getUser($accessToken);
            return $user !== null;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Reset password
     */
    public function resetPassword(string $email)
    {
        try {
            $response = $this->http()->post($this->url . '/auth/v1/recover', [
                'email' => $email
            ]);

            return $response->successful();
        } catch (\Exception $e) {
            Log::error('Supabase reset password error: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Update user password
     */
    public function updatePassword(string $accessToken, string $newPassword)
    {
        try {
            $response = Http::withHeaders([
                'apikey' => $this->key,
                'Authorization' => 'Bearer ' . $accessToken
            ])->put($this->url . '/auth/v1/user', [
                'password' => $newPassword
            ]);

            if ($response->successful()) {
                return (object) $response->json();
            }

            throw new \Exception('Password update failed');
        } catch (\Exception $e) {
            Log::error('Supabase update password error: ' . $e->getMessage());
            throw $e;
        }
    }

    // =====================================================
    // DATABASE METHODS
    // =====================================================

    /**
     * Select data from table
     */
    public function select(string $table, string $columns = '*', array $conditions = [], array $options = [])
    {
        try {
            $url = $this->url . '/rest/v1/' . $table;
            $params = ['select' => $columns];

            // Apply conditions
            foreach ($conditions as $column => $value) {
                if (is_array($value)) {
                    // Handle operators
                    $operator = $value[0];
                    $val = $value[1];
                    
                    switch ($operator) {
                        case '>':
                            $params[$column] = 'gt.' . $val;
                            break;
                        case '>=':
                            $params[$column] = 'gte.' . $val;
                            break;
                        case '<':
                            $params[$column] = 'lt.' . $val;
                            break;
                        case '<=':
                            $params[$column] = 'lte.' . $val;
                            break;
                        case '!=':
                            $params[$column] = 'neq.' . $val;
                            break;
                        case 'like':
                            $params[$column] = 'like.' . $val;
                            break;
                        case 'in':
                            $params[$column] = 'in.(' . implode(',', $val) . ')';
                            break;
                    }
                } else {
                    $params[$column] = 'eq.' . $value;
                }
            }

            // Apply options
            if (isset($options['order'])) {
                $ascending = $options['order']['ascending'] ?? true;
                $params['order'] = $options['order']['column'] . '.' . ($ascending ? 'asc' : 'desc');
            }

            if (isset($options['limit'])) {
                $params['limit'] = $options['limit'];
            }

            if (isset($options['offset'])) {
                $params['offset'] = $options['offset'];
            }

            $response = $this->http()->get($url, $params);

            if ($response->successful()) {
                return (object) ['data' => $response->json()];
            }

            throw new \Exception('Select failed');
        } catch (\Exception $e) {
            Log::error("Supabase select error on {$table}: " . $e->getMessage());
            return (object) ['data' => []];
        }
    }

    /**
     * Insert data into table
     */
    public function insert(string $table, array $data, bool $useServiceKey = false)
    {
        try {
            $url = $this->url . '/rest/v1/' . $table;
            
            $response = $this->http($useServiceKey)->post($url, $data);

            if ($response->successful()) {
                return (object) ['data' => $response->json()];
            }

            $errorBody = $response->json();
            $errorMessage = $errorBody['message'] ?? 'Insert failed';
            Log::error("Supabase insert failed on {$table}", [
                'error' => $errorMessage,
                'details' => $errorBody
            ]);
            
            throw new \Exception($errorMessage);
        } catch (\Exception $e) {
            Log::error("Supabase insert error on {$table}: " . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Update data in table
     */
    public function update(string $table, array $data, array $conditions, bool $useServiceKey = false)
    {
        try {
            $url = $this->url . '/rest/v1/' . $table;
            $params = [];

            foreach ($conditions as $column => $value) {
                $params[$column] = 'eq.' . $value;
            }

            $queryString = http_build_query($params);
            $fullUrl = $url . '?' . $queryString;
            
            Log::info("Supabase UPDATE request to: {$fullUrl}" . ($useServiceKey ? ' (using service key)' : ''));

            $response = $this->http($useServiceKey)->patch($fullUrl, $data);

            Log::info("Supabase UPDATE response status: " . $response->status());

            if ($response->successful()) {
                return (object) ['data' => $response->json()];
            }

            Log::error("Supabase update failed on {$table}: " . $response->body());
            throw new \Exception('Update failed: ' . $response->body());
        } catch (\Exception $e) {
            Log::error("Supabase update error on {$table}: " . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Delete data from table
     */
    public function delete(string $table, array $conditions, bool $useServiceKey = false)
    {
        try {
            $url = $this->url . '/rest/v1/' . $table;
            $params = [];

            foreach ($conditions as $column => $value) {
                $params[$column] = 'eq.' . $value;
            }

            $queryString = http_build_query($params);
            $fullUrl = $url . '?' . $queryString;
            
            Log::info("Supabase DELETE request to: {$fullUrl}" . ($useServiceKey ? ' (using service key)' : ''));
            
            $response = $this->http($useServiceKey)->delete($fullUrl);

            Log::info("Supabase DELETE response status: " . $response->status());
            Log::info("Supabase DELETE response body: " . $response->body());

            if (!$response->successful()) {
                Log::error("Supabase delete failed on {$table}: " . $response->body());
                throw new \Exception("Delete failed: " . $response->body());
            }

            return true;
        } catch (\Exception $e) {
            Log::error("Supabase delete error on {$table}: " . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Get single record
     */
    public function findOne(string $table, array $conditions)
    {
        try {
            $result = $this->select($table, '*', $conditions, ['limit' => 1]);
            $data = $result->data ?? [];
            return !empty($data) ? (object) $data[0] : null;
        } catch (\Exception $e) {
            Log::error("Supabase findOne error on {$table}: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Count records
     */
    public function count(string $table, array $conditions = [])
    {
        try {
            $url = $this->url . '/rest/v1/' . $table;
            $params = ['select' => 'count'];

            foreach ($conditions as $column => $value) {
                $params[$column] = 'eq.' . $value;
            }

            $response = Http::withHeaders([
                'apikey' => $this->key,
                'Authorization' => 'Bearer ' . $this->key,
                'Prefer' => 'count=exact'
            ])->head($url, $params);

            if ($response->successful()) {
                $contentRange = $response->header('Content-Range');
                if ($contentRange && preg_match('/\/(\d+)$/', $contentRange, $matches)) {
                    return (int) $matches[1];
                }
            }

            return 0;
        } catch (\Exception $e) {
            Log::error("Supabase count error on {$table}: " . $e->getMessage());
            return 0;
        }
    }

    // =====================================================
    // STORAGE METHODS
    // =====================================================

    /**
     * Upload file to storage
     */
    public function uploadFile(string $bucket, string $path, $fileContents, array $options = [])
    {
        try {
            $url = $this->url . '/storage/v1/object/' . $bucket . '/' . $path;
            
            $response = Http::withHeaders([
                'apikey' => $this->key,
                'Authorization' => 'Bearer ' . $this->key,
                'Content-Type' => $options['contentType'] ?? 'application/octet-stream'
            ])->withBody($fileContents, $options['contentType'] ?? 'application/octet-stream')
              ->post($url);

            if ($response->successful()) {
                return (object) $response->json();
            }

            throw new \Exception('Upload failed');
        } catch (\Exception $e) {
            Log::error("Supabase upload error to {$bucket}/{$path}: " . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Get public URL for file
     */
    public function getPublicUrl(string $bucket, string $path)
    {
        return $this->url . '/storage/v1/object/public/' . $bucket . '/' . $path;
    }

    /**
     * Delete file from storage
     */
    public function deleteFile(string $bucket, string $path)
    {
        try {
            $url = $this->url . '/storage/v1/object/' . $bucket . '/' . $path;
            
            $response = $this->http()->delete($url);

            return $response->successful();
        } catch (\Exception $e) {
            Log::error("Supabase delete file error: " . $e->getMessage());
            throw $e;
        }
    }

    /**
     * List files in bucket
     */
    public function listFiles(string $bucket, string $path = '', array $options = [])
    {
        try {
            $url = $this->url . '/storage/v1/object/list/' . $bucket;
            
            $response = $this->http()->post($url, [
                'prefix' => $path,
                'limit' => $options['limit'] ?? 100,
                'offset' => $options['offset'] ?? 0
            ]);

            if ($response->successful()) {
                return $response->json();
            }

            return [];
        } catch (\Exception $e) {
            Log::error("Supabase list files error: " . $e->getMessage());
            return [];
        }
    }

    // =====================================================
    // HELPER METHODS
    // =====================================================

    /**
     * Get user profile by ID
     */
    public function getUserProfile(string $userId)
    {
        return $this->findOne('profiles', ['id' => $userId]);
    }

    /**
     * Update user profile
     */
    public function updateUserProfile(string $userId, array $data)
    {
        try {
            $url = $this->url . '/rest/v1/profiles';
            $params = ['id' => 'eq.' . $userId];

            // Use service key to bypass RLS
            $response = Http::withHeaders([
                'apikey' => $this->serviceKey,
                'Authorization' => 'Bearer ' . $this->serviceKey,
                'Content-Type' => 'application/json',
                'Prefer' => 'return=representation'
            ])->patch($url . '?' . http_build_query($params), $data);

            if ($response->successful()) {
                $result = $response->json();
                Log::info('Profile updated successfully', ['result' => $result]);
                return (object) ['data' => $result];
            }

            Log::error('Profile update failed', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);
            
            throw new \Exception('Update failed: ' . $response->body());
        } catch (\Exception $e) {
            Log::error("Supabase profile update error: " . $e->getMessage());
            throw $e;
        }
    }
}
