<?php
namespace common\upload;

use Yii;
class ImageUploaderException extends \Exception
{

    public function customFunction()
    {
        $code = json_encode([
            'code' => '-1',
            'message' => $this->message
        ]);
        return $code;
    }
}

class BulletProof
{


    /*--------------------------------------------------------------------------
    |  UPLOAD: Image upload class properties                                   |
    *--------------------------------------------------------------------------*/

    /**
     * Set a group of default image types to upload.
     *
     * @var array
     */
    private $fileTypesToUpload = ["jpg", "jpeg", "png", "gif"];

    /**
     * Set a default file size to upload. Values are in bytes. Remember: 1kb ~ 1000 bytes.
     *`
     * @var array
     */
    private $allowedUploadSize = ["min" => 1, "max" => 30000];

    /**
     * Default & maximum allowed height and width image to upload.
     *
     * @var array
     */
    private $imageDimension = ["height" => 4000, "width" => 4000];

    /**
     * Set a default folder to upload images, if it does not exist, it will be created.
     *
     * @var string
     */
    private $fileUploadDirectory = "uploads";

    /**
     * To get the real image/mime type. i.e gif, jpeg, png, ....
     *
     * @var string
     */
    private $getMimeType;


    private $useDateFolder = '1';
    /*--------------------------------------------------------------------------
    |   IMAGE RESIZE & CROP  |   Properties                                     |
    ---------------------------------------------------------------------------*/

    /**
     * Image dimensions for resizing ex: array("height"=>100, "width"=>100)
     *
     * @var array
     */
    private $imageResizeDimensions = [];

    /**
     * New image dimensions for image cuting ex: array("height"=>100, "width"=>100)
     *
     * @var array
     */
    private $imageCutDimension = [];


    /*-----------------------------------------------------------------------------
    |    WATERMARK  | Image Watermark Properties                                   |
    ----------------------------------------    -----------------------------------*/

    /**
     * Name of the image to use as a watermark. ( best to use a png  image )
     *
     * @var
     */
    private $getImageToWatermark;

    /**
     * Watermark Position. (Where to put the watermark). ex: 'center', 'top-right', 'bottom-left'....
     *
     * @var
     */
    private $getWatermarkPosition;

    /**
     * Size, store ( Width & Height ) of the watermark ex: 'array("height"=>40, "width"=>20)'.
     *
     * @var
     */
    private $getWatermarkDimensions;

    private $waterNamePrefix = 'water_';
    private $cutNamePrefix = 'cut_';
    private $resizeNamePrefix = 'resize_';
    private $fileName;
    private $isFile = false;


    /*--------------------------------------------------------------------------
    |    UPLOADING  | General Uploading Methods                                |
    ---------------------------------------------------------------------------*/

    public function forFile(bool $type = true)
    {
        $this->isFile = $type;
        return $this;
    }

    /**
     * For passing the image/mime types to upload.
     *
     * @param array $fileTypes -  ex: ['jpg', 'doc', 'txt'].
     * @return $this
     */
    public function fileTypes(array $fileTypes)
    {
        $this->fileTypesToUpload = $fileTypes;
        return $this;
    }


    /**
     * Minimum and Maximum allowed image size for upload (in bytes),
     *
     * @param array $fileSize - ex: ['min'=>500, 'max'=>1000]
     * @return $this
     */
    public function limitSize(array $fileSize)
    {
        $this->allowedUploadSize = $fileSize;
        return $this;
    }


    /**
     * Default & maximum allowed height and width image to download.
     *
     * @param array $dimensions
     * @return $this
     */
    public function limitDimension(array $dimensions)
    {
        $this->imageDimension = $dimensions;
        return $this;
    }


    /**
     * Get the real file's Extension/mime type
     *
     * @param $imageName
     * @return mixed
     * @throws ImageUploaderException
     */
    public function getMimeType($imageName)
    {
        if (!file_exists($imageName)) {
            throw new ImageUploaderException("File '" . $imageName . "' does not exist " . __FUNCTION__);
        }
        $listOfMimeTypes = [
            1 => "gif", "jpeg", "png", "swf", "psd",
            "bmp", "tiff", "tiff", "jpc", "jp2",
            "jpx", "jb2", "swc", "iff", "wbmp",
            "xmb", "ico"
        ];
        if (isset($listOfMimeTypes[exif_imagetype($imageName)])) {
            return $listOfMimeTypes[exif_imagetype($imageName)];
        }
    }

