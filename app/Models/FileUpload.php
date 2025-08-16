<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FileUpload extends Model
{
    use HasFactory;

    protected $table = 'file_uploads';

    protected $fillable = [
        'subject_id',
        'file_type_id',
        'unit',
        'description',
        'branch',
        'year',
        'google_file_id',
        'file_link',
        'uploaded_by',
    ];

    public $timestamps=false;
    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id');
    }

    public function fileType()
    {
        return $this->belongsTo(FileType::class, 'file_type_id');
    }

    public function uploader()
    {
        return $this->belongsTo(Registration::class, 'uploaded_by');
    }
}
