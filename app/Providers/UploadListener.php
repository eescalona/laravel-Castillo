<?php

namespace App\Providers;

use App\Models\Project;
use App\Models\MyFile;
use Unisharp\Laravelfilemanager\Events\ImageWasUploaded;
use Unisharp\Laravelfilemanager\Events\ImageIsUploading;
use Unisharp\Laravelfilemanager\Events\ImageWasRenamed;
use Unisharp\Laravelfilemanager\Events\ImageWasDeleted;
use Unisharp\Laravelfilemanager\Events\ImageIsDeleting;
use Unisharp\Laravelfilemanager\Events\FolderIsRenaming;

use URL;

class UploadListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
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

        // Get $name and $path
        $name = pathinfo( $path, PATHINFO_FILENAME);
        $path = substr($path, strrpos($path, "public"));
        $path = URL::to($path);

        // Get $project_id
        $url = pathinfo ( $path, PHP_URL_PATH);
        $pos = strrpos($url, "/")+1;
        $pos2 = strrpos($url, "-");
        $length = $pos2 - $pos;
        $project_id =  substr( $url , $pos, $length);

        // Create MyFile
        $new_file = new MyFile();
        $new_file->name  = $name;
        $new_file->slug  = $name;
        $new_file->url = $path;
        $new_file->project_id = $project_id;
        $new_file->save();
    }

    public function onImageIsUploading(ImageIsUploading $event)
    {
        $path = $event->path();

        // Get folder Projects
        $path = pathinfo( $path, PHP_URL_PATH);
        $path = substr($path, strrpos($path, "public"));
        $path = substr($path, 0, strrpos($path, "/"));
        $project =substr($path,strrpos($path, "/")+1);

        // Get $old_project
        $path = $event->path();
        $url = pathinfo ( $path, PHP_URL_PATH);
        $pos = strrpos($url, "/")+1;
        $pos2 = strrpos($url, "-");
        $length = $pos2 - $pos;
        $project_id =  substr( $url , $pos, $length);
        $old_project = Project::where('id','=',$project_id)->first();

        if($project!=='Projects' || $old_project===null){
            dd('No se puede subir imagenes en esta carpeta.');
        }
    }

    public function onImageWasRenamed(ImageWasRenamed $event)
    {
        // image was renamed
        $old_path = $event->oldPath();
        $old_path = substr($old_path, strrpos($old_path, "public"));
        $old_path = URL::to($old_path);
        $new_path = $event->newPath();
        $new_path = substr($new_path, strrpos($new_path, "public"));
        $new_path = URL::to($new_path);

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

    public function onFolderIsRenaming(FolderIsRenaming $event)
    {
        dd('No cambies el nombre a las carpetas.');
    }

    public function onImageWasDeleted(ImageWasDeleted $event)
    {
        $path = $event->path();
        $path = substr($path, strrpos($path, "public"));
        $path = URL::to($path);
        // Get MyFile
        $file = MyFile::where('url','=',$path)->first();
        // Delete MyFile
        $file->delete();
    }

    public function onImageIsDeleting(ImageIsDeleting $event)
    {
        $path = $event->path();

        // Get folder Projects
        $path = pathinfo( $path, PHP_URL_PATH);
        $path = substr($path, strrpos($path, "public"));
        $path = substr($path, 0, strrpos($path, "/"));
        $project =substr($path,strrpos($path, "/")+1);

        // Get $old_project
        $path = $event->path();
        $url = pathinfo ( $path, PHP_URL_PATH);
        $pos = strrpos($url, "/")+1;
        $pos2 = strrpos($url, "-");
        $length = $pos2 - $pos;
        $project_id =  substr( $url , $pos, $length);
        $old_project = Project::where('id','=',$project_id)->first();

        if($project!=='Projects' || $old_project===null){
            dd('No se puede eliminar imagenes en esta carpeta.');
        }
    }
}