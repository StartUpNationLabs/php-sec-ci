<?php

namespace Tests\Unit;

use App\ImageCreator;
use PHPUnit\Framework\TestCase;

class ImageCreatorTest extends TestCase
{
    /**
     * Set up test environment
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        // Ensure we can capture image output
        ob_start();
    }

    /**
     * Clean up test environment
     *
     * @return void
     */
    protected function tearDown(): void
    {
        ob_end_clean();
        parent::tearDown();
    }

    /**
     * Test constructor with default values
     *
     * @covers \App\ImageCreator
     * @return void
     */
    public function test_constructor_with_default_values()
    {
        $imageCreator = new ImageCreator();
        $this->assertInstanceOf(ImageCreator::class, $imageCreator);
    }

    /**
     * Test constructor with custom color and text values
     *
     * @covers \App\ImageCreator
     * @return void
     */
    public function test_constructor_with_custom_values()
    {
        $imageCreator = new ImageCreator(
            [255, 0, 0], // Red
            [0, 255, 0], // Green
            "TEST",
            "Custom Text"
        );
        $this->assertInstanceOf(ImageCreator::class, $imageCreator);
    }

    /**
     * Test that createImage generates valid PNG output
     *
     * @covers \App\ImageCreator
     * @return void
     */
    public function test_create_image_generates_png()
    {
        $imageCreator = new ImageCreator();
        $imageCreator->createImage();

        $output = ob_get_contents();

        // Check if the output starts with PNG signature
        $this->assertEquals(
            "\x89\x50\x4E\x47", // PNG file signature
            substr($output, 0, 4)
        );
    }

    /**
     * Test constructor behavior with APP_SECRET environment variable set
     *
     * @covers \App\ImageCreator
     * @return void
     */
    public function test_constructor_with_app_secret()
    {
        $_ENV["APP_SECRET"] = "test-secret";

        $imageCreator = new ImageCreator(
            [128, 128, 128],
            [60, 80, 57],
            "TEST",
            "Test Text"
        );

        $this->assertInstanceOf(ImageCreator::class, $imageCreator);

        unset($_ENV["APP_SECRET"]);
    }

    /**
     * Test that invalid color values throw TypeError
     *
     * @covers \App\ImageCreator
     * @return void
     */
    public function test_create_image_with_invalid_color_values()
    {
        $this->expectException(\TypeError::class);

        new ImageCreator(["invalid", "color", "values"], [60, 80, 57]);
    }

    /**
     * Test that the required font file exists
     *
     * @covers \App\ImageCreator
     * @return void
     */
    public function test_font_file_exists()
    {
        $imageCreator = new ImageCreator();
        $reflectionClass = new \ReflectionClass($imageCreator);
        $fontProperty = $reflectionClass->getProperty("font");
        $fontProperty->setAccessible(true);

        $this->assertFileExists($fontProperty->getValue($imageCreator));
    }
}