    public function getFileType($fileToUpload)
    {

        if (!file_exists($fileToUpload['tmp_name'])) {
            throw new ImageUploaderException("File '" . $fileToUpload['tmp_name'] . "' does not exist " . __FUNCTION__);
        }

        return strtolower(substr(strrchr($fileToUpload['name'], "."), 1));
    }


    /**
     * Handy method for getting image dimensions (W & H) in pixels.
     *
     * @param $getImage - The image name
     * @return array
     */
    private function getImagePixels($getImage)
    {
        //$getImage =	ROOT_PATH.'./'.$getImage;
        list($width, $height) = getImageSize($getImage);
        return array($width, $height);
    }


    /**
     * Rename file either from method or by generating a random one.
     *
     * @param $isNameProvided - A new name for the file.
     * @return string
     */
    private function createFileName($isNameProvided)
    {
        if ($isNameProvided) {
            $this->fileName = $isNameProvided . "." . $this->getMimeType;
        } else {
            $this->fileName = uniqid(true) . "_" . str_shuffle(implode(range("E", "Q"))) . "." . $this->getMimeType;
        }

        return $this->fileName;
    }


    /**
     * Get the specified upload dir, if it does not exist, create a new one.
     *
     * @param $nameOfDir - directory name where you want your files to be uploaded
     * @return $this
     * @throws ImageUploaderException
     */
    public function folder($nameOfDir)
    {
        if (!file_exists($nameOfDir) && !is_dir($nameOfDir)) {
            $createFolder = mkdir("" . $nameOfDir, 0777);
            if (!$createFolder) {
                throw new ImageUploaderException("Folder " . $nameOfDir . " could not be created");
            }
        }

        if ($this->useDateFolder) {
            $year = date("Y");
            $day = date("m") . date("d");
            $nameOfDir .= '/' . $year;
            if (!is_dir($nameOfDir)) {
                $createFolder = mkdir("" . $nameOfDir, 0777);
                if (!$createFolder) {
                    throw new ImageUploaderException("Folder " . $nameOfDir . " could not be created");
                }
            }
            $nameOfDir .= '/' . $day;
            if (!is_dir($nameOfDir)) {
                $createFolder = mkdir("" . $nameOfDir, 0777);
                if (!$createFolder) {
                    throw new ImageUploaderException("Folder " . $nameOfDir . " could not be created");
                }
            }

        }

        $this->fileUploadDirectory = $nameOfDir;
        return $this;
    }


    public function setDateFolder($type = true)
    {
        if ($type) {
            $this->useDateFolder = true;
        } else {
            $this->useDateFolder = false;
        }
        return $this;
    }

    /**
     * For getting common error messages from FILES[] array during upload.
     *
     * @return array
     */
    private function commonFileUploadErrors($errorType)
    {
        $errors = array(
            "ok",    //UPLOAD_ERR_OK
            "File is larger than the specified amount set by the server",    //UPLOAD_ERR_INI_SIZE
            "Files is larger than the specified amount specified by browser",    //UPLOAD_ERR_FORM_SIZE
            "File could not be fully uploaded. Please try again later",    //UPLOAD_ERR_PARTIAL
            "File is not found",    //UPLOAD_ERR_NO_FILE
            "Can't write to disk, as per server configuration",    //UPLOAD_ERR_NO_TMP_DIR
            "Failed to write file to disk. Introduced in PHP",    //UPLOAD_ERR_CANT_WRITE
            "A PHP extension has halted this file upload"   //UPLOAD_ERR_EXTENSION
        );
        return $errors[$errorType];
    }



    /*--------------------------------------------------------------------------
    |    WATERMARK  | Image Watermark methods                                   |
    *--------------------------------------------------------------------------*/

    /**
     * Get the watermark image and its position.
     *
     * @param $watermark - the watermark name, ex: 'logo.png'
     * @param $positionToWatermark - position to put the watermark, ex: 'center'
     * @return $this
     * @throws ImageUploaderException
     */
    public function watermark($watermark, $positionToWatermark, $waterNamePrefix = '')
    {
        if (!file_exists($watermark)) {
            throw new ImageUploaderException(" Please provide valid image to use as watermark ");
        }
        $this->getImageToWatermark = $watermark;
        $this->getWatermarkPosition = $positionToWatermark;

        $num = func_num_args();
        if ($num == 3)
            $this->waterNamePrefix = $waterNamePrefix;
        return $this;
    }


