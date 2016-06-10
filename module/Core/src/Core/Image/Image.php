<?php
namespace Core\Image;

use Imagine\Image\AbstractImagine;
use Imagine\Image\ImageInterface;
use Imagine\Image\Box;

class Image implements \Image\Service\ImageInterface
{
    protected $imagine;

    /**
     * Construct
     * @param \Image\Service\AbstractImagine $imagine
     */
    public function __construct(AbstractImagine $imagine)
    {
        $this->imagine = $imagine;
    }

    /**
     * Resize an image
     * @param  string  $url
     * @param  integer $width
     * @param  integer $height
     * @param  boolean $crop
     * @return string
     */
    public function resize($url, $width = 100, $height = null, $crop = false, $quality = 90)
    {
        if (!$url) {
            return null;
        }

        # URL info
        $info = pathinfo($url);

        # Original Size
        $size = getimagesize($url);

        # Directories and file names
        $fileName       = $info['basename'];
        $sourceDirPath  = $info['dirname'];
        $sourceFilePath = $sourceDirPath . '/' . $fileName;
        $targetDirName  = $width.($height ? 'x'.$height : '').($crop ? '_crop' : '');
        $targetDirPath  = $sourceDirPath . '/' . $targetDirName . '/';
        $targetFilePath = $targetDirPath . $fileName;
        $targetUrl      = $info['dirname'] . '/' . $targetDirName . '/' . $fileName;

        # The auto size
        if (!$height) {
            $height = $this->autoResize($size[0], $size[1], $width);
        }

        # Create directory if missing
        try {
            # Create dir if missing
            if (!is_dir($targetDirPath) and $targetDirPath) {
                mkdir($targetDirPath, 0755, true);
            }

            # Set the size
            $size = new Box($width, $height);

            # Now the mode
            $mode = $crop ? ImageInterface::THUMBNAIL_OUTBOUND : ImageInterface::THUMBNAIL_INSET;

            if (file_exists($targetFilePath)) {
                unlink($targetFilePath);
            }

            if (!file_exists($targetFilePath) or (filemtime($targetFilePath) < filemtime($sourceFilePath))) {
                $this->imagine->open($sourceFilePath)
                              ->thumbnail($size, $mode)
                              ->save($targetFilePath, array('quality' => $quality));
            }
        } catch (\Exception $ex) {
            throw $ex;
        }
        return $targetUrl;
    }

    /**
    * Helper for creating thumbs
    * @param string $url
    * @param integer $width
    * @param integer $height
    * @return string
    */
    public function thumb($url, $width, $height = null)
    {
        return $this->resize($url, $width, $height, true);
    }

    /**
     * Creates image dimensions based on a configuration
     * @param  string $url
     * @param  array  $dimensions
     * @return void
     */
    public function createDimensions($url, $dimensions = array())
    {
        if (count($dimensions) < 1) {
            array_push($dimensions, array('width' => '900', 'height' => null, 'crop' => false, 'quality' => null));
        }
        foreach ($dimensions as $dimension) {
            $this->resize($url, $dimension['width'], $dimension['height'], $dimension['crop'], $dimension['quality']);
        }
    }

    /**
     * Return the auto height of image
     * @param type $width
     * @param type $heigth
     * @param type $new
     * @return type
     */
    public function autoResize($width, $heigth, $new)
    {
        return (int)(($heigth/$width) * $new);
    }
}
