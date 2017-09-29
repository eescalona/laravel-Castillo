<?php

namespace App\Providers;

use App\Repositories\MyFileRepository;
use Unisharp\Laravelfilemanager\Events\ImageWasUploaded;
use Unisharp\Laravelfilemanager\Events\ImageWasRenamed;
use Unisharp\Laravelfilemanager\Events\ImageWasDeleted;

use App\Models\MyFile;

class UploadListener
{

    private $myFileRepository;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(MyFileRepository $myRepo)
    {
        $this->myFileRepository = $myRepo;
    }

    public function subscribe($events)
    {
        $events->listen('*', UploadListener::class);
    }

    public function handle($event)
    {
        $method = 'on' . class_basename($event);
        if (method_exists($this, $method)) {
            call_user_func([$this, $method], $event);
        }
    }

    public function onImageWasUploaded(ImageWasUploaded $event)
    {
        $path = $event->path();

        // Get $project_id
        $name = pathinfo( $path, PATHINFO_FILENAME);
        $url = pathinfo ( $path, PHP_URL_PATH);
        $pos = strrpos($url, "\\")+1;
        $project_id =  substr( $url , $pos );

        // Create MyFile
        $new_file = new MyFile();
        $new_file->name  = $name;
        $new_file->slug  = $name;
        $new_file->url = $path;
        $new_file->project_id = $project_id;
        $new_file->save();
    }

    public function onImageWasDeleted(ImageWasDeleted $event)
    {
        $path = $event->path();
        // Get MyFile
        $file = MyFile::where('url','=',$path)->first();

        // Delete MyFile
        $file->save();
    }

    public function onImageWasRenamed(ImageWasRenamed $event)
    {
        // image was renamed
        $old_path = $event->oldPath();
        $new_path = $event->newPath();

        // Get $new_name
        $new_name = pathinfo( $new_path, PATHINFO_FILENAME);

        // Get MyFile
        $file = MyFile::where('url','=',$old_path)->first();

        // Upload MyFile
        $file->name  = $new_name;
        $file->slug  = $new_name;
        $file->url = $new_path;
        $file->save();
    }



}