    /**
     * Calculate position and apply image watermark.
     *
     * The objective is to let position of watermarking be passed in simple English words like:
     * 'center', 'right-top', 'bottom-left'.. as the second argument for the 'watermark()' method
     * then take that word and do the real offset & marginal-calculation in this method.
     *
     * @param $imageToUpload
     * @throws ImageUploaderException
     */
    private function applyImageWatermark($imageToUpload)
    {

        if (!$this->getImageToWatermark) {
            return;
        }

        // Calculate the watermark position
        $watermark = $this->getImageToWatermark;
        $position = $this->getWatermarkPosition;
        list($imgWidth, $imgHeight) = $this->getImagePixels($imageToUpload);
        list($watWidth, $watHeight) = $this->getImagePixels($watermark);

        switch ($position) {
            case "center":
                $bottomPosition = (int)ceil($imgHeight / 2);
                $rightPosition = (int)ceil($imgWidth / 2) - (int)ceil($watWidth / 2);
                break;

            case "bottom-left":
                $bottomPosition = 5;
                $rightPosition = (int)round($imgWidth - $watWidth);
                break;

            case "top-left":
                $bottomPosition = (int)round($imgHeight - $watHeight);
                $rightPosition = (int)round($imgWidth - $watWidth);
                break;

            case "top-right":
                $bottomPosition = (int)round($imgHeight - $watHeight);
                $rightPosition = 5;
                break;

            default:
                // bottom-right
                $bottomPosition = 2;
                $rightPosition = 2;
                break;
        }


        // Apply the watermark using the calculated position
        $this->getWatermarkDimensions = $this->getImagePixels($watermark);

        $imageType = $this->getMimeType($imageToUpload);
        $watermark = imagecreatefrompng($watermark);


        switch ($imageType) {
            case "jpeg":
            case "jpg":
                $createImage = imagecreatefromjpeg($imageToUpload);
                break;

            case "png":
                $createImage = imagecreatefrompng($imageToUpload);
                break;

            case "gif":
                $createImage = imagecreatefromgif($imageToUpload);
                break;

            default:
                $createImage = imagecreatefromjpeg($imageToUpload);
                break;
        }


        $sx = imagesx($watermark);
        $sy = imagesy($watermark);

        imagecopy(
            $createImage,
            $watermark,
            imagesx($createImage) - $sx - $rightPosition,
            imagesy($createImage) - $sy - $bottomPosition,
            0,
            0,
            imagesx($watermark),
            imagesy($watermark)
        );

        if ($this->waterNamePrefix) {
            $newName = $this->fileUploadDirectory . "/" . $this->waterNamePrefix . '_' . $this->fileName;
            //$newName = $this->fileUploadDirectory.'/'.$this->waterNamePrefix.'.'.$imageType;
        } else {
            $newName = $imageToUpload;
        }


        switch ($imageType) {
            case "jpeg":
            case "jpg":
                imagejpeg($createImage, $newName);
                break;

            case "png":
                imagepng($createImage, $newName);
                break;

            case "gif":
                imagegif($createImage, $newName);
                break;

            default:
                throw new ImageUploaderException("A watermark can only be applied to: jpeg, jpg, gif, png images ");
                break;
        }
    }



    /*--------------------------------------------------------------------------
    |    SHRINK  | Image resize/resize  methods                                |
    ---------------------------------------------------------------------------*/

    /**
     * Get the Width and Height of the image image to resize (in pixels)
     *
     * @param array $setImageDimensions
     * @return $this
     */
    public function resize(array $setImageDimensions, $resizeNamePrefix = '')
    {
        $this->imageResizeDimensions = $setImageDimensions;

        /*
		$num = func_num_args();
		if($num == 2)				
		$this->resizeNamePrefix = $resizeNamePrefix;
        */
        return $this;
    }


