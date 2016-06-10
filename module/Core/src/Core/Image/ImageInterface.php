<?php
namespace Core\Image;

use Imagine\Image\AbstractImagine;

interface ImageInterface
{
    /**
     * Construct
     * @param \Image\Service\AbstractImagine $imagine
     */
    public function __construct(AbstractImagine $imagine);

    /**
     * Resize an image
     * @param  string  $url
     * @param  integer $width
     * @param  integer $height
     * @param  boolean $crop
     * @return string
     */
    public function resize($url, $width = 100, $height = null, $crop = false, $quality = 90);

    /**
    * Helper for creating thumbs
    * @param string $url
    * @param integer $width
    * @param integer $height
    * @return string
    */
    public function thumb($url, $width, $height = null);

    /**
     * Creates image dimensions based on a configuration
     * @param  string $url
     * @param  array  $dimensions
     * @return void
     */
    public function createDimensions($url, $dimensions = array());
}
