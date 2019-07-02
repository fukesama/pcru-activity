<?php

namespace frontend\models;

use Yii;
use yii\web\UploadedFile;

/**
 * This is the model class for table "files".
 *
 * @property int $id
 * @property string $file ไฟล์
 */
class Files extends \yii\db\ActiveRecord
{
	public $uploadPath = 'uploads/file';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
    	return 'files';
    }

    public function dirFile(){
    	return Yii::getAlias('@webroot').'/'.'uploads/file';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
    	return [
    		[['file'], 'required'],
    		[['file'], 'file', 'extensions' => 'xls,xlsx,png,jpg', 'skipOnEmpty' => true],
    		[['file'], 'unique'],
    	];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
    	return [
    		'id' => 'ID',
    		'file' => 'ไฟล์',
    	];
    }   
    public function uploadFile($model, $attribute)
    {
    	$file = UploadedFile::getInstance($model, $attribute);

    	if($file){
    		if($this->isNewRecord){
    			$fileName = time().'_'.$file->baseName.'.'.$file->extension;
    		}else{
    			$fileName = $this->getOldAttribute($attribute);
    		}
    		$file->saveAs($this->dirFile().'/'.$fileName);

    		return $fileName;
    		
    	}
    	return $this->isNewRecord ? false : $this->getOldAttribute($attribute);
    }  
    // public function uploadFile2($model, $attribute)
    // {
    // 	$file = UploadedFile::getInstance($model, $attribute);

    // 	if($file){    	
    // 		if(!$this->isNewRecord){    			
    // 			@unlink($this->dirFile().'/'.$this->getOldAttribute($attribute));
    // 		}
    // 		$fileName = time().'_'.$file->baseName.'.'.$file->extension;


    // 		$file->saveAs($this->dirFile().'/'.$fileName);

    // 		return $fileName;
    // 	}
    // 	return $this->isNewRecord ? false : $this->getOldAttribute($attribute);
    // }
}
