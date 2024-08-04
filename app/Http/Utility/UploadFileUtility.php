<?php

namespace App\Http\Utility;

use Illuminate\Http\UploadedFile;

class UploadFileUtility
{
    /**
     * Upload a file to the specified path with a custom file name.
     *
     * @param UploadedFile $file
     * @param string $destinationPath
     * @param array $allowedExtensions
     * @param string|null $oldFileName
     * @param int|null $maxFileSizeMB
     * @return array
     */
    public static function upload(UploadedFile $file, string $destinationPath, array $allowedExtensions = [], string $oldFileName = null, ?int $maxFileSizeMB = 5): array
    {
        if ($file->isValid()) {
            $fileExtension = strtolower($file->getClientOriginalExtension());
            $fileSize = $file->getSize();

            if (!empty($allowedExtensions) && !in_array($fileExtension, $allowedExtensions)) {
                return [
                    'status' => false,
                    'message' => 'File extension is not allowed.'
                ];
            }

            if ($maxFileSizeMB !== null) {
                $maxFileSize = $maxFileSizeMB * 1024 * 1024;
                if ($fileSize > $maxFileSize) {
                    return [
                        'status' => false,
                        'message' => 'File size exceeds the maximum limit.'
                    ];
                }
            }

            if (!is_dir($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }

            if ($oldFileName) {
                $oldFilePath = $destinationPath . DIRECTORY_SEPARATOR . $oldFileName;
                if (file_exists($oldFilePath)) {
                    unlink($oldFilePath);
                }
            }

            do {
                $uniqueHash = md5(uniqid(rand(), true));
                $uniqueFileName = substr($uniqueHash, 0, 50 - strlen($fileExtension) - 1) . '.' . $fileExtension;
                $uploadPath = $destinationPath . DIRECTORY_SEPARATOR . $uniqueFileName;
            } while (file_exists($uploadPath));

            if ($file->move($destinationPath, $uniqueFileName)) {
                return [
                    'status' => true,
                    'fileName' => $uniqueFileName
                ];
            }

            return [
                'status' => false,
                'message' => 'Failed to move the file to the destination path.'
            ];
        }

        return [
            'status' => false,
            'message' => 'File is not valid.'
        ];
    }

    /**
     * Retrieve the path of a file by its name from the specified directory.
     *
     * @param ?string $fileName
     * @param ?string $directoryPath
     * @return string|null
     */
    public static function getFilePath(?string $fileName, ?string $directoryPath): ?string
    {
        if ($fileName) {
            $filePath = $directoryPath . DIRECTORY_SEPARATOR . $fileName;

            if (file_exists($filePath)) {
                return $filePath;
            }

            return null;
        }
        return null;
    }
}
