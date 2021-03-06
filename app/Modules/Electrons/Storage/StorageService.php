<?php

namespace App\Modules\Electrons\Storage;

use Carbon\Carbon;
use App\Modules\Nucleons\Service;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class StorageService extends Service
{
    /*
     | STORAGE SERVICE
     | ========================================
     | Types:   Profile     =>      /profiles
     |          Activity    =>      /activities
     |          Submission  =>      /submits
     |          Document    =>      /documents
     |          Question    =>      /questions
     |          Choice      =>      /choices
     |          Gallery     =>      /galleries
     |          News        =>      /news
     |          Sponsor     =>      /sponsors
     |          Imports     =>      /imports
     |          Exports     =>      /exports
     |
     | Webdata: Slides      =>      /slides
     |
     */

    /**
     * The trailing path to the storage.
     *
     * @var User
     */
    protected $trailing = 'storage';

    /**
     * Upload a file and return the link.
     *
     * @param  array  $params
     * @return string
     */
    public function upload(array $params)
    {
        $link = $this->putOnStorage(
            $params['object_id'], $params['object_type'], $params['file']
        );

        return $this->putTrailing($link);
    }

    /**
     * Remove a file under specified link.
     *
     * @param  string  $link
     * @return this
     */
    public function remove($link)
    {
        $link = $this->eraseTrailing($link);

        $this->removeFromStorage($link);

        return $this;
    }

    /**
     * Destroy a directory of specified mime, id and type.
     *
     * @param  string  $mime
     * @param  int     $objectId
     * @param  string  $objectType
     * @return this
     */
    public function destroy($mime, $objectId, $objectType)
    {
        $this->removeDirectoryFromStorage(
            $this->makePath($mime, $objectId, $objectType)
        );

        return $this;
    }

    /**
     * Put the trailing path to the link.
     *
     * @param  string  $link
     * @return string  
     */
    public function putTrailing($link)
    {
        return $this->trailing . '/' . $link;
    }

    /**
     * Erase the trailing path from the link.
     *
     * @param  string  $link
     * @return string  
     */
    public function eraseTrailing($link)
    {
        return implode('/', array_slice(explode('/', $link), 1));
    }

    /**
     * Returns an ideal file name determined by the specified id and type. 
     *
     * @param  int     $objectId
     * @param  string  $objectType
     * @param  string  $extension
     * @return string
     */
    public function makeName($objectId, $objectType, $extension)
    {
        return Carbon::now()->timestamp . '-' . $objectId . '-' . $objectType . '.' . $extension;
    }

    /**
     * Returns a storage directory path to the specified mime, id and type. 
     *
     * @param  string  $mime
     * @param  int     $objectId
     * @param  string  $objectType
     * @return string
     */
    public function makePath($mime, $objectId, $objectType)
    {
        return $mime . '/' . str_plural($objectType) . '/' . $objectId;
    }

    /**
     * Put the file on the storage and return its link.
     *
     * @param  int           $objectId
     * @param  string        $objectType
     * @param  UploadedFile  $file
     * @return User
     */
    protected function putOnStorage($objectId, $objectType, UploadedFile $file)
    {
        $directory = $this->makePath($this->detectMime($file), $objectId, $objectType);

        if (! Storage::exists($directory)) {
            Storage::makeDirectory($directory);
        }

        return $file->storeAs($directory, $this->makeName($objectId, $objectType, $file->extension()), 'public');
    }

    /**
     * Delete a file from storage under specified path.
     *
     * @param  string  $path
     * @return void
     */
    protected function removeFromStorage($path)
    {
        if (Storage::exists($path)) {
            Storage::delete($path);
        }
    }

    /**
     * Empty and delete directory under specified path.
     *
     * @param  string  $path
     * @return void
     */
    protected function removeDirectoryFromStorage($path)
    {
        if (Storage::exists($path)) {
            Storage::deleteDirectory($path);
        }
    }

    /**
     * Get the directory based the mimetype of file.
     *
     * @param  UploadedFile  $file
     * @return string  
     */
    protected function detectMime(UploadedFile $file)
    {
        switch (File::mimeType($file->path())) {
            case 'image/jpeg': case 'image/jpg': case 'image/png': case 'image/gif':
                return 'images';
            default:
                return 'others';
        }
    }
}