    /**
     * Resize the image.
     *
     * @param $fileName - the file name
     * @param $fileToUpload - the file to upload
     * @throws ImageUploaderException
     */
    private function applyImageResize($fileName, $fileToUpload)
    {

        if (!$this->imageResizeDimensions) {
            return;
        }

        list($width, $height) = $this->getImagePixels($fileToUpload);
        foreach ($this->imageResizeDimensions as $prefix => $options) {
            $newWidth = $options['width'];
            $newHeight = $options['height'];

            if ($newWidth * $newHeight <= 0) {
                throw new ImageUploaderException(" The newWidth or newHeight is incorrect! ");
            }
            if ($newWidth > $width && $newHeight > $height) {
                $newWidth = $width;
                $newHeight = $height;
                //throw new ImageUploaderException(" The newWidth or newHeight can not large than source!  ");
            }

            $rate_w = $newWidth / $width;
            $rate_h = $newHeight / $height;

            if ($rate_w <= $rate_h) {
                $newWidth = $newWidth;
                $newHeight = round($height * $rate_w);
            } else {
                $newHeight = $newHeight;
                $newWidth = round($width * $rate_h);
            }

            $imgString = file_get_contents($fileToUpload);

            $image = imagecreatefromstring($imgString);
            $tmp = imagecreatetruecolor($newWidth, $newHeight);
            imagecopyresampled(
                $tmp,
                $image,
                0,
                0,
                0,
                0,
                $newWidth,
                $newHeight,
                $width,
                $height
            );

            $mimeType = $this->getMimeType($fileToUpload);

            $newName = $this->fileUploadDirectory . "/" . $prefix . '_' . $this->fileName;

            switch ($mimeType) {
                case "jpeg":
                case "jpg":
                    imagejpeg($tmp, $newName, 100);
                    break;
                case "png":
                    imagepng($tmp, $newName, 0);
                    break;
                case "gif":
                    imagegif($tmp, $newName);
                    break;
                default:
                    throw new ImageUploaderException(" Only jpg, jpeg, png and gif files can be resized ");
                    break;
            }
        }
    }


    /*--------------------------------------------------------------------------
    |    CROPPING | Image cuting methods                                     |
    ---------------------------------------------------------------------------*/

    /**
     * Get size dimensions to use for new image cuting
     *
     * @param array $imageCutValues
     * @return $this
     */
    public function cut(array $imageCutValues, $cutNamePrefix = '')
    {
        $this->imageCutDimension = $imageCutValues;

        $num = func_num_args();
        if ($num == 2)
            $this->cutNamePrefix = $cutNamePrefix;
        return $this;

    }


    /**
     * Apply cut image, from the given size
     *
     * @param $imageName
     * @param $tmp_name
     * @return resource
     * @throws ImageUploaderException
     */
    private function applyImageCutping($imageName, $tmp_name)
    {

        if (!$this->imageCutDimension) {
            return;
        }

        $mimeType = $this->getMimeType($tmp_name);

        switch ($mimeType) {
            case "jpg":
            case "jpeg":
                $image = imagecreatefromjpeg($tmp_name);
                break;

            case "png":
                $image = imagecreatefrompng($tmp_name);
                break;

            case "gif":
                $image = imagecreatefromgif($tmp_name);
                break;

            default:
                throw new ImageUploaderException(" Only gif, jpg, jpeg and png files can be cutped ");
                break;
        }


        // Uploaded image pixels.
        list($imgWidth, $imgHeight) = $this->getImagePixels($tmp_name);

        // Size given for cuting image.
        $heightToCut = $this->imageCutDimension["height"];
        $widthToCut = $this->imageCutDimension["width"];

        // The image offsets/coordination to cut the image.
        $widthTrim = ceil(($imgWidth - $widthToCut) / 2);
        $heightTrim = ceil(($imgHeight - $heightToCut) / 2);

        // Can't cut a 100X100 image, to 200X200. Image can only be cutped to smaller size.
        if ($widthTrim < 0 && $heightTrim < 0) {
            return;
        }

        $temp = imagecreatetruecolor($widthToCut, $heightToCut);
        imagecopyresampled(
            $temp,
            $image,
            0,
            0,
            $widthTrim,
            $heightTrim,
            $widthToCut,
            $heightToCut,
            $widthToCut,
            $heightToCut
        );


        if (!$temp) {
            throw new ImageUploaderException("Failed to cut image. Please pass the right parameters");
        } else {
            if ($this->cutNamePrefix) {
                $newName = $this->fileUploadDirectory . "/" . $this->cutNamePrefix . '_' . $this->fileName;
            } else {
                $newName = $tmp_name;
            }
            imagejpeg($temp, $newName);
        }

    }



