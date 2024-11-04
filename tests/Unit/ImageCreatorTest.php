<?php

namespace Tests\Unit;

use App\ImageCreator;
use PHPUnit\Framework\TestCase;

class ImageCreatorTest extends TestCase
{
    /** @var ImageCreator */
    private $imageCreator;

    /**
     * Set up test environment
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->imageCreator = new ImageCreator(
            [128, 128, 128], // color1
            [60, 80, 57], // color2
            "DEVOPS", // text1
            "Une superbe image" // text2
        );
    }

    /**
     * Test ImageCreator object construction
     *
     * @return void
     */
    public function testImageCreatorConstruction(): void
    {
        $this->assertInstanceOf(ImageCreator::class, $this->imageCreator);
    }

    /**
     * Test color validation with invalid RGB values
     *
     * @return void
     */
    public function testColorValidation(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        new ImageCreator(
            [300, 128, 128], // Invalid RGB value (>255)
            [60, 80, 57],
            "DEVOPS",
            "Une superbe image"
        );
    }

    /**
     * Test validation of empty text input
     *
     * @return void
     */
    public function testTextNotEmpty(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        new ImageCreator(
            [128, 128, 128],
            [60, 80, 57],
            "", // Empty text
            "Une superbe image"
        );
    }

    /**
     * Test that createImage returns proper GD resource
     *
     * @return void
     */
    public function testCreateImageReturnsResource(): void
    {
        $result = $this->imageCreator->createImage();

        // Check if the result is a GD image resource or a GdImage object (PHP 8+)
        if (PHP_VERSION_ID >= 80000) {
            $this->assertInstanceOf(\GdImage::class, $result);
        } else {
            $this->assertTrue(is_resource($result));
            $this->assertEquals("gd", get_resource_type($result));
        }
    }

    /**
     * Test image dimensions are correct
     *
     * @return void
     */
    public function testImageDimensions(): void
    {
        $image = $this->imageCreator->createImage();

        // Assuming the image dimensions are fixed in your implementation
        // Adjust these values according to your actual implementation
        $this->assertEquals(400, imagesx($image)); // width
        $this->assertEquals(300, imagesy($image)); // height
    }

    /**
     * Clean up test environment
     *
     * @return void
     */
    protected function tearDown(): void
    {
        parent::tearDown();
        unset($this->imageCreator);
    }
}
