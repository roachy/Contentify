<?php namespace App\Modules\Downloads;

use Exception, InterImage, File, SoftDeletingTrait, BaseModel;

class Download extends BaseModel {

    use SoftDeletingTrait;

    protected $dates = ['deleted_at'];

    protected $slugable = true;

    protected $fillable = ['title', 'description', 'downloadcat_id'];

    public static $fileHandling = ['file'];

    protected $rules = [
        'title'             => 'required|min:3',
        'downloadcat_id'    => 'required|integer'
    ];

    public static $relationsData = [
        'downloadcat'   => [self::BELONGS_TO, 'App\Modules\Downloads\Downloadcat'],
        'creator'       => [self::BELONGS_TO, 'User', 'title' => 'username'],
    ];

    public static function boot()
    {
        parent::boot();

        self::saving(function($download)
        {
            $filename = $download->uploadPath(true).$download->file;
            if (File::isFile($filename)) {
                $download->file_size = File::size($filename); // Save file size
                
                try {
                    $imgData = getimagesize($filename); // Try to gather infos about the image
                } catch (Exception $e) {

                }

                if (isset($imgData[2]) and $imgData[2]) {
                    $download->is_image = true;

                    /*
                     * Create Thumbnail
                     */
                    $size = 50;
                    InterImage::make($filename)->resize($size, $size, function ($constraint) {
                        $constraint->aspectRatio();
                    })->save($download->uploadPath(true).$size.'/'.$download->file); 
                }
            }
        });
    }

    /**
     * Count the comments that are related to this download.
     * 
     * @return int
     */
    public function countComments()
    {
        return Comment::count('downloads', $this->id);
    }

}