    /*--------------------------------------------------------------------------
    |    Change file |  cut/watermark/resize methods. without uploading        |
    ---------------------------------------------------------------------------*/

    /**
     * Without uploading, just cut/watermark/resize all images in your folders
     *
     * @param $directive - the task.. ex: 'cut', 'watermark', 'resize'...
     * @param $imageName - the image you want to change. Provide full path pls.
     * @throws ImageUploaderException
     */
    public function change($directive, $imageName)
    {

        if (empty($directive) || !file_exists($imageName)) {
            throw new ImageUploaderException(__FUNCTION__ . " Requires image name and array directive ");
        }

        $tasks = array("watermark", "resize", "cut");
        switch ($directive) {
            case "watermark":
                if (!$this->getWatermarkPosition || !$this->getImageToWatermark) {
                    throw new ImageUploaderException("Please provide 'watermark' and 'position' by using the 'watermark()' method");
                }
                // Apply watermark to image
                $this->applyImageWatermark($imageName);
                break;

            case "resize":
                if (!$this->imageResizeDimensions) {
                    throw new ImageUploaderException("Please provide 'width * height' dimensions by using 'resize()' method ");
                }
                // Resize or cut the image
                $this->applyImageResize($imageName, $imageName);
                break;

            case "cut":
                if (!$this->imageCutDimension) {
                    throw new ImageUploaderException("Please provide 'width * height' dimensions by using 'resize()' method ");
                }
                // Cut the image
                $this->applyImageCutping($imageName, $imageName);
                break;

            default:
                throw new ImageUploaderException(__FUNCTION__ . " Expects either " . implode(", ", $tasks) . " as second argument");
                break;
        }
    }


    /**
     * Simple file check and delete wrapper.
     *
     * @param $fileToDelete
     * @return bool
     * @throws ImageUploaderException
     */
    public function deleteFile($fileToDelete)
    {
        if (file_exists($fileToDelete) && !unlink($fileToDelete)) {
            throw new ImageUploaderException("File may have been deleted or does not exist");
        }

        return true;
    }

    /**
     * multi upload
     *
     * @param $fileldName
     * @param null $nameArray
     * @return string/array
     * @throws ImageUploaderException
     */
    public function uploadAll($fieldKey, $nameArray = null)
    {
        if (!isset($_FILES[$fieldKey])) {
            throw new ImageUploaderException('fieldKey:' . $fieldKey . ' is incorrect!');
        }
        if ($nameArray && !is_array($nameArray)) {
            throw new ImageUploaderException('$nameArray must be array');
        }

        $formFile = $_FILES[$fieldKey];
        $files = [];


        if (is_array($formFile['name'])) {
            foreach ($formFile['name'] as $k => $v) {
                $file = array(
                    'name' => $formFile['name'][$k],
                    'error' => $formFile['error'][$k],
                    'size' => $formFile['size'][$k],
                    'type' => $formFile['type'][$k],
                    'tmp_name' => $formFile['tmp_name'][$k]
                );

                if ($file['name']) {
                    if ($file['error']) {
                        $error = $this->commonFileUploadErrors($file['error']);
                        throw new ImageUploaderException("ERROR " . $error);
                    }
                    $files[] = $file;
                }

            }
        } else {
            $file = $formFile;
            if ($file['name']) {
                if ($file['error']) {
                    $error = $this->commonFileUploadErrors($file['error']);
                    throw new ImageUploaderException("ERROR " . $error);
                }
                $files[] = $file;
            }

        }

        foreach ($files as $k => $v) {
            $name = isset($nameArray[$k]) ? $nameArray[$k] : '';
            if ($this->isFile) {
                $result[] = $this->upload_file($v, $name);
            } else {
                $result[] = $this->upload($v, $name);
            }

        }
        return count($result) > 1 ? $result : $result[0];
    }

