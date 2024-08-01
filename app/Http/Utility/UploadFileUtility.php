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
     * @param string|null $modelClass
     * @param string|null $columnMappings
     * @return string|bool
     */
    public static function upload(UploadedFile $file, $destinationPath, $allowedExtensions = [], $oldFileName = null, $maxFileSizeMB = null, $modelClass = null, $columnMappings = null)
    {
        if ($file->isValid()) {
            $fileExtension = strtolower($file->getClientOriginalExtension());
            $fileSize = $file->getSize();

            if (!empty($allowedExtensions) && !in_array($fileExtension, $allowedExtensions)) {
                return false;
            }

            if ($maxFileSizeMB !== null) {
                $maxFileSize = $maxFileSizeMB * 1024 * 1024;
                if ($fileSize > $maxFileSize) {
                    return false;
                }
            }

            if (!is_dir($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }

            if ($oldFileName) {
                $oldFilePath = $destinationPath . DIRECTORY_SEPARATOR . $oldFileName;
                if (file_exists($oldFilePath)) {
                    unlink($oldFilePath);

                    if ($modelClass) {
                        $modelInstance = resolve($modelClass);
                        $modelInstance::where('file_name', $oldFileName)->delete();
                    }
                }
            }

            do {
                $uniqueHash = md5(uniqid(rand(), true));
                $uniqueFileName = substr($uniqueHash, 0, 50 - strlen($fileExtension) - 1) . "." . $fileExtension;
                $uploadPath = $destinationPath . DIRECTORY_SEPARATOR . $uniqueFileName;
            } while (file_exists($uploadPath));

            if ($file->move($destinationPath, $uniqueFileName)) {
                if ($modelClass && $columnMappings) {
                    $modelInstance = resolve($modelClass);
                    $data[$columnMappings] = $uniqueFileName;
                    $modelInstance::create($data);
                }

                return $uniqueFileName;
            }
        }

        return false;
    }
}
