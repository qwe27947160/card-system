<?php
namespace App; use Illuminate\Database\Eloquent\Model; class File extends Model { protected $guarded = array(); public $timestamps = false; function deleteFile() { try { Storage::disk($this->driver)->delete($this->path); } catch (\Exception $sp1b3a33) { \Log::error('File.deleteFile Error: ' . $sp1b3a33->getMessage(), array('exception' => $sp1b3a33)); } } public static function getProductFolder() { return 'images/product'; } }