    /**
     * Final image uploader method, to check for errors and upload
     *
     * @param $fileToUpload
     * @param null $isNameProvided
     * @return string
     * @throws ImageUploaderException
     */
    public function upload($fileToUpload, $isNameProvided = null)
    {
        // First get the real file extension
        $this->getMimeType = $this->getMimeType($fileToUpload["tmp_name"]);
        // Check if this file type is allowed for upload
        if (!in_array($this->getMimeType, $this->fileTypesToUpload)) {
            throw new ImageUploaderException(" This is not allowed file type!
             Please only upload ( " . implode(", ", $this->fileTypesToUpload) . " ) file types");
        }

        // Check if any errors are thrown by the FILES[] array
        //if ($fileToUpload['error']) {
        //    $temp = $this->commonFileUploadErrors();
        //     throw new ImageUploaderException("ERROR " . $temp[$fileToUpload['error']]);
        //}

        // Check if size (in bytes) of the image is above or below of defined in 'sizeLimit()' 
        if ($fileToUpload["size"] <= $this->allowedUploadSize["min"] ||
            $fileToUpload["size"] >= $this->allowedUploadSize["max"]
        ) {
            throw new ImageUploaderException("File sizes must be between " .
                implode(" to ", $this->allowedUploadSize) . " bytes");
        }

        // check if image is valid pixel-wise.
        list($imgWidth, $imgHeight) = $this->getImagePixels($fileToUpload["tmp_name"]);
        if ($imgWidth < 1 || $imgHeight < 1) {
            throw new ImageUploaderException("This file is either too small or corrupted to be an image file");
        }

        if ($imgWidth > $this->imageDimension["width"] || $imgHeight > $this->imageDimension["height"]) {
            throw new ImageUploaderException("The allowed file dimensions are " . implode(", ", $this->imageDimension) . " pixels");
        }

        // Assign given name or generate a new one.
        $newFileName = $this->createFileName($isNameProvided);
        $filePath = $this->fileUploadDirectory . "/" . $newFileName;

        $this->applyImageWatermark($fileToUpload["tmp_name"]);

        $this->applyImageResize($newFileName, $fileToUpload["tmp_name"]);

        $this->applyImageCutping($newFileName, $fileToUpload["tmp_name"]);

        // Security check, to see if file was uploaded with HTTP_POST 
        $checkSafeUpload = is_uploaded_file($fileToUpload["tmp_name"]);

        // Upload the file
        $moveUploadedFile = move_uploaded_file($fileToUpload["tmp_name"], $filePath);

        if ($checkSafeUpload && $moveUploadedFile) {

            $output = [
                'filename' => substr($filePath, strlen(PUBLIC_PATH)),
                'size' => $fileToUpload["size"],
                'ext' => $this->getMimeType,
            ];
            //$output = substr($filePath, strlen(PUBLIC_PATH));
            //$output = realpath($filePath);
            return $output;
        } else {
            throw new ImageUploaderException(" File could not be uploaded. Unknown error occurred. ");
        }
    }

    /**
     * Final image uploader method, to check for errors and upload
     *
     * @param $fileToUpload
     * @param null $isNameProvided
     * @return string
     * @throws ImageUploaderException
     */
    public function upload_file($fileToUpload, $isNameProvided = null)
    {
        // First get the real file extension

        $this->getMimeType = $this->getFileType($fileToUpload);

        // Check if this file type is allowed for upload
        if (!in_array($this->getMimeType, $this->fileTypesToUpload)) {
            throw new ImageUploaderException(" This is not allowed file type!
             Please only upload ( " . implode(", ", $this->fileTypesToUpload) . " ) file types");
        }

        // Check if size (in bytes) of the image is above or below of defined in 'sizeLimit()'
        if ($fileToUpload["size"] <= $this->allowedUploadSize["min"] ||
            $fileToUpload["size"] >= $this->allowedUploadSize["max"]
        ) {
            throw new ImageUploaderException("File sizes must be between " .
                implode(" to ", $this->allowedUploadSize) . " bytes");
        }

        // Assign given name or generate a new one.
        $newFileName = $this->createFileName($isNameProvided);
        $filePath = $this->fileUploadDirectory . "/" . $newFileName;

        // Security check, to see if file was uploaded with HTTP_POST
        $checkSafeUpload = is_uploaded_file($fileToUpload["tmp_name"]);

        // Upload the file
        $moveUploadedFile = move_uploaded_file($fileToUpload["tmp_name"], $filePath);

        if ($checkSafeUpload && $moveUploadedFile) {
            $output = [
                'filename' => substr($filePath, strlen(PUBLIC_PATH)),
                'size' => $fileToUpload["size"],
                'ext' => $this->getMimeType,
            ];
            //$output = realpath($filePath);
            return $output;
        } else {
            throw new ImageUploaderException(" File could not be uploaded. Unknown error occurred. ");
        }
    }
}